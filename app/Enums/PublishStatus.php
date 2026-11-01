<?php

namespace App\Enums;

// "Terjadwal" bukan nilai tersimpan: ia berarti status Published dengan published_at di masa depan.
enum PublishStatus: string
{
    case Draft = 'draft';
    case Published = 'published';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draf',
            self::Published => 'Terbit',
        };
    }
}
