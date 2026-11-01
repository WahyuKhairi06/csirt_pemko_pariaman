<?php

namespace App\View\Composers;

use App\Enums\MenuLocation;
use App\Models\MenuItem;
use App\Support\Settings;
use Illuminate\Contracts\View\View;

/**
 * Menyuntikkan pengaturan, menu, banner darurat, dan tujuan tombol Lapor Insiden ke layout.
 * Daftarkan di AppServiceProvider::boot():  View::composer('layouts.app', SiteComposer::class);
 */
class SiteComposer
{
    public function compose(View $view): void
    {
        $emergency = Settings::get('emergency.enabled') ? [
            'text' => (string) Settings::get('emergency.text', ''),
            'level' => in_array(Settings::get('emergency.level'), ['info', 'warning', 'danger'], true)
                ? Settings::get('emergency.level')
                : 'warning',
        ] : null;

        $view->with([
            'site' => Settings::all(),
            'menuHeader' => MenuItem::tree(MenuLocation::Header),
            'menuFooter' => MenuItem::tree(MenuLocation::Footer),
            'reportUrl' => Settings::reportCtaUrl(),
            'emergency' => ($emergency && $emergency['text'] !== '') ? $emergency : null,
        ]);
    }
}
