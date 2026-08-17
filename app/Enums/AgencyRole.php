<?php

namespace App\Enums;

enum AgencyRole: string
{
    case SuperAdmin = 'super_admin';
	case Administrator = 'administrator';
	case Manager = 'manager';
	case Member = 'member';

    public function label(): String
    {
        return match ($this) {
            self::SuperAdmin => 'Super Administrator',
            self::Administrator => 'Administrator',
            self::Manager => 'Manager',
            self::Member => 'Member',
        };
    }
}