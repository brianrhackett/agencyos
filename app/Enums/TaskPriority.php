<?php

namespace App\Enums;

enum TaskPriority: string
{
    case Low = 'low';
	case Normal = 'normal';
	case High = 'high';

    public function label(): string
    {
        return match ($this) {
            self::Low => 'Low',
            self::Normal => 'Normal',
            self::High => 'High',
        };
    }

    public function color(): string
	{
		return match($this) {
			self::Low => 'gray',
			self::Normal => 'blue',
			self::High => 'red',
		};
	}

    public function badgeVariant(): string
    {
        return match($this) {
			self::Low => 'neutral',
			self::Normal => 'neutral',
			self::High => 'danger',
		};
    }
}