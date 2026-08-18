<?php

namespace Database\Seeders;

use App\Enums\ClientRole;
use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
	public function run(): void
	{
		$clients = [
			[
				'client' => [
					'name' => 'Northstar Brewing Co.',
					'website' => 'https://northstarbrewing.test',
					'email' => 'hello@northstarbrewing.test',
					'phone' => '412-555-0182',
					'address_line_one' => '812 Penn Avenue',
					'city' => 'Pittsburgh',
					'state' => 'PA',
					'postal_code' => '15222',
					'country' => 'United States',
					'notes' => 'Regional brewery expanding online sales and distribution.',
					'is_active' => true,
				],
				'users' => [
					[
						'name' => 'Sarah Whitmore',
						'email' => 'sarah@northstarbrewing.test',
						'role' => ClientRole::Administrator->value,
						'job_title' => 'Marketing Director',
						'is_primary_contact' => true,
					],
					[
						'name' => 'Ben Carter',
						'email' => 'ben@northstarbrewing.test',
						'role' => ClientRole::Approver->value,
						'job_title' => 'VP of Sales',
						'is_primary_contact' => false,
					],
					[
						'name' => 'Megan Foster',
						'email' => 'megan@northstarbrewing.test',
						'role' => ClientRole::Viewer->value,
						'job_title' => 'Marketing Coordinator',
						'is_primary_contact' => false,
					],
				],
			],

			[
				'client' => [
					'name' => 'Harbor & Finch Law',
					'website' => 'https://harborfinch.test',
					'email' => 'contact@harborfinch.test',
					'phone' => '216-555-0134',
					'address_line_one' => '1440 Lakeside Avenue',
					'city' => 'Cleveland',
					'state' => 'OH',
					'postal_code' => '44114',
					'country' => 'United States',
					'notes' => 'Mid-sized business and employment law firm.',
					'is_active' => true,
				],
				'users' => [
					[
						'name' => 'Laura Finch',
						'email' => 'laura@harborfinch.test',
						'role' => ClientRole::Administrator->value,
						'job_title' => 'Managing Partner',
						'is_primary_contact' => true,
					],
					[
						'name' => 'Nathan Cole',
						'email' => 'nathan@harborfinch.test',
						'role' => ClientRole::Member->value,
						'job_title' => 'Marketing Manager',
						'is_primary_contact' => false,
					],
				],
			],

			[
				'client' => [
					'name' => 'Summit Manufacturing',
					'website' => 'https://summitmfg.test',
					'email' => 'info@summitmfg.test',
					'phone' => '313-555-0198',
					'address_line_one' => '2800 Industrial Drive',
					'city' => 'Detroit',
					'state' => 'MI',
					'postal_code' => '48207',
					'country' => 'United States',
					'notes' => 'Manufacturer with a nationwide dealer network.',
					'is_active' => true,
				],
				'users' => [
					[
						'name' => 'Kevin Wallace',
						'email' => 'kevin@summitmfg.test',
						'role' => ClientRole::Administrator->value,
						'job_title' => 'Director of Marketing',
						'is_primary_contact' => true,
					],
					[
						'name' => 'Amanda Pierce',
						'email' => 'amanda@summitmfg.test',
						'role' => ClientRole::Approver->value,
						'job_title' => 'VP of Operations',
						'is_primary_contact' => false,
					],
					[
						'name' => 'Chris Walker',
						'email' => 'chris@summitmfg.test',
						'role' => ClientRole::Member->value,
						'job_title' => 'IT Manager',
						'is_primary_contact' => false,
					],
				],
			],

			[
				'client' => [
					'name' => 'Blue Ridge Outdoor Supply',
					'website' => 'https://blueridgeoutdoor.test',
					'email' => 'hello@blueridgeoutdoor.test',
					'phone' => '828-555-0127',
					'address_line_one' => '72 Market Street',
					'city' => 'Asheville',
					'state' => 'NC',
					'postal_code' => '28801',
					'country' => 'United States',
					'notes' => 'Outdoor retailer with three physical stores.',
					'is_active' => true,
				],
				'users' => [
					[
						'name' => 'Olivia Grant',
						'email' => 'olivia@blueridgeoutdoor.test',
						'role' => ClientRole::Administrator->value,
						'job_title' => 'E-commerce Director',
						'is_primary_contact' => true,
					],
					[
						'name' => 'Tyler Ross',
						'email' => 'tyler@blueridgeoutdoor.test',
						'role' => ClientRole::Viewer->value,
						'job_title' => 'Content Specialist',
						'is_primary_contact' => false,
					],
				],
			],

			[
				'client' => [
					'name' => 'Redwood Financial Partners',
					'website' => 'https://redwoodfinancial.test',
					'email' => 'contact@redwoodfinancial.test',
					'phone' => '614-555-0165',
					'address_line_one' => '410 High Street',
					'city' => 'Columbus',
					'state' => 'OH',
					'postal_code' => '43215',
					'country' => 'United States',
					'notes' => 'Former retainer client. Account currently inactive.',
					'is_active' => false,
				],
				'users' => [
					[
						'name' => 'Eric Lawson',
						'email' => 'eric@redwoodfinancial.test',
						'role' => ClientRole::Administrator->value,
						'job_title' => 'Managing Director',
						'is_primary_contact' => true,
					],
				],
			],
		];

		foreach ($clients as $data) {
			$client = Client::updateOrCreate(
				['name' => $data['client']['name']],
				$data['client']
			);

			foreach ($data['users'] as $userData) {
				$user = User::updateOrCreate(
					['email' => $userData['email']],
					[
						'name' => $userData['name'],
						'password' => Hash::make('password'),
						'email_verified_at' => now(),
					]
				);

				DB::table('client_user')->updateOrInsert(
					[
						'client_id' => $client->id,
						'user_id' => $user->id,
					],
					[
						'role' => $userData['role'],
						'job_title' => $userData['job_title'],
						'is_primary_contact' => $userData['is_primary_contact'],
						'created_at' => now(),
						'updated_at' => now(),
					]
				);
			}
		}
	}
}