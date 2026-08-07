<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
	protected $fillable = [
		'user_id',
		'type',
		'subject_type',
		'subject_id',
		'metadata',
	];

	protected function casts(): array
	{
		return [
			'metadata' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
		];
	}

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}