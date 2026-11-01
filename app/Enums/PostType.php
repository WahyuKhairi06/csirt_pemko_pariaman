<?php

namespace App\Enums;

enum PostType: string
{
    case News = 'news';
    case Education = 'education';

    public function label(): string
    {
        return match ($this) {
            self::News => 'Berita',
            self::Education => 'Edukasi',
        };
    }

    /** Awalan URL publik. */
    public function path(): string
    {
        return match ($this) {
            self::News => 'berita',
            self::Education => 'edukasi',
        };
    }

    public static function fromPath(string $path): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->path() === $path) {
                return $case;
            }
        }

        return null;
    }
}
