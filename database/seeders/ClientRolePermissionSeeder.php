<?php

namespace Database\Seeders;

use App\Enums\ClientRole;
use App\Enums\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientRolePermissionSeeder extends Seeder
{
	public function run(): void
	{
		$permissions = [
			ClientRole::Administrator->value => [
				Permission::ClientsView,
				Permission::ClientsUpdate,

				Permission::ProjectsView,

				Permission::MilestonesView,

				Permission::TasksView,
				Permission::TasksCreate,
				Permission::TasksUpdate,
				Permission::TasksAssign,
				Permission::TasksApprove,

				Permission::FilesView,
				Permission::FilesUpload,
				Permission::FilesDelete,

				Permission::TeamView,
				Permission::TeamManage,
			],

			ClientRole::Approver->value => [
				Permission::ClientsView,
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

			ClientRole::Viewer->value => [
				Permission::ClientsView,
				Permission::ProjectsView,
				Permission::MilestonesView,
				Permission::TasksView,
				Permission::FilesView,
				Permission::TeamView,
			],
		];

		foreach ($permissions as $role => $rolePermissions) {
			foreach ($rolePermissions as $permission) {
				DB::table('client_role_permissions')->updateOrInsert(
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