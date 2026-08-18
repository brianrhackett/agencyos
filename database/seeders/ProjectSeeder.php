<?php

namespace Database\Seeders;

use App\Enums\ProjectPriority;
use App\Enums\ProjectRole;
use App\Enums\ProjectStatus;
use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
	public function run(): void
	{
		$projects = [
			[
				'client' => 'Northstar Brewing Co.',
				'name' => 'E-commerce Website Redesign',
				'description' => 'Complete redesign of the brewery website with online ordering, product discovery, and improved mobile experience.',
				'status' => ProjectStatus::Active->value,
				'priority' => ProjectPriority::High->value,
				'budget' => 48000,
				'start_date' => now()->subMonths(2),
				'due_date' => now()->addMonths(2),
				'manager' => 'marcus@agencyos.test',
				'team' => [
					'daniel@agencyos.test' => ProjectRole::Member->value,
					'priya@agencyos.test' => ProjectRole::Member->value,
					'jordan@agencyos.test' => ProjectRole::Viewer->value,
				],
			],
			[
				'client' => 'Northstar Brewing Co.',
				'name' => 'Fall Campaign Landing Pages',
				'description' => 'Campaign landing pages and digital assets for the fall seasonal release.',
				'status' => ProjectStatus::Planning->value,
				'priority' => ProjectPriority::Normal->value,
				'budget' => 12000,
				'start_date' => now()->addWeeks(2),
				'due_date' => now()->addMonths(3),
				'manager' => 'emily@agencyos.test',
				'team' => [
					'priya@agencyos.test' => ProjectRole::Member->value,
					'jordan@agencyos.test' => ProjectRole::Member->value,
				],
			],
			[
				'client' => 'Harbor & Finch Law',
				'name' => 'Website & Brand Refresh',
				'description' => 'Modernize the firm website, visual identity, attorney profiles, and lead generation experience.',
				'status' => ProjectStatus::Active->value,
				'priority' => ProjectPriority::Normal->value,
				'budget' => 36000,
				'start_date' => now()->subMonth(),
				'due_date' => now()->addMonths(3),
				'manager' => 'emily@agencyos.test',
				'team' => [
					'daniel@agencyos.test' => ProjectRole::Member->value,
					'priya@agencyos.test' => ProjectRole::Member->value,
				],
			],
			[
				'client' => 'Harbor & Finch Law',
				'name' => 'SEO Retainer',
				'description' => 'Ongoing technical SEO, content optimization, reporting, and local search improvements.',
				'status' => ProjectStatus::Active->value,
				'priority' => ProjectPriority::Low->value,
				'budget' => 18000,
				'start_date' => now()->subMonths(5),
				'due_date' => now()->addMonths(7),
				'manager' => 'marcus@agencyos.test',
				'team' => [
					'jordan@agencyos.test' => ProjectRole::Member->value,
				],
			],
			[
				'client' => 'Summit Manufacturing',
				'name' => 'Dealer Portal',
				'description' => 'Authenticated dealer portal for product resources, pricing, documentation, and account tools.',
				'status' => ProjectStatus::Active->value,
				'priority' => ProjectPriority::High->value,
				'budget' => 78000,
				'start_date' => now()->subMonths(3),
				'due_date' => now()->addMonths(4),
				'manager' => 'marcus@agencyos.test',
				'team' => [
					'daniel@agencyos.test' => ProjectRole::Member->value,
				],
			],
			[
				'client' => 'Summit Manufacturing',
				'name' => 'Corporate Website Maintenance',
				'description' => 'Ongoing support, enhancements, accessibility fixes, and content updates.',
				'status' => ProjectStatus::OnHold->value,
				'priority' => ProjectPriority::Low->value,
				'budget' => 15000,
				'start_date' => now()->subMonths(6),
				'due_date' => now()->addMonths(6),
				'manager' => 'emily@agencyos.test',
				'team' => [
					'daniel@agencyos.test' => ProjectRole::Member->value,
				],
			],
			[
				'client' => 'Blue Ridge Outdoor Supply',
				'name' => 'Online Store Optimization',
				'description' => 'Conversion optimization, checkout improvements, product filtering, and performance enhancements.',
				'status' => ProjectStatus::Active->value,
				'priority' => ProjectPriority::Normal->value,
				'budget' => 29000,
				'start_date' => now()->subMonths(2),
				'due_date' => now()->addMonth(),
				'manager' => 'emily@agencyos.test',
				'team' => [
					'priya@agencyos.test' => ProjectRole::Member->value,
					'jordan@agencyos.test' => ProjectRole::Member->value,
				],
			],
			[
				'client' => 'Redwood Financial Partners',
				'name' => '2025 Website Redesign',
				'description' => 'Completed corporate website redesign and content migration.',
				'status' => ProjectStatus::Completed->value,
				'priority' => ProjectPriority::Normal->value,
				'budget' => 42000,
				'start_date' => now()->subYear(),
				'due_date' => now()->subMonths(6),
				'completed_at' => now()->subMonths(6),
				'manager' => 'marcus@agencyos.test',
				'team' => [
					'daniel@agencyos.test' => ProjectRole::Member->value,
					'priya@agencyos.test' => ProjectRole::Member->value,
				],
			],
		];

		foreach ($projects as $data) {
			$client = Client::where('name', $data['client'])->firstOrFail();
			$manager = User::where('email', $data['manager'])->firstOrFail();

			$project = Project::updateOrCreate(
				[
					'client_id' => $client->id,
					'name' => $data['name'],
				],
				[
					'project_manager_id' => $manager->id,
					'slug' => Str::slug($data['name']),
					'description' => $data['description'],
					'status' => $data['status'],
					'priority' => $data['priority'],
					'budget' => $data['budget'],
					'start_date' => $data['start_date'],
					'due_date' => $data['due_date'],
					'completed_at' => $data['completed_at'] ?? null,
				]
			);

			DB::table('project_user')->updateOrInsert(
				[
					'project_id' => $project->id,
					'user_id' => $manager->id,
				],
				[
					'role' => ProjectRole::Lead->value,
					'created_at' => now(),
					'updated_at' => now(),
				]
			);

			foreach ($data['team'] as $email => $role) {
				$user = User::where('email', $email)->firstOrFail();

				DB::table('project_user')->updateOrInsert(
					[
						'project_id' => $project->id,
						'user_id' => $user->id,
					],
					[
						'role' => $role,
						'created_at' => now(),
						'updated_at' => now(),
					]
				);
			}
		}
	}
}