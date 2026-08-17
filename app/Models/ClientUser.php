<?php

namespace App\Models;

use App\Enums\ClientRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientUser extends Model
{
	protected $table = 'client_user';

	protected $fillable = [
		'client_id',
		'user_id',
		'role',
		'job_title',
		'is_primary_contact',
	];

	protected function casts(): array
	{
		return [
			'role' => ClientRole::class,
			'is_primary_contact' => 'boolean',
		];
	}

	public function client(): BelongsTo
	{
		return $this->belongsTo(Client::class);
	}

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}