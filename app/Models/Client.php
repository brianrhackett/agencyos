<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    protected $fillable = [
		'name',
		'website',
		'email',
		'phone',
		'address_line_one',
		'address_line_two',
		'city',
		'state',
		'postal_code',
		'country',
		'notes',
		'is_active',
	];

	protected function casts(): array
	{
		return [
			'is_active' => 'boolean',
		];
	}

	public function users(): BelongsToMany
	{
		return $this->belongsToMany(User::class)
			->withPivot([
				'role',
				'job_title',
				'is_primary_contact',
			])
			->withTimestamps();
	}

	public function primaryContact()
	{
		return $this->belongsToMany(User::class)
			->withPivot([
				'is_primary_contact',
				'job_title'
			])
			->wherePivot('is_primary_contact', true);
	}

	public function projects(): HasMany
	{
		return $this->hasMany(Project::class);
	}

	public function clientUsers()
	{
		return $this->hasMany(ClientUser::class);
	}
}
