<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Comment;
use App\Models\File;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
	public function run(): void
	{
		$agencyUsers = User::whereHas('agencyUser')->get();

		Project::latest()
			->limit(6)
			->get()
			->each(function (Project $project, int $index) use ($agencyUsers) {
				Activity::create([
					'user_id' => $agencyUsers[$index % $agencyUsers->count()]->id,
					'type' => 'project.created',
					'subject_type' => Project::class,
					'subject_id' => $project->id,
					'metadata' => [
						'name' => $project->name,
					],
					'created_at' => now()->subDays(12 - $index),
					'updated_at' => now()->subDays(12 - $index),
				]);
			});

		Task::whereNotNull('completed_at')
			->limit(10)
			->get()
			->each(function (Task $task, int $index) {
				Activity::create([
					'user_id' => $task->assigned_to,
					'type' => 'task.completed',
					'subject_type' => Task::class,
					'subject_id' => $task->id,
					'metadata' => [
						'title' => $task->title,
					],
					'created_at' => now()->subDays($index),
					'updated_at' => now()->subDays($index),
				]);
			});

		Comment::latest()
			->limit(8)
			->get()
			->each(function (Comment $comment, int $index) {
				Activity::create([
					'user_id' => $comment->user_id,
					'type' => 'comment.created',
					'subject_type' => Comment::class,
					'subject_id' => $comment->id,
					'metadata' => [
						'task_id' => $comment->task_id,
					],
					'created_at' => now()->subHours($index + 2),
					'updated_at' => now()->subHours($index + 2),
				]);
			});

		File::latest()
			->limit(8)
			->get()
			->each(function (File $file, int $index) {
				Activity::create([
					'user_id' => $file->uploaded_by,
					'type' => 'file.uploaded',
					'subject_type' => File::class,
					'subject_id' => $file->id,
					'metadata' => [
						'filename' => $file->original_name,
						'task_id' => $file->task_id,
					],
					'created_at' => now()->subHours($index + 1),
					'updated_at' => now()->subHours($index + 1),
				]);
			});
	}
}