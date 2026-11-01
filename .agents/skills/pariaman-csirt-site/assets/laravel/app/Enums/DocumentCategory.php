<?php

namespace App\Enums;

enum DocumentCategory: string
{
    case Rfc2350 = 'rfc2350';
    case Regulation = 'regulation';
    case Sop = 'sop';
    case Guide = 'guide';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Rfc2350 => 'RFC-2350',
            self::Regulation => 'Regulasi',
            self::Sop => 'SOP',
            self::Guide => 'Panduan',
            self::Other => 'Lainnya',
        };
    }
}
