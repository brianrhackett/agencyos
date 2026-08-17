<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;
use App\Services\ActivityLogger;

use App\Enums\AgencyRole;
use App\Enums\ClientRole;

use App\Models\Client;
use App\Models\User;
use App\Models\Task;
use App\Models\Project;

class TeamController extends Controller
{
    public function index(Request $request)
	{
        $teamMembers = $this->_getTeamMembers($request);
        $teamMemberIds = $teamMembers->pluck('id');
        $teamMembers = $this->_getAdditionalData($teamMembers);
        $summaryCards = [
            [
                'title' => 'Team Members',
                'value' => $teamMembers->count(),
            ],
            [
                'title' => 'Assigned Projects',
                'value' => $this->_assignedProjects($teamMemberIds),
            ],
            [
                'title' => 'Tasks Due Today',
                'value' => $this->_tasksDueToday($teamMemberIds),
            ]
        ];

        return view('team.index', [
            'summaryCards' => $summaryCards,
            'teamMembers' => $teamMembers,
            'teamMembersCount' => $teamMembers->count(),
        ]);
    }

    public function create()
    {
        $this->authorize('create', User::class);

        //can use auth()->user because they are editing the same thing that they are
        $roles = auth()->user()->isAgencyUser() ?
                    AgencyRole::cases() :
                    ClientRole::cases();
        return view('team.create',[
            'roles' => $roles,
            'role' => ''
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],

            'role' => ['required'],
            'job_title' => ['nullable', 'string', 'max:255'],
        ]);

        $user = DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make(Str::random(32)),
            ]);

            if (auth()->user()->isAgencyUser()) {
                $user->agencyUser()->create([
                    'role' => $validated['role'],
                    'job_title' => $validated['job_title'] ?? null,
                ]);
            } else {
                $user->clients()->attach(auth()->user()->currentClient()->id, [
                    'role' => $validated['role'],
                    'job_title' => $validated['job_title'] ?? null,
                    'is_primary_contact' => false,
                ]);
            }

            return $user;
        });

        ActivityLogger::log(
            'team.created',
            $user,
            [
                'user_name' => $user->name,
            ]
        );

        Password::sendResetLink([
			'email' => $user->email,
		]);

        return redirect()
            ->route('team.show', $user)
            ->with('success', 'Team member added.');
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        $roles = $user->isAgencyUser() ?
                    AgencyRole::cases() :
                    ClientRole::cases();

        if ($user->agencyUser) {
            $role = $user->agencyUser->role->value;
            $jobTitle = $user->agencyUser->job_title;
        } else {
            $client = $user->clients()->first();

            $role = $client?->pivot->role;
            $jobTitle = $client?->pivot->job_title;
        }

        return view('team.edit', [
            'user' => $user,
            'role' => $role,
            'jobTitle' => $jobTitle,
            'roles' => $roles
        ]);
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        ActivityLogger::log(
            'team.updated',
            $user,
            [
                'user_name' => $user->name,
            ]
        );

        return redirect()
            ->route('team.show', $user)
            ->with('success', 'Team member updated.');
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        $user->load([
            'assignedTasks.project',
        ]);

        if ($user->agencyUser) {
            $role = $user->agencyUser->role->label();
            $jobTitle = $user->agencyUser->job_title;
        } else {
            $client = $user->clients()->first();

            $role = ClientRole::from($client->pivot->role)->label();
            $jobTitle = $client?->pivot->job_title;
        }

        return view('team.show', [
            'user' => $user,
            'role' => $role,
            'jobTitle' => $jobTitle
        ]);
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()
                ->route('team.index')
                ->with('error', 'You cannot delete your own account.');
        }
        $this->authorize('delete', $user);

        ActivityLogger::log(
            'team.deleted',
            $user,
            [
                'user_name' => $user->name,
            ]
        );

        $user->delete();

        return redirect()
            ->route('team.index')
            ->with('success', 'Team member deleted.');
    }

    public function sendPasswordReset(User $user)
    {
        $status = Password::sendResetLink([
            'email' => $user->email,
        ]);

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with(
                'success',
                'Password reset link sent to ' . $user->email . '.'
            );
        }

        return back()->with(
            'error',
            'Unable to send the password reset link.'
        );
    }

    private function _getTeamMembers($request)
    {
        $user = auth()->user();

        $client = $user->clients()->first();

        if ($client) {
            $query = $client->users()
                ->withPivot([
                    'job_title',
                    'is_primary_contact',
                ]);
        }
        else
        {
            $query = User::whereDoesntHave('clients');
        }

        $query->when($request->search, function ($query, $search) {
                $query->where('name', 'ilike', "%{$search}%");
            });

        return $query->paginate(5);
    }

    private function _getAdditionalData($teamMembers)
    {
        $teamMembers->getCollection()->transform(function ($member) {
            $openTasks = Task::where('assigned_to', $member->id)
                ->where('status', '!=', 'completed');

            return [
                'name' => $member->name,
                'email' => $member->email,
                'position' => $member->pivot?->job_title ?? $member->position ?? 'Agency Team',
                'role' => $member->pivot?->role ?? 'Team Member',
                'projects' => Project::whereHas('tasks', function ($query) use ($member) {
                    $query->where('assigned_to', $member->id)
                        ->where('status', '!=', 'completed');
                })->count(),

                'open_tasks' => (clone $openTasks)->count(),
                'user' => $member,
                'due_today' => (clone $openTasks)
                    ->whereDate('due_date', today())
                    ->count(),
            ];
        });

        return $teamMembers;
    }

    private function _assignedProjects($teamMemberIds)
    {
        return Project::whereHas('tasks', function ($query) use ($teamMemberIds) {
        	$query->whereIn('assigned_to', $teamMemberIds);
            })->count();
    }

    private function _tasksDueToday($teamMemberIds)
    {
        return Task::whereIn('assigned_to', $teamMemberIds)
            ->whereDate('due_date', today())
            ->where('status', '!=', 'completed')
            ->count();
    }
}
