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

		$tmp = explode('\\', $subject::class);
		$subject_type = strtolower(end($tmp));

		return Activity::create([
			'user_id' => auth()->id(),
			'type' => $type,
			'subject_type' => $subject_type,
			'subject_id' => $subject->getKey(),
			'metadata' => $metadata,
		]);
	}
}