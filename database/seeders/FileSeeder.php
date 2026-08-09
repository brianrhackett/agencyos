<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class FileSeeder extends Seeder
{
	public function run(): void
	{
		$tasks = Task::all();
		$users = User::all();

		if ($tasks->isEmpty() || $users->isEmpty()) {
			return;
		}

		$files = [
			[
				'name' => 'homepage-wireframes-v3.pdf',
				'mime_type' => 'application/pdf',
				'size' => 4_800_000,
			],
			[
				'name' => 'product-photography.zip',
				'mime_type' => 'application/zip',
				'size' => 186_000_000,
			],
			[
				'name' => 'brand-guidelines.pdf',
				'mime_type' => 'application/pdf',
				'size' => 12_400_000,
			],
			[
				'name' => 'dashboard-mockup.png',
				'mime_type' => 'image/png',
				'size' => 2_100_000,
			],
			[
				'name' => 'content-inventory.xlsx',
				'mime_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
				'size' => 742_000,
			],
			[
				'name' => 'seo-audit-final.docx',
				'mime_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
				'size' => 1_300_000,
			],
		];

		foreach ($files as $index => $file) {
			File::create([
				'task_id' => $tasks->random()->id,
				'uploaded_by' => $users->random()->id,
				'name' => $file['name'],
				'original_name' => $file['name'],
				'path' => 'uploads/' . $file['name'],
				'mime_type' => $file['mime_type'],
				'size' => $file['size'],
				'is_client_visible' => $index % 2 === 0,
			]);
		}
	}
}