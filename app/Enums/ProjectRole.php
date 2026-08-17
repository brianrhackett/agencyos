<?php

namespace App\Enums;

enum ProjectRole: string
{
	case Lead = 'lead';
	case Member = 'member';
	case Viewer = 'viewer';

    public function label(): String
    {
        return match ($this) {
        	self::Lead => 'Lead / Project Manager',

            self::Member => 'Member',
            self::Viewer => 'Viewer',
        };
    }
}