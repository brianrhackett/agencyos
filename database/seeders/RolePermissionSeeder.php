<?php

namespace Database\Seeders;

use App\Enums\AgencyRole;
use App\Enums\ClientRole;
use App\Enums\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
	public function run(): void
	{
		DB::table('agency_role_permissions')->delete();
		DB::table('client_role_permissions')->delete();

		$agencyPermissions = [
			AgencyRole::Administrator->value => Permission::cases(),

			AgencyRole::Manager->value => [
				Permission::ClientsView,
				Permission::ProjectsView,
				Permission::ProjectsCreate,
				Permission::ProjectsUpdate,
				Permission::MilestonesView,
				Permission::MilestonesCreate,
				Permission::MilestonesUpdate,
				Permission::TasksView,
				Permission::TasksCreate,
				Permission::TasksUpdate,
				Permission::TasksAssign,
				Permission::TasksApprove,
				Permission::FilesView,
				Permission::FilesUpload,
				Permission::TeamView,
			],

			AgencyRole::Member->value => [
				Permission::ProjectsView,
				Permission::MilestonesView,
				Permission::TasksView,
				Permission::TasksUpdate,
				Permission::FilesView,
				Permission::FilesUpload,
				Permission::TeamView,
			],
		];

		foreach ($agencyPermissions as $role => $permissions) {
			foreach ($permissions as $permission) {
				DB::table('agency_role_permissions')->insert([
					'role' => $role,
					'permission' => $permission->value,
					'allowed' => true,
					'created_at' => now(),
					'updated_at' => now(),
				]);
			}
		}

		$clientPermissions = [
			ClientRole::Administrator->value => [
				Permission::ProjectsView,
				Permission::MilestonesView,
				Permission::TasksView,
				Permission::TasksCreate,
				Permission::TasksUpdate,
				Permission::TasksApprove,
				Permission::FilesView,
				Permission::FilesUpload,
				Permission::ClientUsersManage,
				Permission::TeamView,
			],

			ClientRole::Approver->value => [
				Permission::ProjectsView,
				Permission::MilestonesView,
				Permission::TasksView,
				Permission::TasksUpdate,
				Permission::TasksApprove,
				Permission::FilesView,
				Permission::FilesUpload,
				Permission::TeamView,
			],

			ClientRole::Member->value => [
				Permission::ProjectsView,
				Permission::MilestonesView,
				Permission::TasksView,
				Permission::TasksUpdate,
				Permission::FilesView,
				Permission::FilesUpload,
				Permission::TeamView,
			],

			ClientRole::Viewer->value => [
				Permission::ProjectsView,
				Permission::MilestonesView,
				Permission::TasksView,
				Permission::FilesView,
				Permission::TeamView,
			],
		];

		foreach ($clientPermissions as $role => $permissions) {
			foreach ($permissions as $permission) {
				DB::table('client_role_permissions')->insert([
					'role' => $role,
					'permission' => $permission->value,
					'allowed' => true,
					'created_at' => now(),
					'updated_at' => now(),
				]);
			}
		}
	}
}