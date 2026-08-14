<?php
namespace App\Http\Controllers;

use App\Models\Milestone;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Enums\MilestoneStatus;

class MilestoneController extends Controller
{
	public function create(Project $project)
	{
        $this->authorize('update', $project);

		return view('milestones.create', compact('project'));
	}

	public function store(Request $request, Project $project)
	{
        $this->authorize('update', $project);
        
		$validated = $request->validate([
			'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::enum(MilestoneStatus::class)],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'due_date' => ['nullable', 'date', 'after_or_equal:start_date'],
		]);

        if ($validated['status'] === MilestoneStatus::Completed->value) {
            $validated['completed_at'] = now();
        }

        $milestone = $project->milestones()->create($validated);

        ActivityLogger::log(
            'milestone.created',
            $milestone,
            [
				'milestone_name' => $milestone->name,
                'project_name' => $project->name,
                'client_name' => $project->client->name,
            ]
        );

        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Milestone created successfully.');
	}

	public function show(Milestone $milestone)
	{
        $this->authorize('view', $milestone);

		$milestone->load([
			'project.client',
			'tasks.assignedTo',
		]);

		return view('milestones.show', compact('milestone'));
	}

	public function edit(Milestone $milestone)
	{
        $this->authorize('update', $milestone);

		return view('milestones.edit', compact('milestone'));
	}

	public function update(Request $request, Milestone $milestone)
	{
        $this->authorize('update', $milestone);

		$validated = $request->validate([
			'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::enum(MilestoneStatus::class)],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'due_date' => ['nullable', 'date', 'after_or_equal:start_date'],
		]);

        if ($validated['status'] === MilestoneStatus::Completed->value && !$milestone->completed_at) {
            $validated['completed_at'] = now();

			$activityType = 'milestone.completed';
        }
		else
		{
			$activityType = 'milestone.updated';	
		}

        if ($validated['status'] !== MilestoneStatus::Completed->value) {
            $validated['completed_at'] = null;
        }

        $milestone->update($validated);

		ActivityLogger::log(
            $activityType,
            $milestone,
            [
				'milestone_name' => $milestone->name,
                'project_name' => $milestone->project->name,
                'client_name' => $milestone->project->client->name,
            ]
        );

        return redirect()
            ->route('projects.show', $milestone->project)
            ->with('success', 'Milestone updated successfully.');
	}

	public function destroy(Milestone $milestone)
	{
        $this->authorize('delete', $milestone);

		$project = $milestone->project;

		ActivityLogger::log(
            'milestone.deleted',
            $milestone,
            [
				'milestone_name' => $milestone->name,
                'project_name' => $project->name,
                'client_name' => $project->client->name,
            ]
        );

		$milestone->delete();

		return redirect()
			->route('projects.show', $project)
			->with('success', 'Milestone deleted successfully.');
	}
}