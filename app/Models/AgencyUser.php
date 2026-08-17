<?php

namespace App\Models;

use App\Enums\AgencyRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgencyUser extends Model
{

    protected $fillable = [
		'role',
		'job_title',
	
	];

    protected function casts(): array
    {
        return [
            'role' => AgencyRole::class,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
