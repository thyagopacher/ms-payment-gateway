<?php

namespace App\Enums;

enum SendEmail: string
{
    case PENDING   = 'pending';
    case CANCELLED    = 'cancelled';
    case FAILED    = 'failed';
    case FINISHED   = 'finished';
    case READ = 'read';

    public function isFinal(): bool
    {
        return in_array($this, [self::PENDING, self::FAILED, self::CANCELLED, self::FINISHED, self::READ]);
    }

    public function isPending(): bool
    {
        return $this === self::PENDING;
    }

    public function isFailed(): bool
    {
        return $this === self::FAILED;
    }

    public function isCancelled(): bool
    {
        return $this === self::CANCELLED;
    }

    public function isFinished(): bool
    {
        return $this === self::FINISHED;
    }

    public function isRead(): bool
    {
        return $this === self::READ;
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
