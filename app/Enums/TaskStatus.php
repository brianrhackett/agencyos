<?php

namespace App\Enums;

enum TaskStatus: string
{
    case ToDo = 'to_do';
    case InProgress = 'in_progress';
    case InReview = 'in_review';
    case Blocked = 'blocked';
    case Completed = 'completed';
    case AwaitingApproval = 'awaiting_approval'

    public function label(): string
    {
        return match ($this) {
            self::NotStarted => 'To Do',
            self::InProgress => 'In Progress',
            self::InReview => 'In Review',
            self::Blocked => 'Blocked',
            self::Completed => 'Completed',
            self::AwaitingApproval => 'Awaiting Approval'
        };
    }
}