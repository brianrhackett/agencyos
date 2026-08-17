<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
	public function run(): void
	{
		
		$this->call([
			//AgencyOsSeeder::class,
			//ActivitySeeder::class,
			
			//FileSeeder::class,
		
			//AgencyRolePermissionSeeder::class,
			//ClientRolePermissionSeeder::class,
		]);
	}
}
