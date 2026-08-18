<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileSeeder extends Seeder
{
	public function run(): void
	{
		$fileTemplates = [
			[
				'name' => 'project-brief.pdf',
				'mime_type' => 'application/pdf',
				'size' => 284000,
				'is_client_visible' => true,
			],
			[
				'name' => 'homepage-concept.jpg',
				'mime_type' => 'image/jpeg',
				'size' => 1450000,
				'is_client_visible' => true,
			],
			[
				'name' => 'content-inventory.xlsx',
				'mime_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
				'size' => 97000,
				'is_client_visible' => false,
			],
			[
				'name' => 'analytics-report.pdf',
				'mime_type' => 'application/pdf',
				'size' => 618000,
				'is_client_visible' => true,
			],
			[
				'name' => 'design-assets.zip',
				'mime_type' => 'application/zip',
				'size' => 3200000,
				'is_client_visible' => false,
			],
			[
				'name' => 'requirements.docx',
				'mime_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
				'size' => 143000,
				'is_client_visible' => true,
			],
		];

		Task::with('project')
			->inRandomOrder()
			->limit(25)
			->get()
			->each(function (Task $task, int $index) use ($fileTemplates) {
				$template = $fileTemplates[$index % count($fileTemplates)];

				$storedName = Str::uuid() . '-' . $template['name'];
				$path = 'task-files/' . $task->id . '/' . $storedName;

				Storage::disk('local')->put(
					$path,
					'AgencyOS seeded placeholder file for ' . $template['name']
				);

				File::create([
					'task_id' => $task->id,
					'uploaded_by' => $task->created_by,
					'name' => $storedName,
					'original_name' => $template['name'],
					'path' => $path,
					'mime_type' => $template['mime_type'],
					'size' => $template['size'],
					'is_client_visible' => $template['is_client_visible'],
				]);
			});
	}
}