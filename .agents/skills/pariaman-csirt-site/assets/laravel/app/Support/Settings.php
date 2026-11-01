<?php

namespace App\Support;

use App\Enums\ReportChannelType;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

/**
 * Pengaturan situs (PRD.md FR-44). Semua nilai kontak, jam layanan, PGP, banner darurat, dan tujuan
 * tombol Lapor Insiden hidup di sini, dikelola admin, dan TIDAK boleh ditulis langsung di kode atau view.
 * Daftar kunci: references/CMS-SPEC.md bagian 6.
 */
final class Settings
{
    private const CACHE_KEY = 'site.settings';

    public static function all(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return Setting::query()->get()->mapWithKeys(fn (Setting $s) => [$s->key => $s->value])->all();
        });
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $value = self::all()[$key] ?? null;

        return ($value === null || $value === '') ? $default : $value;
    }

    public static function set(string $key, mixed $value): void
    {
        Setting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        self::flush();
    }

    public static function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * Tujuan tombol "Lapor Insiden" di header (FR-05).
     * report.cta_type: page | email | whatsapp | url   (bawaan: page = /saluran-pelaporan)
     * report.cta_value: slug halaman, alamat email, nomor, atau URL sesuai jenisnya.
     */
    public static function reportCtaUrl(): string
    {
        $type = (string) self::get('report.cta_type', 'page');
        $value = (string) self::get('report.cta_value', 'saluran-pelaporan');

        if ($type === 'page') {
            $slug = trim($value, '/');

            return preg_match('/^[a-z0-9-]+$/', $slug) === 1 ? '/'.$slug : '/saluran-pelaporan';
        }

        $channel = ReportChannelType::tryFrom($type);
        $href = $channel?->href($value) ?? '#';

        return $href === '#' ? '/saluran-pelaporan' : $href;
    }

    /**
     * Kanal pelaporan aktif untuk halaman Saluran Pelaporan, siap render dengan tautan yang sudah divalidasi.
     * Setiap kanal: ['type' => 'email', 'label' => ..., 'value' => ..., 'hours' => ..., 'enabled' => true].
     *
     * @return list<array{type: ReportChannelType, label: string, value: string, hours: ?string, href: string}>
     */
    public static function reportChannels(): array
    {
        $channels = [];

        foreach ((array) self::get('report.channels', []) as $row) {
            $type = ReportChannelType::tryFrom((string) ($row['type'] ?? ''));
            if ($type === null || ! ($row['enabled'] ?? true)) {
                continue;
            }
            $value = trim((string) ($row['value'] ?? ''));
            $href = $type->href($value);
            if ($value === '' || $href === '#') {
                continue; // placeholder [ISI] atau nilai tidak valid tidak ditampilkan sebagai tautan
            }
            $channels[] = [
                'type' => $type,
                'label' => (string) ($row['label'] ?? $type->label()),
                'value' => $value,
                'hours' => isset($row['hours']) ? (string) $row['hours'] : null,
                'href' => $href,
            ];
        }

        return $channels;
    }
}
