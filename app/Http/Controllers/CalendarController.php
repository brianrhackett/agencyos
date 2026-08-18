<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Task;
use App\Models\Milestone;
use App\Models\Project;

use App\Enums\TaskStatus;

class CalendarController extends Controller
{
    public function index()
	{
        $currentMonth = request('month')
            ? Carbon::createFromFormat('Y-m', request('month'))->startOfMonth()
            : today()->startOfMonth();

        $calendarStart = $currentMonth->copy()
            ->startOfMonth()
            ->startOfWeek(Carbon::SUNDAY);

        $calendarEnd = $currentMonth->copy()
            ->endOfMonth()
            ->endOfWeek(Carbon::SATURDAY);

        $days = collect();

        $date = $calendarStart->copy();

        while ($date <= $calendarEnd) {
            $days->push($date->copy());
            $date->addDay();
        }


        $events = collect()
            ->merge($this->_getTaskEventsData($calendarStart, $calendarEnd))
            ->merge($this->_getMilestoneEventsData($calendarStart, $calendarEnd))
            ->merge($this->_getProjectEventsData($calendarStart, $calendarEnd))
            ->sortBy('date')
            ->values();

        $upcomingEvents = $events
            ->filter(fn ($event) => $event['date'] >= today()->toDateString())
            ->sortBy('date')
            ->take(4);

        return view('calendar.index', [
            'events' => $events,
            'upcomingEvents' => $upcomingEvents,
            'days' => $days,
            'currentMonth' => $currentMonth
        ]);
    }

    private function _getTaskEventsData($start, $end)
    {
        $user = auth()->user();
        $query = Task::with('project.client')
            ->visibleTo($user)
            ->whereBetween('due_date', [$start, $end]);

        return $query->get()
            ->map(function ($task) {
                return [
                    'title' => $task->title,
                    'type' => 'Task',
                    'variant' => 'border-stone-300 bg-stone-100 text-stone-700 dark:border-stone-700 dark:bg-stone-800 dark:text-stone-200',
                    'date' => $task->due_date->toDateString(),
                    'client' => $task->project->client->name,
                    'overdue' => $task->status !== TaskStatus::Completed
                        && $task->due_date->isPast(),
                    'url' => route('tasks.show', $task),
                ];
            });
    }

    private function _getMilestoneEventsData($start, $end)
    {
        $user = auth()->user();

        $query = Milestone::with('project.client')
            ->visibleTo($user)
            ->whereBetween('due_date', [$start, $end]);

        return $query->get()
            ->map(function ($milestone) {
                return [
                    'title' => $milestone->name,
                    'type' => 'Milestone',
                    'variant' => 'border-indigo-200 bg-indigo-50 text-indigo-700 dark:border-indigo-900 dark:bg-indigo-950 dark:text-indigo-300',
                    'date' => $milestone->due_date->toDateString(),
                    'client' => $milestone->project->client->name,
                    'overdue' => !$milestone->completed_at
                        && $milestone->due_date->isPast(),
                    'url' => route('milestones.show', $milestone),
                ];
            });
    }

    private function _getProjectEventsData($start, $end)
    {
        $user = auth()->user();

        $query = Project::with('client')
            ->visibleTo($user)
            ->whereBetween('due_date', [$start, $end])
            ->where('status', '!=', 'completed');

        return $query->get()
            ->map(function ($project) {
                return [
                    'title' => $project->name,
                    'type' => 'Project',
                    'variant' => 'border-amber-200 bg-amber-50 text-amber-700 dark:border-amber-900 dark:bg-amber-950 dark:text-amber-300',
                    'date' => $project->due_date->toDateString(),
                    'client' => $project->client->name,
                    'overdue' => $project->due_date->isPast(),
                    'url' => route('projects.show', $project),
                ];
            });        
    }
}
