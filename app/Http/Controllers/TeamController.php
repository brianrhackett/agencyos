<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
                'title' => 'TaskDueToday',
                'value' => $this->_tasksDueToday($teamMemberIds),
            ]
        ];

        //die('<pre>'.print_r($teamMembers,1));
        return view('team.index', [
            'summaryCards' => $summaryCards,
            'teamMembers' => $teamMembers,
            'teamMembersCount' => $teamMembers->count(),
        ]);
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
                'position' => $member->pivot?->job_title ?? 'Agency Team',
                'role' => $member->pivot?->role ?? 'Team Member',
                'projects' => Project::whereHas('tasks', function ($query) use ($member) {
                    $query->where('assigned_to', $member->id)
                        ->where('status', '!=', 'completed');
                })->count(),

                'open_tasks' => (clone $openTasks)->count(),

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
