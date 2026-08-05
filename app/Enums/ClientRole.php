<?php

namespace App\Enums;

enum ClientRole: string
{
	case Administrator = 'administrator';
	case Approver = 'approver';
	case Member = 'member';
	case Viewer = 'viewer';

    public function label(): String
    {
        return match ($this) {
            self::Administrator => 'Administrator',
            self::Approver => 'Approver',
            self::Member => 'Member',
            self::Viewer => 'Viewer'
        };
    }
}