<?php

namespace App\Enums;

enum MilestoneStatus: string
{
    case NotStarted = 'not_started';
    case InProgress = 'in_progress';
    case Blocked = 'blocked';
    case Completed = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::NotStarted => 'Not Started',
            self::InProgress => 'In Progress',
            self::Blocked => 'Blocked',
            self::Completed => 'Completed',
        };
    }
}