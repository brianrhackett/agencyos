<?php

namespace Database\Seeders;

use App\Enums\AgencyRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AgencyUserSeeder extends Seeder
{
	public function run(): void
	{
		$users = [
			[
				'name' => 'Brian Hackett',
				'email' => 'admin@agencyos.test',
				'role' => AgencyRole::SuperAdmin->value,
				'job_title' => 'Agency Owner',
			],
			[
				'name' => 'Rachel Bennett',
				'email' => 'rachel@agencyos.test',
				'role' => AgencyRole::Administrator->value,
				'job_title' => 'Director of Operations',
			],
			[
				'name' => 'Marcus Reed',
				'email' => 'marcus@agencyos.test',
				'role' => AgencyRole::Manager->value,
				'job_title' => 'Senior Project Manager',
			],
			[
				'name' => 'Emily Chen',
				'email' => 'emily@agencyos.test',
				'role' => AgencyRole::Manager->value,
				'job_title' => 'Digital Project Manager',
			],
			[
				'name' => 'Daniel Brooks',
				'email' => 'daniel@agencyos.test',
				'role' => AgencyRole::Member->value,
				'job_title' => 'Full-Stack Developer',
			],
			[
				'name' => 'Priya Shah',
				'email' => 'priya@agencyos.test',
				'role' => AgencyRole::Member->value,
				'job_title' => 'UX/UI Designer',
			],
			[
				'name' => 'Jordan Ellis',
				'email' => 'jordan@agencyos.test',
				'role' => AgencyRole::Member->value,
				'job_title' => 'SEO Strategist',
			],
		];

		foreach ($users as $data) {
			$user = User::updateOrCreate(
				['email' => $data['email']],
				[
					'name' => $data['name'],
					'password' => Hash::make('password'),
					'email_verified_at' => now(),
				]
			);

			DB::table('agency_users')->updateOrInsert(
				['user_id' => $user->id],
				[
					'role' => $data['role'],
					'job_title' => $data['job_title'],
					'created_at' => now(),
					'updated_at' => now(),
				]
			);
		}
	}
}