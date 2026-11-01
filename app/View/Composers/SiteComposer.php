<?php

namespace App\View\Composers;

use App\Enums\MenuLocation;
use App\Models\MenuItem;
use App\Support\Settings;
use Illuminate\Contracts\View\View;

/**
 * Menyuntikkan pengaturan, menu, banner darurat, dan tujuan tombol Lapor Insiden ke layout.
 * Daftarkan di AppServiceProvider::boot() untuk layout DAN view anak yang memakai variabelnya:
 * bagian @section pada view anak dirender sebelum layout, jadi $reportUrl/$site harus tersedia di view anak juga.
 * Datanya dihitung sekali per request (disimpan di atribut request).
 */
class SiteComposer
{
    private const REQUEST_KEY = 'site.composer.data';

    public function compose(View $view): void
    {
        $attributes = request()->attributes;

        if (! $attributes->has(self::REQUEST_KEY)) {
            $attributes->set(self::REQUEST_KEY, $this->build());
        }

        $view->with($attributes->get(self::REQUEST_KEY));
    }

    /** @return array<string, mixed> */
    private function build(): array
    {
        $emergency = Settings::get('emergency.enabled') ? [
            'text' => (string) Settings::get('emergency.text', ''),
            'level' => in_array(Settings::get('emergency.level'), ['info', 'warning', 'danger'], true)
                ? Settings::get('emergency.level')
                : 'warning',
        ] : null;

        return [
            'site' => Settings::all(),
            'menuHeader' => MenuItem::tree(MenuLocation::Header),
            'menuFooter' => MenuItem::tree(MenuLocation::Footer),
            'reportUrl' => Settings::reportCtaUrl(),
            'emergency' => ($emergency && $emergency['text'] !== '') ? $emergency : null,
        ];
    }
}
