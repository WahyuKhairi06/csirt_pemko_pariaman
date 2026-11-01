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

        try {
            if (config('cache.default') !== 'database' && config('database.default') !== 'sqlite') {
                Cache::store('database')->forget(self::CACHE_KEY);
            }
        } catch (\Throwable) {
        }
    }

    /**
     * Tujuan tombol "Pengaduan" di header/beranda (FR-05).
     * report.cta_type: url | page | email | whatsapp   (bawaan: page = /saluran-pelaporan atau url eksternal)
     * report.cta_value: URL website pengaduan eksternal, slug halaman, alamat email, atau nomor WhatsApp.
     */
    public static function reportCtaUrl(): string
    {
        $type = (string) self::get('report.cta_type', 'page');
        $value = trim((string) self::get('report.cta_value', 'saluran-pelaporan'));

        if (ReportChannelType::isHttpUrl($value)) {
            return $value;
        }

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

    /** Nilai yang masih berupa placeholder "[ISI: ...]" (belum diisi admin). */
    public static function isPlaceholder(?string $value): bool
    {
        return $value !== null && str_starts_with(trim($value), '[ISI');
    }

    /**
     * Nilai pengaturan untuk ditampilkan di situs publik. Placeholder tetap terlihat di lingkungan pengembangan
     * (supaya mudah dikenali) tetapi disembunyikan di produksi agar tidak terbaca sebagai informasi resmi.
     */
    public static function publicValue(string $key): ?string
    {
        $value = trim((string) self::get($key, ''));

        if ($value === '' || (self::isPlaceholder($value) && app()->isProduction())) {
            return null;
        }

        return $value;
    }

    /** Tautan tel: hanya untuk nomor sungguhan; placeholder atau teks bukan nomor tidak menjadi tautan. */
    public static function telHref(?string $value): ?string
    {
        if ($value === null || self::isPlaceholder($value) || preg_match('/^[\d\s()+\-]{5,}$/', $value) !== 1) {
            return null;
        }

        return 'tel:'.preg_replace('/[^\d+]/', '', $value);
    }

    /** Tautan mailto: hanya untuk alamat email yang valid. */
    public static function mailHref(?string $value): ?string
    {
        return ($value !== null && ! self::isPlaceholder($value) && filter_var($value, FILTER_VALIDATE_EMAIL))
            ? 'mailto:'.$value
            : null;
    }
}
