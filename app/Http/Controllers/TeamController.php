<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use App\Models\Client;
use App\Models\User;
use App\Models\Task;
use App\Models\Project;

class TeamController extends Controller
{
    public function index()
	{
        $teamMembers = $this->_getTeamMembers();
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
        return view('team.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'position' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'position' => $validated['position'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        ActivityLogger::log(
            'team.created',
            $user,
            [
                'user_name' => $user->name,
            ]
        );

        return redirect()
            ->route('team.show', $user)
            ->with('success', 'Team member added.');
    }

    public function edit(User $user)
    {
        return view('team.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'position' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'position' => $validated['position'] ?? null,
        ]);

        if (!empty($validated['password'])) {
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

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
        $user->load([
            'assignedTasks.project',
        ]);

        return view('team.show', compact('user'));
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()
                ->route('team.index')
                ->with('error', 'You cannot delete your own account.');
        }

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

    private function _getTeamMembers()
    {
        $user = auth()->user();

        $client = $user->clients()->first();

        if ($client) {
            return $client->users()
                ->withPivot([
                    'job_title',
                    'is_primary_contact',
                ])
                ->paginate(5);
        }

        return User::whereDoesntHave('clients')
            ->paginate(5);
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
