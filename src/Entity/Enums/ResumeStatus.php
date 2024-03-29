<?php

declare(strict_types=1);

namespace App\Entity\Enums;

enum ResumeStatus: string
{
    case AVAILABLE = 'available';
    case BUSY = 'busy';

    public function isAvailable(): bool
    {
        return $this === self::AVAILABLE;
    }
}
