<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Client;
use App\Models\Comment;
use App\Models\File;
use App\Models\Milestone;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
	public function run(): void
	{
		Activity::query()->delete();

		$this->seedProjectActivities();
		$this->seedTaskActivities();
		$this->seedFileActivities();
		$this->seedMilestoneActivities();
		$this->seedClientUserActivities();
		$this->seedTeamActivities();
	}

	private function seedProjectActivities(): void
	{
		Project::with('client')
			->limit(6)
			->get()
			->each(function (Project $project, int $index) {
				$user = $this->agencyUser($index);

				Activity::create([
					'user_id' => $user->id,
					'type' => 'project.created',
					'subject_type' => Project::class,
					'subject_id' => $project->id,
					'metadata' => [
						'project_name' => $project->name,
						'client_name' => $project->client->name,
					],
					'created_at' => now()->subDays(14 - $index),
					'updated_at' => now()->subDays(14 - $index),
				]);
			});

		$project = Project::with('client')
			->whereNotNull('completed_at')
			->first();

		if ($project) {
			Activity::create([
				'user_id' => $this->agencyUser()->id,
				'type' => 'project.completed',
				'subject_type' => Project::class,
				'subject_id' => $project->id,
				'metadata' => [
					'project_name' => $project->name,
					'client_name' => $project->client->name,
				],
				'created_at' => now()->subDays(7),
				'updated_at' => now()->subDays(7),
			]);
		}
	}

	private function seedTaskActivities(): void
	{
		Task::with('project.client')
			->whereNotNull('completed_at')
			->limit(8)
			->get()
			->each(function (Task $task, int $index) {
				Activity::create([
					'user_id' => $task->assigned_to ?? $this->agencyUser($index)->id,
					'type' => 'task.completed',
					'subject_type' => Task::class,
					'subject_id' => $task->id,
					'metadata' => [
						'task_name' => $task->title,
						'project_name' => $task->project->name,
						'client_name' => $task->project->client->name,
					],
					'created_at' => now()->subDays(6)->addHours($index),
					'updated_at' => now()->subDays(6)->addHours($index),
				]);
			});

		Comment::with('task.project.client')
			->latest()
			->limit(10)
			->get()
			->each(function (Comment $comment, int $index) {
				$task = $comment->task;

				Activity::create([
					'user_id' => $comment->user_id,
					'type' => 'task.commented',
					'subject_type' => Task::class,
					'subject_id' => $task->id,
					'metadata' => [
						'task_name' => $task->title,
						'project_name' => $task->project->name,
						'client_name' => $task->project->client->name,
					],
					'created_at' => now()->subDays(4)->addHours($index),
					'updated_at' => now()->subDays(4)->addHours($index),
				]);
			});

		Task::with('project.client')
			->where('status', 'in_progress')
			->limit(4)
			->get()
			->each(function (Task $task, int $index) {
				Activity::create([
					'user_id' => $task->assigned_to ?? $this->agencyUser($index)->id,
					'type' => 'task.updated',
					'subject_type' => Task::class,
					'subject_id' => $task->id,
					'metadata' => [
						'task_name' => $task->title,
						'project_name' => $task->project->name,
						'client_name' => $task->project->client->name,
					],
					'created_at' => now()->subDays(2)->addHours($index),
					'updated_at' => now()->subDays(2)->addHours($index),
				]);
			});
	}

	private function seedFileActivities(): void
	{
		File::with('task.project')
			->latest()
			->limit(8)
			->get()
			->each(function (File $file, int $index) {
				Activity::create([
					'user_id' => $file->uploaded_by,
					'type' => 'file.uploaded',
					'subject_type' => File::class,
					'subject_id' => $file->id,
					'metadata' => [
						'task_name' => $file->task->title,
						'project_name' => $file->task->project->name,
					],
					'created_at' => now()->subDays(3)->addHours($index),
					'updated_at' => now()->subDays(3)->addHours($index),
				]);
			});
	}

	private function seedMilestoneActivities(): void
	{
		Milestone::whereNotNull('completed_at')
			->limit(6)
			->get()
			->each(function (Milestone $milestone, int $index) {
				Activity::create([
					'user_id' => $this->agencyUser($index)->id,
					'type' => 'milestone.completed',
					'subject_type' => Milestone::class,
					'subject_id' => $milestone->id,
					'metadata' => [
						'milestone_name' => $milestone->name,
					],
					'created_at' => now()->subDays(10 - $index),
					'updated_at' => now()->subDays(10 - $index),
				]);
			});
	}

	private function seedClientUserActivities(): void
	{
		Client::with('users')
			->get()
			->each(function (Client $client, int $clientIndex) {
				$client->users
					->take(2)
					->each(function (User $clientUser, int $index) use ($client, $clientIndex) {
						Activity::create([
							'user_id' => $this->agencyUser($clientIndex)->id,
							'type' => 'client_user.added',
							'subject_type' => User::class,
							'subject_id' => $clientUser->id,
							'metadata' => [
								'user_name' => $clientUser->name,
								'client_name' => $client->name,
							],
							'created_at' => now()
								->subDays(12)
								->addHours(($clientIndex * 2) + $index),
							'updated_at' => now()
								->subDays(12)
								->addHours(($clientIndex * 2) + $index),
						]);
					});
			});
	}

	private function seedTeamActivities(): void
	{
		User::whereHas('agencyUser')
			->whereHas('agencyUser', function ($query) {
				$query->where('role', '!=', 'super_admin');
			})
			->limit(5)
			->get()
			->each(function (User $teamMember, int $index) {
				Activity::create([
					'user_id' => $this->agencyUser()->id,
					'type' => 'team.added',
					'subject_type' => User::class,
					'subject_id' => $teamMember->id,
					'metadata' => [
						'user_name' => $teamMember->name,
					],
					'created_at' => now()->subDays(20 - $index),
					'updated_at' => now()->subDays(20 - $index),
				]);
			});
	}

	private function agencyUser(int $index = 0): User
	{
		$users = User::whereHas('agencyUser')
			->orderBy('id')
			->get();

		return $users[$index % $users->count()];
	}
}