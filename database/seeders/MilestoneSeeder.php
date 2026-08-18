<?php

namespace Database\Seeders;

use App\Enums\MilestoneStatus;
use App\Enums\ProjectStatus;
use App\Models\Milestone;
use App\Models\Project;
use Illuminate\Database\Seeder;

class MilestoneSeeder extends Seeder
{
	public function run(): void
	{
		Project::where('status', '!=', ProjectStatus::Completed->value)
			->get()
			->each(function (Project $project) {
				$milestones = [
					[
						'name' => 'Discovery & Planning',
						'description' => 'Requirements gathering, research, planning, and project definition.',
						'status' => MilestoneStatus::Completed->value,
						'sort_order' => 1,
						'start_date' => $project->start_date,
						'due_date' => now()->subWeeks(2),
						'completed_at' => now()->subWeeks(2),
					],
					[
						'name' => 'Design & Content',
						'description' => 'Design exploration, content preparation, review, and approval.',
						'status' => MilestoneStatus::InProgress->value,
						'sort_order' => 2,
						'start_date' => now()->subWeek(),
						'due_date' => now()->addWeeks(3),
						'completed_at' => null,
					],
					[
						'name' => 'Development & QA',
						'description' => 'Implementation, integrations, testing, accessibility, and quality assurance.',
						'status' => MilestoneStatus::NotStarted->value,
						'sort_order' => 3,
						'start_date' => now()->addWeeks(3),
						'due_date' => $project->due_date,
						'completed_at' => null,
					],
				];

				foreach ($milestones as $data) {
					Milestone::updateOrCreate(
						[
							'project_id' => $project->id,
							'name' => $data['name'],
						],
						$data
					);
				}
			});

		$completedProject = Project::where(
			'status',
			ProjectStatus::Completed->value
		)->first();

		if ($completedProject) {
			foreach ([
				'Discovery & Strategy',
				'UX & Visual Design',
				'Development',
				'Launch',
			] as $index => $name) {
				Milestone::updateOrCreate(
					[
						'project_id' => $completedProject->id,
						'name' => $name,
					],
					[
						'description' => 'Completed project milestone.',
						'status' => MilestoneStatus::Completed->value,
						'sort_order' => $index + 1,
						'start_date' => $completedProject->start_date,
						'due_date' => $completedProject->completed_at,
						'completed_at' => $completedProject->completed_at,
					]
				);
			}
		}
	}
}