<?php

namespace App\Enums;

enum TaskStatus: string
{
    case ToDo = 'to_do';
    case InProgress = 'in_progress';
    case InReview = 'in_review';
    case Blocked = 'blocked';
    case Completed = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::ToDo => 'To Do',
            self::InProgress => 'In Progress',
            self::InReview => 'In Review',
            self::Blocked => 'Blocked',
            self::Completed => 'Completed',
        };
    }

    public function badgeVariant(): string
    {
        return match ($this) {
            self::ToDo => 'neutral',
            self::InProgress => 'primary',
            self::InReview => 'warning',
            self::Blocked => 'danger',
            self::Completed => 'success',
        };
    }
}