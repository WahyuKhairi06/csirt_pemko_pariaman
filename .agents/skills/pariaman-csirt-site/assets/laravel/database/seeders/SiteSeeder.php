<?php

namespace Database\Seeders;

use App\Enums\MenuLocation;
use App\Enums\PublishStatus;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Setting;
use App\Support\Settings;
use Illuminate\Database\Seeder;

/**
 * Isi awal supaya situs langsung punya kerangka seperti instalasi WordPress baru: beranda, halaman dasar,
 * menu, dan pengaturan. Semua data resmi yang belum ada berupa placeholder "[ISI: ...]" yang HARUS diganti
 * admin lewat panel sebelum rilis (PRD.md bagian 12). Aman dijalankan ulang: tidak menimpa isi yang sudah diubah admin.
 *
 *   php artisan db:seed --class=SiteSeeder
 */
class SiteSeeder extends Seeder
{
    public function run(): void
    {
        $this->settings();
        $pages = $this->pages();
        $this->menus($pages);

        Settings::flush();
        MenuItem::flushCache();
    }

    private function settings(): void
    {
        $defaults = [
            'site.name' => 'CSIRT Kota Pariaman',
            'site.tagline' => 'Aman bersama di ruang digital Pariaman',
            'hero.title' => 'Aman bersama di ruang digital Pariaman',
            'hero.subtitle' => 'CSIRT Kota Pariaman membantu OPD dan masyarakat menghadapi insiden keamanan siber, dari pelaporan sampai pemulihan.',
            'contact.address' => '[ISI: alamat kantor]',
            'contact.phone' => '[ISI: telepon]',
            'contact.emergency_phone' => '[ISI: nomor darurat]',
            'contact.email_security' => '[ISI: email keamanan]',
            'contact.hours' => '[ISI: jam layanan]',
            'pgp.fingerprint' => '[ISI: fingerprint PGP]',
            'footer.text' => '© Diskominfo Kota Pariaman',
            'report.cta_type' => 'page',
            'report.cta_value' => 'saluran-pelaporan',
            'report.channels' => [
                ['type' => 'email', 'label' => 'Email', 'value' => '[ISI: email pelaporan]', 'hours' => '[ISI: jam layanan]', 'enabled' => true],
                ['type' => 'whatsapp', 'label' => 'WhatsApp', 'value' => '[ISI: nomor WhatsApp]', 'hours' => '[ISI: jam layanan]', 'enabled' => true],
            ],
            'report.checklist' => [
                'Alamat situs atau sistem yang terdampak',
                'Waktu kejadian (boleh perkiraan)',
                'Tangkapan layar atau bukti lain',
                'Apa yang sudah Anda coba',
            ],
            'report.warning' => 'Jangan kirim kata sandi atau kode OTP lewat kanal apa pun.',
            'emergency.enabled' => false,
            'emergency.text' => '',
            'emergency.level' => 'warning',
        ];

        foreach ($defaults as $key => $value) {
            Setting::query()->firstOrCreate(['key' => $key], ['value' => $value]);
        }
    }

    /** @return array<string, Page> */
    private function pages(): array
    {
        $definitions = [
            'beranda' => [
                'title' => 'Beranda', 'template' => 'home', 'is_home' => true,
                'blocks' => [
                    ['type' => 'hero', 'data' => [
                        'primary_label' => 'Lapor Insiden', 'secondary_label' => 'Pelajari layanan', 'secondary_url' => '/layanan',
                    ]],
                    ['type' => 'latest_advisories', 'data' => ['heading' => 'Advisori terbaru', 'count' => 3]],
                ],
            ],
            'profil' => [
                'title' => 'Profil', 'template' => 'default', 'is_home' => false,
                'blocks' => [['type' => 'rich_text', 'data' => ['content' => '<p>[ISI: profil, visi, misi, dan mandat CSIRT Kota Pariaman]</p>']]],
            ],
            'saluran-pelaporan' => [
                'title' => 'Saluran Pelaporan', 'template' => 'default', 'is_home' => false,
                'blocks' => [
                    ['type' => 'rich_text', 'data' => ['content' => '<p>Kami bantu cek. Hubungi kami lewat kanal di bawah, tidak perlu istilah teknis.</p>']],
                    ['type' => 'report_channels', 'data' => []],
                ],
            ],
            'kontak' => [
                'title' => 'Kontak', 'template' => 'default', 'is_home' => false,
                'blocks' => [['type' => 'rich_text', 'data' => ['content' => '<p>[ISI: informasi kontak dan Kontak Keamanan]</p>']]],
            ],
            'kebijakan-privasi' => [
                'title' => 'Kebijakan Privasi', 'template' => 'default', 'is_home' => false,
                'blocks' => [['type' => 'rich_text', 'data' => ['content' => '<p>[ISI: kebijakan privasi. Situs ini tidak mengumpulkan data dari pengunjung selain log akses dan analitik agregat.]</p>']]],
            ],
        ];

        $pages = [];
        foreach ($definitions as $slug => $def) {
            $pages[$slug] = Page::query()->firstOrCreate(['slug' => $slug], $def + [
                'status' => PublishStatus::Published->value,
                'published_at' => now(),
            ]);
        }

        return $pages;
    }

    /** @param array<string, Page> $pages */
    private function menus(array $pages): void
    {
        if (MenuItem::query()->exists()) {
            return; // admin sudah mengatur menu; jangan ditimpa
        }

        $header = [
            ['Beranda', 'url', '/'],
            ['Profil', 'page', $pages['profil']->id],
            ['Layanan', 'url', '/layanan'],
            ['Informasi', 'url', '/berita', [['Advisori', '/advisori'], ['Berita', '/berita'], ['Edukasi', '/edukasi'], ['Agenda', '/agenda']]],
            ['Dokumen', 'url', '/dokumen'],
            ['Kontak', 'page', $pages['kontak']->id],
        ];

        foreach ($header as $i => [$label, $type, $target, $children]) {
            $item = MenuItem::query()->create([
                'location' => MenuLocation::Header->value, 'label' => $label, 'type' => $type, 'sort' => $i,
                'url' => $type === 'url' ? $target : null,
                'page_id' => $type === 'page' ? $target : null,
            ]);
            foreach (($children ?? []) as $j => [$childLabel, $childUrl]) {
                MenuItem::query()->create([
                    'location' => MenuLocation::Header->value, 'parent_id' => $item->id,
                    'label' => $childLabel, 'type' => 'url', 'url' => $childUrl, 'sort' => $j,
                ]);
            }
        }

        $footer = [['Advisori', '/advisori'], ['Berita', '/berita'], ['Edukasi', '/edukasi'], ['Agenda', '/agenda'], ['Dokumen', '/dokumen']];
        foreach ($footer as $i => [$label, $url]) {
            MenuItem::query()->create([
                'location' => MenuLocation::Footer->value, 'label' => $label, 'type' => 'url', 'url' => $url, 'sort' => $i,
            ]);
        }
    }
}
