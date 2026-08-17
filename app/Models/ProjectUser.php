<?php

namespace App\Models;

use App\Enums\ProjectRole;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectUser extends Pivot
{
	protected $table = 'project_user';

	protected function casts(): array
	{
		return [
			'role' => ProjectRole::class,
			'can_view_financials' => 'boolean',
		];
	}
}