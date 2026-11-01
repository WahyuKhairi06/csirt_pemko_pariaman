<?php

namespace App\Enums;

/**
 * Jenis kanal pelaporan yang bisa dipilih admin (PRD.md FR-05). Situs tidak menerima form;
 * kanal-kanal ini hanya tautan keluar. Nilai dari pengaturan TIDAK dipercaya: href() memvalidasi.
 */
enum ReportChannelType: string
{
    case Email = 'email';
    case Whatsapp = 'whatsapp';
    case Phone = 'phone';
    case Url = 'url';

    public function label(): string
    {
        return match ($this) {
            self::Email => 'Email',
            self::Whatsapp => 'WhatsApp',
            self::Phone => 'Telepon',
            self::Url => 'Helpdesk',
        };
    }

    public function actionLabel(): string
    {
        return match ($this) {
            self::Email => 'Kirim email',
            self::Whatsapp => 'Buka WhatsApp',
            self::Phone => 'Telepon',
            self::Url => 'Buka helpdesk',
        };
    }

    /** Tautan aman untuk nilai kanal, atau '#' bila nilainya tidak valid. */
    public function href(?string $value): string
    {
        $value = trim((string) $value);

        return match ($this) {
            self::Email => filter_var($value, FILTER_VALIDATE_EMAIL) ? 'mailto:'.$value : '#',
            self::Whatsapp => self::digits($value) !== '' ? 'https://wa.me/'.self::digits($value) : '#',
            self::Phone => self::digits($value) !== '' ? 'tel:+'.self::digits($value) : '#',
            self::Url => self::isHttpUrl($value) ? $value : '#',
        };
    }

    private static function digits(string $value): string
    {
        $digits = preg_replace('/\D+/', '', $value) ?? '';

        // Nomor Indonesia ditulis 08xx: ubah ke format internasional 628xx.
        return str_starts_with($digits, '0') ? '62'.substr($digits, 1) : $digits;
    }

    public static function isHttpUrl(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_URL) !== false
            && in_array(strtolower((string) parse_url($value, PHP_URL_SCHEME)), ['http', 'https'], true);
    }
}
