<?php

namespace App\Enums;

enum ServiceGroup: string
{
    case Reactive = 'reactive';
    case Proactive = 'proactive';
    case Quality = 'quality';

    public function label(): string
    {
        return match ($this) {
            self::Reactive => 'Layanan reaktif',
            self::Proactive => 'Layanan proaktif',
            self::Quality => 'Peningkatan kualitas keamanan',
        };
    }
}
