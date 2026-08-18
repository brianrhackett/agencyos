<?php

namespace Database\Seeders;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Milestone;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
	public function run(): void
	{
		$taskTemplates = [
			'Discovery & Planning' => [
				[
					'title' => 'Review project requirements',
					'description' => 'Review the initial project requirements and identify any outstanding questions.',
					'status' => TaskStatus::Completed,
					'priority' => TaskPriority::Normal,
					'estimated_hours' => 3,
					'actual_hours' => 2.5,
					'due_offset' => -21,
				],
				[
					'title' => 'Interview key stakeholders',
					'description' => 'Meet with key stakeholders to understand business goals, requirements, and constraints.',
					'status' => TaskStatus::Completed,
					'priority' => TaskPriority::Normal,
					'estimated_hours' => 4,
					'actual_hours' => 4,
					'due_offset' => -18,
				],
				[
					'title' => 'Document technical requirements',
					'description' => 'Document technical requirements, integrations, dependencies, and implementation considerations.',
					'status' => TaskStatus::Completed,
					'priority' => TaskPriority::High,
					'estimated_hours' => 5,
					'actual_hours' => 6,
					'due_offset' => -14,
				],
				[
					'title' => 'Approve project scope',
					'description' => 'Review the finalized scope and confirm project deliverables before moving into design.',
					'status' => TaskStatus::Completed,
					'priority' => TaskPriority::High,
					'estimated_hours' => 2,
					'actual_hours' => 1.5,
					'due_offset' => -12,
				],
			],

			'Design & Content' => [
				[
					'title' => 'Create initial design concepts',
					'description' => 'Develop initial visual concepts based on the approved project direction.',
					'status' => TaskStatus::Completed,
					'priority' => TaskPriority::High,
					'estimated_hours' => 12,
					'actual_hours' => 11,
					'due_offset' => -5,
				],
				[
					'title' => 'Prepare content inventory',
					'description' => 'Review existing content and identify content that should be retained, revised, or replaced.',
					'status' => TaskStatus::InProgress,
					'priority' => TaskPriority::Normal,
					'estimated_hours' => 6,
					'actual_hours' => 3,
					'due_offset' => 2,
				],
				[
					'title' => 'Review designs with client',
					'description' => 'Present the latest design concepts to the client and collect consolidated feedback.',
					'status' => TaskStatus::InReview,
					'priority' => TaskPriority::High,
					'estimated_hours' => 3,
					'actual_hours' => 2,
					'due_offset' => 0,
				],
				[
					'title' => 'Implement design revisions',
					'description' => 'Incorporate approved client feedback into the final design direction.',
					'status' => TaskStatus::ToDo,
					'priority' => TaskPriority::Normal,
					'estimated_hours' => 8,
					'actual_hours' => null,
					'due_offset' => 7,
				],
				[
					'title' => 'Finalize content for development',
					'description' => 'Prepare approved page content and assets for the development phase.',
					'status' => TaskStatus::ToDo,
					'priority' => TaskPriority::Normal,
					'estimated_hours' => 5,
					'actual_hours' => null,
					'due_offset' => 10,
				],
			],

			'Development & QA' => [
				[
					'title' => 'Build primary page templates',
					'description' => 'Implement the primary page templates based on the approved designs.',
					'status' => TaskStatus::InProgress,
					'priority' => TaskPriority::High,
					'estimated_hours' => 16,
					'actual_hours' => 7,
					'due_offset' => 7,
				],
				[
					'title' => 'Implement required integrations',
					'description' => 'Connect required third-party services and application integrations.',
					'status' => TaskStatus::ToDo,
					'priority' => TaskPriority::High,
					'estimated_hours' => 10,
					'actual_hours' => null,
					'due_offset' => 12,
				],
				[
					'title' => 'Complete accessibility audit',
					'description' => 'Review primary interfaces for keyboard navigation, contrast, labels, and semantic structure.',
					'status' => TaskStatus::ToDo,
					'priority' => TaskPriority::Normal,
					'estimated_hours' => 5,
					'actual_hours' => null,
					'due_offset' => 16,
				],
				[
					'title' => 'Perform cross-browser QA',
					'description' => 'Test supported browsers and devices and document any issues requiring correction.',
					'status' => TaskStatus::ToDo,
					'priority' => TaskPriority::Normal,
					'estimated_hours' => 6,
					'actual_hours' => null,
					'due_offset' => 20,
				],
				[
					'title' => 'Prepare production launch',
					'description' => 'Complete the final launch checklist and prepare the project for production deployment.',
					'status' => TaskStatus::ToDo,
					'priority' => TaskPriority::High,
					'estimated_hours' => 4,
					'actual_hours' => null,
					'due_offset' => 25,
				],
			],

			'Discovery & Strategy' => [
				[
					'title' => 'Audit existing website',
					'description' => 'Review the existing website structure, content, analytics, and technical implementation.',
				],
				[
					'title' => 'Define project goals',
					'description' => 'Document business objectives and measurable goals for the redesign.',
				],
				[
					'title' => 'Approve site architecture',
					'description' => 'Finalize and approve the proposed information architecture.',
				],
			],

			'UX & Visual Design' => [
				[
					'title' => 'Create wireframes',
					'description' => 'Create wireframes for primary page templates and user flows.',
				],
				[
					'title' => 'Design homepage',
					'description' => 'Create the approved visual design for the homepage.',
				],
				[
					'title' => 'Design interior templates',
					'description' => 'Create visual designs for primary interior page templates.',
				],
				[
					'title' => 'Approve final designs',
					'description' => 'Complete client review and obtain approval for the final visual direction.',
				],
			],

			'Development' => [
				[
					'title' => 'Build front-end templates',
					'description' => 'Implement responsive front-end templates from the approved designs.',
				],
				[
					'title' => 'Configure CMS',
					'description' => 'Configure content management functionality and editable content areas.',
				],
				[
					'title' => 'Migrate website content',
					'description' => 'Migrate approved content from the existing website.',
				],
				[
					'title' => 'Complete development QA',
					'description' => 'Perform development QA and resolve identified issues.',
				],
			],

			'Launch' => [
				[
					'title' => 'Complete pre-launch checklist',
					'description' => 'Review analytics, redirects, forms, metadata, backups, and production configuration.',
				],
				[
					'title' => 'Deploy production website',
					'description' => 'Deploy the approved website to the production environment.',
				],
				[
					'title' => 'Perform post-launch QA',
					'description' => 'Verify critical functionality and content after production deployment.',
				],
			],
		];

		$agencyUsers = User::whereHas('agencyUser')->get();

		Milestone::with('project')
			->get()
			->each(function (Milestone $milestone) use ($taskTemplates, $agencyUsers) {
				$templates = $taskTemplates[$milestone->name] ?? [];

				if (empty($templates)) {
					return;
				}

				$teamIds = DB::table('project_user')
					->where('project_id', $milestone->project_id)
					->pluck('user_id');

				$team = $agencyUsers
					->whereIn('id', $teamIds)
					->values();

				if ($team->isEmpty()) {
					return;
				}

				foreach ($templates as $index => $template) {
					$assignee = $team[$index % $team->count()];
					$creator = $team->first();

					$isCompletedProject = $milestone->project->status->value === 'completed';

					$status = $isCompletedProject
						? TaskStatus::Completed
						: ($template['status'] ?? TaskStatus::Completed);

					$priority = $template['priority'] ?? TaskPriority::Normal;

					$dueDate = $isCompletedProject
						? $milestone->due_date
						: now()->addDays($template['due_offset'] ?? -30);

					$completedAt = $status === TaskStatus::Completed
						? ($isCompletedProject
							? $milestone->completed_at
							: now()->subDays(5))
						: null;

					Task::updateOrCreate(
						[
							'project_id' => $milestone->project_id,
							'milestone_id' => $milestone->id,
							'title' => $template['title'],
						],
						[
							'assigned_to' => $assignee->id,
							'created_by' => $creator->id,
							'description' => $template['description'],
							'status' => $status->value,
							'priority' => $priority->value,
							'estimated_hours' => $template['estimated_hours'] ?? rand(2, 12),
							'actual_hours' => $status === TaskStatus::Completed
								? ($template['actual_hours'] ?? rand(2, 10))
								: ($template['actual_hours'] ?? null),
							'start_date' => $milestone->start_date,
							'due_date' => $dueDate,
							'completed_at' => $completedAt,
						]
					);
				}
			});

		$this->createTestingScenarios();
	}

	private function createTestingScenarios(): void
	{
		// One genuinely overdue task.
		$task = Task::where('status', TaskStatus::InProgress->value)
			->first();

		if ($task) {
			$task->update([
				'title' => 'Resolve mobile navigation issues',
				'description' => 'Navigation is breaking at smaller breakpoints and must be corrected before client review.',
				'status' => TaskStatus::Blocked->value,
				'priority' => TaskPriority::High->value,
				'due_date' => now()->subDays(3),
				'completed_at' => null,
			]);
		}

		// One task due today and awaiting approval.
		$task = Task::where('status', TaskStatus::InReview->value)
			->first();

		if ($task) {
			$task->update([
				'title' => 'Approve revised homepage design',
				'description' => 'The revised homepage design is ready for final client approval.',
				'priority' => TaskPriority::High->value,
				'due_date' => today(),
			]);
		}

		// One high-priority task due tomorrow.
		$task = Task::where('status', TaskStatus::ToDo->value)
			->first();

		if ($task) {
			$task->update([
				'title' => 'Complete accessibility audit',
				'description' => 'Review primary templates for keyboard navigation, contrast, labels, and semantic structure.',
				'priority' => TaskPriority::High->value,
				'due_date' => today()->addDay(),
			]);
		}
	}
}