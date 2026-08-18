<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
	public function run(): void
	{
		$agencyUsers = User::whereHas('agencyUser')->get();
		$clientUsers = User::whereHas('clients')->get();

		$comments = [
			'I have finished the first pass. Please take a look when you have a chance.',
			'The latest changes are ready for review.',
			'There are still a couple of items we need clarification on before this can move forward.',
			'This looks good from our side. I added a few notes for the next revision.',
			'Can we make sure this is included in the next client review?',
			'I tested this on desktop and mobile and did not find any additional issues.',
		];

		Task::inRandomOrder()
			->limit(30)
			->get()
			->each(function (Task $task, int $index) use (
				$agencyUsers,
				$clientUsers,
				$comments
			) {
				$agencyUser = $agencyUsers[$index % $agencyUsers->count()];

				Comment::create([
					'task_id' => $task->id,
					'user_id' => $agencyUser->id,
					'body' => $comments[$index % count($comments)],
					'is_internal' => $index % 4 === 0,
				]);

                $clientUsers = $task->project->client->users;

				if ($index % 3 === 0 && $clientUsers->isNotEmpty()) {
					$clientUser = $clientUsers[$index % $clientUsers->count()];

					Comment::create([
						'task_id' => $task->id,
						'user_id' => $clientUser->id,
						'body' => 'Thanks — reviewed this on our side and added our feedback.',
						'is_internal' => false,
					]);
				}
			});
	}
}