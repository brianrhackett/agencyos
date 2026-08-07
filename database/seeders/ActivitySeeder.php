<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
	public function run(): void
	{
		$users = User::take(4)->get();

		Activity::create([
			'user_id' => $users->get(0)?->id,
			'type' => 'task_completed',
			'subject_type' => 'task',
			'subject_id' => 1,
			'metadata' => [
				'task_name' => 'Homepage Design',
				'client_name' => 'Acme Corporation',
			],
			'created_at' => now()->subMinutes(12),
		]);

		Activity::create([
			'user_id' => $users->get(1)?->id,
			'type' => 'files_uploaded',
			'subject_type' => 'project',
			'subject_id' => 2,
			'metadata' => [
				'file_count' => 3,
				'project_name' => 'Marketing Site Refresh',
			],
			'created_at' => now()->subMinutes(43),
		]);

		Activity::create([
			'user_id' => $users->get(2)?->id,
			'type' => 'comment_added',
			'subject_type' => 'task',
			'subject_id' => 3,
			'metadata' => [
				'task_name' => 'Website Launch',
			],
			'created_at' => now()->subHours(2),
		]);

		Activity::create([
			'user_id' => null,
			'type' => 'milestone_completed',
			'subject_type' => 'milestone',
			'subject_id' => 1,
			'metadata' => [
				'milestone_name' => 'Content Delivery',
			],
			'created_at' => now()->subDay(),
		]);

		Activity::create([
			'user_id' => $users->get(3)?->id,
			'type' => 'client_user_added',
			'subject_type' => 'client',
			'subject_id' => 1,
			'metadata' => [
				'user_name' => 'Olivia Wilson',
				'client_name' => 'Wave Industries',
			],
			'created_at' => now()->subDay()->subHours(2),
		]);
	}
}