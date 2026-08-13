<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;

class ActivityLogger
{
	public static function log(
		string $type,
		Model $subject,
		array $metadata = []
	): Activity {
		return Activity::create([
			'user_id' => auth()->id(),
			'type' => $type,
			'subject_type' => strtolower(end(explode('\\', $subject::class))),
			'subject_id' => $subject->getKey(),
			'metadata' => $metadata,
		]);
	}
}