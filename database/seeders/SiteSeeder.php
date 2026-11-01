<?php

namespace Database\Seeders;

use App\Enums\DocumentCategory;
use App\Enums\MenuLocation;
use App\Enums\PostType;
use App\Enums\PublishStatus;
use App\Enums\ServiceGroup;
use App\Enums\Severity;
use App\Models\Advisory;
use App\Models\Agent;
use App\Models\Category;
use App\Models\Document;
use App\Models\Event;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\PortalLink;
use App\Models\Post;
use App\Models\Service;
use App\Models\Setting;
use App\Support\Settings;
use Illuminate\Database\Seeder;

/**
 * Isi awal supaya situs langsung punya kerangka seperti instalasi baru:
 * beranda lengkap dengan blok, profil, katalog layanan, dokumen RFC-2350,
 * saluran pelaporan, kontak, advisori, dan tautan portal daerah.
 *
 * Nilai resmi yang belum diverifikasi tetap memakai placeholder "[ISI: ...]"
 * yang harus dilengkapi pengelola melalui panel admin (PRD.md bagian 12).
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
        $this->services();
        $this->advisories();
        $this->posts();
        $this->documents();
        $this->portalLinks();
        $this->agents();
        $this->events();

        Settings::flush();
        MenuItem::flushCache();
    }

    private function settings(): void
    {
        $defaults = [
            'site.name' => 'CSIRT Kota Pariaman',
            'site.tagline' => 'Aman bersama di ruang digital Pariaman',
            'hero.title' => 'Aman bersama di ruang digital Pariaman',
            'hero.subtitle' => 'CSIRT Kota Pariaman membantu Organisasi Perangkat Daerah dan pemangku kepentingan menghadapi insiden keamanan informasi, dari pencegahan sampai pemulihan.',
            'contact.address' => '[ISI: alamat kantor]',
            'contact.phone' => '[ISI: telepon]',
            'contact.emergency_phone' => '[ISI: nomor darurat]',
            'contact.email_security' => '[ISI: email keamanan]',
            'contact.hours' => '[ISI: jam layanan]',
            'pgp.fingerprint' => '[ISI: fingerprint PGP]',
            'footer.text' => '© Diskominfo Kota Pariaman',
            'report.cta_label' => 'Pengaduan',
            'report.cta_type' => 'page',
            'report.cta_value' => 'saluran-pelaporan',
            'report.cta_new_tab' => true,
            'report.channels' => [
                ['type' => 'email', 'label' => 'Email Resmi Pelaporan', 'value' => '[ISI: email pelaporan]', 'hours' => '[ISI: jam layanan]', 'enabled' => true],
                ['type' => 'whatsapp', 'label' => 'WhatsApp CSIRT Pariaman', 'value' => '[ISI: nomor WhatsApp]', 'hours' => '[ISI: jam layanan]', 'enabled' => true],
                ['type' => 'phone', 'label' => 'Telepon Darurat', 'value' => '[ISI: nomor darurat]', 'hours' => '[ISI: jam layanan]', 'enabled' => true],
            ],
            'report.checklist' => [
                'Alamat situs web, URL sistem, atau nama aplikasi yang terdampak',
                'Waktu perkiraan pertama kali insiden teridentifikasi',
                'Tangkapan layar (screenshot), pesan galat, atau indikasi anomali',
                'Langkah awal atau tindakan isolasi yang telah dilakukan',
            ],
            'report.warning' => 'Jangan pernah mengirim kata sandi, token autentikasi, atau kode OTP melalui kanal pelaporan apa pun.',
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
                        'primary_label' => 'Pengaduan',
                        'secondary_label' => 'Pelajari Layanan',
                        'secondary_url' => '/layanan',
                    ]],
                    ['type' => 'steps', 'data' => [
                        'heading' => 'Alur Pelaporan Insiden Siber',
                    ]],
                    ['type' => 'service_cards', 'data' => [
                        'heading' => 'Layanan Utama CSIRT',
                        'count' => 3,
                    ]],
                    ['type' => 'latest_advisories', 'data' => [
                        'heading' => 'Advisori Keamanan Terbaru',
                        'count' => 3,
                    ]],
                    ['type' => 'portal_links', 'data' => [
                        'heading' => 'Portal Layanan Pemerintah Kota Pariaman',
                    ]],
                    ['type' => 'latest_posts', 'data' => [
                        'heading' => 'Berita & Edukasi Keamanan',
                        'count' => 3,
                    ]],
                    ['type' => 'contact_block', 'data' => []],
                ],
            ],
            'profil' => [
                'title' => 'Profil CSIRT Kota Pariaman', 'template' => 'default', 'is_home' => false,
                'blocks' => [
                    ['type' => 'rich_text', 'data' => [
                        'content' => '<h2>Profil Bidang &amp; CSIRT Kota Pariaman</h2>
<p><strong>Computer Security Incident Response Team (CSIRT) Pemerintah Kota Pariaman</strong> merupakan tim tanggap insiden keamanan siber yang dibentuk oleh Pemerintah Kota Pariaman di bawah koordinasi <strong>Dinas Komunikasi dan Informatika (Diskominfo) Kota Pariaman</strong> untuk mendukung kesiapsiagaan, pengamanan informasi, dan ketahanan ruang siber daerah.</p>
<h3>Visi &amp; Misi</h3>
<p><strong>Visi:</strong> Mewujudkan tata kelola keamanan informasi dan persandian yang andal, adaptif, dan responsif dalam mendukung transformasi digital serta Sistem Pemerintahan Berbasis Elektronik (SPBE) di Kota Pariaman.</p>
<p><strong>Misi:</strong></p>
<ul>
    <li>Membangun kapasitas pencegahan, deteksi dini, dan penanggulangan insiden keamanan siber pada seluruh perangkat daerah.</li>
    <li>Meningkatkan kesadaran dan budaya keamanan informasi bagi Aparatur Sipil Negara (ASN) serta masyarakat Kota Pariaman.</li>
    <li>Memperkuat sinergi dan koordinasi keamanan siber bersama BSSN serta pemangku kepentingan terkait.</li>
</ul>
<h3>Mandat &amp; Landasan Hukum</h3>
<p>[ISI: SK Pembentukan CSIRT Kota Pariaman dan peraturan daerah terkait penanggulangan insiden siber]</p>
<h3>Konstituen Layanan</h3>
<p>Konstituen resmi CSIRT Kota Pariaman mencakup seluruh Organisasi Perangkat Daerah (OPD), bagian, kecamatan, unit pelaksana teknis, serta aparatur sipil negara di lingkungan Pemerintah Kota Pariaman.</p>',
                    ]],
                ],
            ],
            'tugas-dan-fungsi' => [
                'title' => 'Tugas dan Fungsi', 'template' => 'default', 'is_home' => false,
                'blocks' => [
                    ['type' => 'rich_text', 'data' => [
                        'content' => '<h2>Tugas Pokok dan Fungsi</h2>
<p>Bidang Pengelola Keamanan Informasi dan Tim CSIRT Pemerintah Kota Pariaman menyelenggarakan tugas pokok dan fungsi strategis dalam menjaga keandalan serta keamanan sistem elektronik pemerintahan daerah.</p>
<h3>1. Tugas Pokok</h3>
<p>Melaksanakan perumusan kebijakan teknis, koordinasi, pencegahan, tanggap darurat, pemulihan, serta pengawasan keamanan informasi dan persandian pada seluruh penyelenggaraan Sistem Pemerintahan Berbasis Elektronik (SPBE) di lingkungan Pemerintah Kota Pariaman.</p>
<h3>2. Fungsi Utama</h3>
<ol>
    <li><strong>Fungsi Kesiapsiagaan &amp; Pencegahan (Proaktif):</strong> Melaksanakan asesmen kerentanan (<em>vulnerability assessment</em>), audit keamanan aplikasi, serta penerbitan peringatan dini (advisori) terhadap ancaman siber.</li>
    <li><strong>Fungsi Tanggap Insiden (Reaktif):</strong> Menerima pengaduan insiden, melakukan triase, analisis teknis, isolasi serangan, dan koordinasi pemulihan layanan sistem elektronik yang terdampak.</li>
    <li><strong>Fungsi Manajemen Kualitas Keamanan:</strong> Menyelenggarakan bimbingan teknis, sosialisasi kesadaran keamanan informasi, penyusunan standar operasional prosedur (SOP), serta pembinaan Agen Siber di setiap OPD.</li>
    <li><strong>Fungsi Koordinasi &amp; Kemitraan:</strong> Menjalin komunikasi dan pertukaran informasi ancaman siber bersama Badan Siber dan Sandi Negara (BSSN), CSIRT Provinsi, serta instansi terkait lainnya.</li>
</ol>',
                    ]],
                ],
            ],
            'saluran-pelaporan' => [
                'title' => 'Saluran Pelaporan', 'template' => 'default', 'is_home' => false,
                'blocks' => [
                    ['type' => 'rich_text', 'data' => [
                        'content' => '<p class="lead">Kami siap membantu perangkat daerah menangani dugaan insiden keamanan informasi. Hubungi kami melalui saluran resmi di bawah ini tanpa perlu merasa khawatir dengan istilah teknis.</p>',
                    ]],
                    ['type' => 'report_channels', 'data' => []],
                ],
            ],
            'kontak' => [
                'title' => 'Kontak Resmi', 'template' => 'default', 'is_home' => false,
                'blocks' => [
                    ['type' => 'rich_text', 'data' => [
                        'content' => '<p class="lead">Hubungi sekretariat CSIRT Kota Pariaman untuk keperluan koordinasi, konsultasi pengamanan sistem informasi, dan pelaporan kerentanan keamanan terkoordinasi.</p>',
                    ]],
                    ['type' => 'contact_block', 'data' => []],
                ],
            ],
            'kebijakan-privasi' => [
                'title' => 'Kebijakan Privasi', 'template' => 'default', 'is_home' => false,
                'blocks' => [
                    ['type' => 'rich_text', 'data' => [
                        'content' => '<h2>Kebijakan Privasi Portal CSIRT Pariaman</h2>
<p>Portal web ini dirancang dengan prinsip minimasi data dan privasi sejak awal. Portal publik CSIRT Kota Pariaman hanya menyajikan informasi publik (read-only) dan tidak mengumpulkan data pribadi pengunjung, tidak menyediakan formulir daring publik, serta tidak menggunakan pelacak komersial pihak ketiga.</p>
<p>[ISI: rincian kebijakan perlindungan data pribadi dan log teknis server sesuai ketentuan peraturan perundang-undangan]</p>',
                    ]],
                ],
            ],
        ];

        $pages = [];
        foreach ($definitions as $slug => $def) {
            $pages[$slug] = Page::query()->firstOrCreate(['slug' => $slug], $def + [
                'status' => PublishStatus::Published->value,
                'published_at' => now(),
            ]);
        }

        if (isset($pages['profil'], $pages['tugas-dan-fungsi']) && ! $pages['tugas-dan-fungsi']->parent_id) {
            $pages['tugas-dan-fungsi']->update(['parent_id' => $pages['profil']->id]);
        }

        return $pages;
    }

    /** @param array<string, Page> $pages */
    private function menus(array $pages): void
    {
        if (MenuItem::query()->exists()) {
            return;
        }

        $header = [
            ['Beranda', 'url', '/'],
            ['Profil', 'page', $pages['profil']->id, [
                ['Profil Bidang', 'page', $pages['profil']->id],
                ['Tugas dan Fungsi', 'page', $pages['tugas-dan-fungsi']->id],
            ]],
            ['Layanan', 'url', '/layanan'],
            ['Informasi', 'url', '/berita', [
                ['Advisori', 'url', '/advisori'],
                ['Berita', 'url', '/berita'],
                ['Edukasi', 'url', '/edukasi'],
                ['Agenda', 'url', '/agenda'],
            ]],
            ['Dokumen', 'url', '/dokumen'],
            ['Kontak', 'page', $pages['kontak']->id],
        ];

        foreach ($header as $i => $row) {
            [$label, $type, $target] = $row;
            $children = $row[3] ?? [];

            $item = MenuItem::query()->create([
                'location' => MenuLocation::Header->value,
                'label' => $label,
                'type' => $type,
                'sort' => $i,
                'url' => $type === 'url' ? $target : null,
                'page_id' => $type === 'page' ? $target : null,
            ]);

            foreach ($children as $j => $childRow) {
                $childLabel = $childRow[0];
                $childType = isset($childRow[2]) ? $childRow[1] : 'url';
                $childTarget = $childRow[2] ?? $childRow[1];

                MenuItem::query()->create([
                    'location' => MenuLocation::Header->value,
                    'parent_id' => $item->id,
                    'label' => $childLabel,
                    'type' => $childType,
                    'url' => $childType === 'url' ? $childTarget : null,
                    'page_id' => $childType === 'page' ? $childTarget : null,
                    'sort' => $j,
                ]);
            }
        }

        $footer = [
            ['Profil Bidang', '/profil'],
            ['Tugas dan Fungsi', '/tugas-dan-fungsi'],
            ['Advisori', '/advisori'],
            ['Berita', '/berita'],
            ['Edukasi', '/edukasi'],
            ['Agenda', '/agenda'],
            ['Dokumen', '/dokumen'],
        ];

        foreach ($footer as $i => [$label, $url]) {
            MenuItem::query()->create([
                'location' => MenuLocation::Footer->value,
                'label' => $label,
                'type' => 'url',
                'url' => $url,
                'sort' => $i,
            ]);
        }
    }

    private function services(): void
    {
        $services = [
            [
                'group' => ServiceGroup::Reactive->value,
                'name' => 'Penanganan Insiden Siber',
                'slug' => 'penanganan-insiden-siber',
                'description' => 'Pendampingan dan tindakan penanggulangan teknis saat terjadi insiden keamanan pada sistem elektronik OPD Kota Pariaman.',
                'who_can_request' => 'Pengelola sistem informasi di lingkungan OPD Pemerintah Kota Pariaman',
                'how_to_request' => 'Menghubungi saluran pelaporan resmi dengan melampirkan kronologi kejadian dan bukti indikasi insiden',
                'hours' => 'Hari kerja 08.00 — 16.00 WIB (Kedaruratan 24/7)',
                'response_target' => 'Maksimal 2 jam untuk verifikasi awal dan triase keparahan',
                'sort' => 1,
            ],
            [
                'group' => ServiceGroup::Reactive->value,
                'name' => 'Koordinasi Penanggulangan Insiden',
                'slug' => 'koordinasi-penanggulangan-insiden',
                'description' => 'Fasilitasi koordinasi teknis lintas sektor dengan BSSN dan CSIRT sektoral/wilayah dalam menangani eskalasi insiden kritis.',
                'who_can_request' => 'Kepala OPD / Pengelola SPBE instansi',
                'how_to_request' => 'Permohonan melalui surat dinas atau pelaporan kedaruratan terverifikasi',
                'hours' => 'Senin — Jumat 08.00 — 16.00 WIB',
                'response_target' => 'Maksimal 1 hari kerja',
                'sort' => 2,
            ],
            [
                'group' => ServiceGroup::Proactive->value,
                'name' => 'Peringatan Dini & Advisori Keamanan',
                'slug' => 'peringatan-dini-dan-advisori',
                'description' => 'Penyusunan dan distribusi pemberitahuan berkala tentang kerentanan sistem operasi, perangkat lunak, dan ancaman siber terkini.',
                'who_can_request' => 'Seluruh ASN dan pengelola teknologi informasi Pemerintah Kota Pariaman',
                'how_to_request' => 'Dapat diakses secara terbuka melalui kanal publikasi resmi CSIRT',
                'hours' => 'Diterbitkan berkala dan insidental',
                'response_target' => 'Seketika setelah kerentanan diverifikasi tim analis',
                'sort' => 3,
            ],
            [
                'group' => ServiceGroup::Proactive->value,
                'name' => 'Penilaian Mandiri & Audit Kerentanan',
                'slug' => 'penilaian-mandiri-dan-audit-kerentanan',
                'description' => 'Pendampingan pemindaian celah keamanan (vulnerability assessment) sebelum aplikasi resmi perangkat daerah diluncurkan.',
                'who_can_request' => 'Pengembang aplikasi perangkat daerah / Bidang SPBE',
                'how_to_request' => 'Pengajuan jadwal pengujian melalui Bidang Penyelenggaraan E-Government',
                'hours' => 'Hari kerja 08.00 — 16.00 WIB',
                'response_target' => '3–5 hari kerja',
                'sort' => 4,
            ],
            [
                'group' => ServiceGroup::Quality->value,
                'name' => 'Sosialisasi & Edukasi Kesadaran Keamanan',
                'slug' => 'sosialisasi-dan-edukasi-keamanan',
                'description' => 'Penyelenggaraan pelatihan, bimbingan teknis, dan literasi digital mengenai pola pengamanan kata sandi dan pencegahan rekayasa sosial.',
                'who_can_request' => 'Aparatur Sipil Negara (ASN) dan pegawai di lingkungan Pemko Pariaman',
                'how_to_request' => 'Permohonan narasumber/pelatihan dari instansi atau unit kerja terkait',
                'hours' => 'Hari kerja 08.00 — 16.00 WIB',
                'response_target' => 'Sesuai agenda kegiatan tahunan',
                'sort' => 5,
            ],
        ];

        foreach ($services as $data) {
            Service::query()->firstOrCreate(['slug' => $data['slug']], $data + [
                'status' => PublishStatus::Published->value,
                'published_at' => now(),
            ]);
        }
    }

    private function advisories(): void
    {
        $advisories = [
            [
                'title' => 'Peringatan Dini Kerentanan Kritis Remote Code Execution pada Perangkat Lunak Server',
                'slug' => 'peringatan-dini-kerentanan-kritis-rce-server',
                'severity' => Severity::High->value,
                'summary' => 'Ditemukan kerentanan kritis yang memungkinkan penyerang mengeksekusi perintah berbahaya secara remote pada server yang belum diperbarui.',
                'affected_systems' => "Sistem Operasi Server Linux / Windows Server\nServer Web Apache / Nginx versi lama\nSistem manajemen konten yang belum diperbarui ke patch terbaru",
                'mitigation' => '<p>Langkah mitigasi yang harus segera dilakukan oleh administrator sistem perangkat daerah:</p>
<ol>
    <li>Lakukan pembaruan (patching) paket perangkat lunak server ke versi stabil terbaru yang direkomendasikan vendor.</li>
    <li>Pastikan port manajemen administrasi (seperti SSH dan RDP) tidak dibuka langsung ke jaringan internet publik.</li>
    <li>Terapkan filter firewall dan lakukan pencadangan data (backup) secara rutin di media terpisah.</li>
</ol>',
            ],
            [
                'title' => 'Imbauan Keamanan Pengamanan Akun ASN dan Pencegahan Modus Phishing',
                'slug' => 'imbauan-pengamanan-akun-dan-pencegahan-phishing',
                'severity' => Severity::Medium->value,
                'summary' => 'Peningkatan kampanye rekayasa sosial (phishing) yang mengatasnamakan pembaruan akun dinas dan verifikasi data kepegawaian.',
                'affected_systems' => "Akun Email Dinas Pemerintah Kota Pariaman\nAplikasi Sistem Informasi Manajemen Kepegawaian\nPerangkat telepon cerdas dan peramban web pegawai",
                'mitigation' => '<p>Rekomendasi bagi seluruh pengguna akun pemerintahan:</p>
<ul>
    <li>Jangan pernah mengklik tautan mencurigakan pada pesan email atau pesan instan yang meminta kata sandi atau data pribadi.</li>
    <li>Aktifkan Autentikasi Dua Faktor (2FA / MFA) pada semua akun dinas yang mendukung.</li>
    <li>Laporkan segera ke narahubung CSIRT apabila tanpa sengaja telah memasukkan data pada situs mencurigakan.</li>
</ul>',
            ],
        ];

        foreach ($advisories as $item) {
            Advisory::query()->firstOrCreate(['slug' => $item['slug']], $item + [
                'status' => PublishStatus::Published->value,
                'published_at' => now(),
            ]);
        }
    }

    private function posts(): void
    {
        $catNews = Category::query()->firstOrCreate(['type' => PostType::News->value, 'slug' => 'kegiatan'], ['name' => 'Kegiatan']);
        $catEdu = Category::query()->firstOrCreate(['type' => PostType::Education->value, 'slug' => 'panduan-asn'], ['name' => 'Panduan ASN']);

        $posts = [
            [
                'type' => PostType::News->value,
                'category_id' => $catNews->id,
                'title' => 'Penguatan Kesiapsiagaan Tanggap Insiden Keamanan Informasi Pemerintah Kota Pariaman',
                'slug' => 'penguatan-kesiapsiagaan-tanggap-insiden-pemerintah-kota-pariaman',
                'excerpt' => 'Dinas Komunikasi dan Informatika Kota Pariaman terus mengoptimalkan koordinasi pengamanan sistem elektronik di seluruh perangkat daerah.',
                'body' => '<p>Dalam rangka menjamin kelancaran penyelenggaraan Sistem Pemerintahan Berbasis Elektronik (SPBE), Diskominfo Kota Pariaman melalui tim CSIRT menyelenggarakan sosialisasi tata kelola keamanan informasi dan mitigasi risiko siber bagi perwakilan perangkat daerah.</p>
<p>Langkah ini bertujuan membangun kesiapsiagaan terpadu dari tingkat operator hingga pejabat pengelola informasi daerah dalam merespons potensi ancaman kebocoran data dan gangguan operasional sistem.</p>',
            ],
            [
                'type' => PostType::Education->value,
                'category_id' => $catEdu->id,
                'title' => 'Mengenal Rekayasa Sosial (Social Engineering) dan Langkah Pencegahannya',
                'slug' => 'mengenal-rekayasa-sosial-dan-langkah-pencegahannya',
                'excerpt' => 'Pelajari pola manipulasi psikologis yang kerap dimanfaatkan peretas untuk memperoleh hak akses akun kedinasan.',
                'body' => '<p>Rekayasa sosial adalah teknik manipulasi psikologis di mana pelaku berupaya meyakinkan korban agar memberikan informasi rahasia atau melakukan tindakan yang membahayakan sistem keamanan.</p>
<h3>Modus yang Sering Terjadi:</h3>
<ol>
    <li><strong>Phishing:</strong> Email atau tautan palsu yang meniru formulir resmi kepegawaian.</li>
    <li><strong>Baiting:</strong> Iming-iming dokumen penting atau aplikasi gratis yang telah disisipi kode berbahaya.</li>
    <li><strong>Pretexting:</strong> Pihak yang mengaku sebagai teknisi dukungan IT dan meminta kode akses.</li>
</ol>
<p>Kunci pencegahan utama adalah selalu melakukan verifikasi silang terhadap nomor atau alamat pengirim sebelum merespons permintaan informasi rahasia.</p>',
            ],
        ];

        foreach ($posts as $item) {
            Post::query()->firstOrCreate(['slug' => $item['slug']], $item + [
                'status' => PublishStatus::Published->value,
                'published_at' => now(),
            ]);
        }
    }

    private function documents(): void
    {
        $docs = [
            [
                'title' => 'Deskripsi CSIRT Pemerintah Kota Pariaman (RFC-2350)',
                'category' => DocumentCategory::Rfc2350->value,
                'file' => 'documents/rfc-2350-csirt-pariaman.pdf',
                'version' => '1.0',
                'language' => 'id',
                'effective_date' => '2026-01-01',
                'sort' => 1,
            ],
            [
                'title' => 'SOP Penanganan dan Eskalasi Insiden Keamanan Informasi',
                'category' => DocumentCategory::Sop->value,
                'file' => 'documents/sop-penanganan-insiden.pdf',
                'version' => '1.0',
                'language' => 'id',
                'effective_date' => '2026-01-01',
                'sort' => 2,
            ],
        ];

        foreach ($docs as $doc) {
            Document::query()->firstOrCreate(['title' => $doc['title']], $doc + [
                'status' => PublishStatus::Published->value,
                'published_at' => now(),
            ]);
        }
    }

    private function portalLinks(): void
    {
        $links = [
            [
                'title' => 'Portal Resmi Pemerintah Kota Pariaman',
                'description' => 'Situs portal induk informasi dan berita resmi Pemerintah Kota Pariaman.',
                'icon' => 'globe',
                'url' => 'https://pariamankota.go.id',
                'sort' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Portal Satu Data Kota Pariaman',
                'description' => 'Akses terpadu data statistik sektoral dan geospasial Kota Pariaman.',
                'icon' => 'database',
                'url' => 'https://data.pariamankota.go.id',
                'sort' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'PPID Pemerintah Kota Pariaman',
                'description' => 'Pejabat Pengelola Informasi dan Dokumentasi Kota Pariaman.',
                'icon' => 'file-text',
                'url' => 'https://ppid.pariamankota.go.id',
                'sort' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($links as $link) {
            PortalLink::query()->firstOrCreate(['url' => $link['url']], $link);
        }
    }

    private function agents(): void
    {
        $agents = [
            [
                'name' => '[ISI: Nama Narahubung Diskominfo]',
                'opd' => 'Dinas Komunikasi dan Informatika',
                'position' => 'Focal Point Keamanan Informasi',
                'contact' => '[ISI: kontak resmi dinas]',
                'sort' => 1,
                'is_active' => true,
            ],
            [
                'name' => '[ISI: Nama Narahubung BPKPD]',
                'opd' => 'Badan Pengelolaan Keuangan dan Pendapatan Daerah',
                'position' => 'Focal Point Keamanan Informasi',
                'contact' => '[ISI: kontak resmi dinas]',
                'sort' => 2,
                'is_active' => true,
            ],
            [
                'name' => '[ISI: Nama Narahubung Bappeda]',
                'opd' => 'Badan Perencanaan Pembangunan Daerah',
                'position' => 'Focal Point Keamanan Informasi',
                'contact' => '[ISI: kontak resmi dinas]',
                'sort' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($agents as $agent) {
            Agent::query()->firstOrCreate(['name' => $agent['name'], 'opd' => $agent['opd']], $agent);
        }
    }

    private function events(): void
    {
        $events = [
            [
                'title' => 'Bimbingan Teknis Kesiapsiagaan Tanggap Insiden Siber OPD',
                'slug' => 'bimtek-kesiapsiagaan-tanggap-insiden-siber',
                'starts_at' => now()->addDays(14)->setTime(9, 0),
                'ends_at' => now()->addDays(14)->setTime(12, 30),
                'location' => 'Ruang Rapat Diskominfo Kota Pariaman',
                'description' => 'Bimbingan teknis peningkatan kompetensi agen siber perangkat daerah dalam melakukan triase dan pelaporan awal insiden.',
            ],
            [
                'title' => 'Sosialisasi Kesadaran Keamanan Siber dan Perlindungan Data SPBE',
                'slug' => 'sosialisasi-kesadaran-keamanan-siber-spbe',
                'starts_at' => now()->subDays(30)->setTime(9, 0),
                'ends_at' => now()->subDays(30)->setTime(12, 0),
                'location' => 'Aula Balaikota Pariaman',
                'description' => 'Peningkatan pemahaman pentingnya tata kelola keamanan kata sandi dan mitigasi serangan rekayasa sosial bagi ASN.',
            ],
        ];

        foreach ($events as $event) {
            Event::query()->firstOrCreate(['slug' => $event['slug']], $event + [
                'status' => PublishStatus::Published->value,
                'published_at' => now(),
            ]);
        }
    }
}
