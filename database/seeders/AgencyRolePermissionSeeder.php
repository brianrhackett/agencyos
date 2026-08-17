<?php

namespace Database\Seeders;

use App\Enums\AgencyRole;
use App\Enums\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgencyRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
	{
		$permissions = [
			AgencyRole::Administrator->value => [
				Permission::ClientsView,
				Permission::ClientsCreate,
				Permission::ClientsUpdate,
				Permission::ClientsDelete,
				Permission::ClientUsersManage,

				Permission::ProjectsView,
				Permission::ProjectsCreate,
				Permission::ProjectsUpdate,
				Permission::ProjectsDelete,

				Permission::MilestonesView,
				Permission::MilestonesCreate,
				Permission::MilestonesUpdate,
				Permission::MilestonesDelete,

				Permission::TasksView,
				Permission::TasksCreate,
				Permission::TasksUpdate,
				Permission::TasksDelete,
				Permission::TasksAssign,
				Permission::TasksApprove,

				Permission::FilesView,
				Permission::FilesUpload,
				Permission::FilesDelete,

				Permission::TeamView,
				Permission::TeamManage,
			],

			AgencyRole::Manager->value => [
				Permission::ClientsView,
				Permission::ClientsCreate,
				Permission::ClientsUpdate,
				Permission::ClientUsersManage,
				
				Permission::ProjectsView,
				Permission::ProjectsCreate,
				Permission::ProjectsUpdate,

				Permission::MilestonesView,
				Permission::MilestonesCreate,
				Permission::MilestonesUpdate,
				Permission::MilestonesDelete,

				Permission::TasksView,
				Permission::TasksCreate,
				Permission::TasksUpdate,
				Permission::TasksDelete,
				Permission::TasksAssign,
				Permission::TasksApprove,

				Permission::FilesView,
				Permission::FilesUpload,
				Permission::FilesDelete,

				Permission::TeamView,
			],

			AgencyRole::Member->value => [
				Permission::ClientsView,
				Permission::ProjectsView,
				Permission::MilestonesView,

				Permission::TasksView,
				Permission::TasksCreate,
				Permission::TasksUpdate,

				Permission::FilesView,
				Permission::FilesUpload,

				Permission::TeamView,
			],
		];

		foreach ($permissions as $role => $rolePermissions) {
			foreach ($rolePermissions as $permission) {
				DB::table('agency_role_permissions')->updateOrInsert(
					[
						'role' => $role,
						'permission' => $permission->value,
					],
					[
						'allowed' => true,
						'updated_at' => now(),
						'created_at' => now(),
					]
				);
			}
		}
	}
}
