# CMS-SPEC — Panel admin ala WordPress untuk Portal CSIRT Pariaman

Spesifikasi panel admin (Filament 5) untuk model **semua input dari admin** (`PRD.md` v0.2). Situs publik hanya membaca. Kode starter pendamping ada di `assets/laravel/`; dokumen ini mengatur **apa yang harus ada di panel**, bukan kode Filament-nya (API Filament berbeda antarversi: buat kerangka dengan `php artisan make:filament-resource <Model> --generate`, lalu sesuaikan, dan cek dokumen Filament 5 untuk namespace).

## 1. Prinsip

1. **Tidak ada teks resmi di kode.** Kontak, jam layanan, PGP, banner, tujuan tombol Lapor Insiden, dan kanal pelaporan hidup di Pengaturan (bagian 6). Di view, baca dari `$site[...]` atau `App\Support\Settings`.
2. **Admin menyusun, desain tetap konsisten.** Halaman dibangun dari **blok terbatas** (bagian 4), bukan HTML/CSS bebas. Teks kaya dibersihkan sebelum ditampilkan (`App\Support\Html`).
3. **Placeholder jujur.** Data resmi yang belum ada berupa `[ISI: ...]` dari `SiteSeeder`. Kanal dengan nilai placeholder tidak tampil sebagai tautan (`Settings::reportChannels()` menyaringnya), dan `security.txt` memberi 404 sampai email keamanan asli diisi.
4. **Tidak ada rute tulis publik.** Hanya login admin yang menerima data. Ada uji otomatis untuk ini (`PublicSiteTest`).
5. **2FA wajib** untuk semua pengguna panel (`SETUP.md` bagian 7).

## 2. Peran dan izin

Empat peran dari `RoleSeeder` (`super-admin`, `koordinator`, `analis`, `editor`). Terapkan lewat **Policy** per model; jangan mengandalkan menyembunyikan menu saja.

| Area | super-admin | koordinator | analis | editor |
|---|:-:|:-:|:-:|:-:|
| Halaman | ✅ | ✅ | ⛔ | ✅ |
| Berita dan Edukasi, Kategori | ✅ | ✅ | ⛔ | ✅ |
| Agenda, Galeri | ✅ | ✅ | ⛔ | ✅ |
| Advisori | ✅ | ✅ | ✅ | ⛔ |
| Dokumen | ✅ | ✅ | ✅ | ⛔ |
| Katalog Layanan | ✅ | ✅ | ✅ | ⛔ |
| Agen Siber | ✅ | ✅ | ⛔ | ⛔ |
| Portal Layanan | ✅ | ✅ | ⛔ | ⛔ |
| Menu | ✅ | ✅ | ⛔ | ⛔ |
| Pengaturan Situs | ✅ | ✅ | ⛔ | ⛔ |
| Log audit (baca saja) | ✅ | ✅ | ⛔ | ⛔ |
| Pengguna dan peran | ✅ | ⛔ | ⛔ | ⛔ |

Uji wajib: peran Editor mendapat 403 pada Pengaturan dan Menu; peran Analis tidak dapat membuka Halaman; pengguna tanpa peran CSIRT tidak dapat masuk panel (`canAccessPanel`).

## 3. Resource per jenis konten

Semua resource: daftar dengan pencarian, filter status, kolom **Status** memakai `publicationLabel()` (Draf / Terjadwal / Terbit), tombol **Pratinjau** (membuka rute `preview.*` di tab baru), konfirmasi sebelum hapus, dan pencatatan activity log (`LogsActivity`).

| Resource (model) | Kolom formulir | Aturan |
|---|---|---|
| **Halaman** (`Page`) | judul, slug, induk (opsional), templat (`default`/`wide`/`home`), **blok** (Builder, bagian 4), status, terbit pada, beranda (toggle), SEO: judul, deskripsi, gambar | slug unik, `^[a-z0-9-]+$`, **tidak boleh** ada di `Page::RESERVED_SLUGS`; hanya satu beranda (model menanganinya); halaman beranda tidak bisa dihapus selama tidak ada pengganti |
| **Berita / Edukasi** (`Post`) | jenis, kategori, judul, slug, ringkasan, isi (RichEditor), sampul + **teks alternatif**, video (URL YouTube), unduhan, status, terbit pada | `cover_alt` wajib bila ada sampul; `video_url` hanya `youtube.com`/`youtu.be`, diubah ke `youtube-nocookie.com` saat render; slug unik |
| **Kategori** (`Category`) | jenis, nama, slug | slug unik per jenis |
| **Advisori** (`Advisory`) | judul, slug, keparahan (Select `Severity`), ringkasan, sistem terdampak, mitigasi (RichEditor), status, terbit pada | keparahan wajib; slug unik |
| **Dokumen** (`Document`) | judul, kategori (`DocumentCategory`), berkas, versi, bahasa, tanggal berlaku, urutan, status, terbit pada | berkas PDF/DOCX/XLSX maks 20 MB, disk `public` |
| **Layanan** (`Service`) | kelompok (`ServiceGroup`), nama, slug, deskripsi, siapa yang bisa meminta, cara meminta, jam layanan, target respons, urutan, status | urut dengan `sort` |
| **Agen Siber** (`Agent`) | nama, OPD, jabatan, kontak resmi, foto, aktif, urutan | kontak resmi saja; foto opsional |
| **Agenda** (`Event`) | judul, slug, mulai, selesai, lokasi, deskripsi, status, terbit pada | selesai ≥ mulai |
| **Portal Layanan** (`PortalLink`) | judul, deskripsi, ikon (nama Lucide), URL, urutan, aktif | URL hanya `http`/`https` |
| **Galeri** (`gallery`, fase 3) | judul, slug, foto (banyak, tiap foto + teks alternatif), status | tabel sudah ada; model dan resource menyusul |

**Unggah berkas (FR-49):** gambar `jpg`/`jpeg`/`png`/`webp` maks 4 MB; **tolak SVG** (bisa membawa skrip); jangan aktifkan opsi mempertahankan nama berkas asli (nama acak adalah bawaan); simpan di disk `public` di folder per jenis (`covers/`, `documents/`, `agents/`). Jalankan `php artisan storage:link` sekali.

## 4. Halaman berblok (FR-01, FR-42)

Kolom `blocks` menyimpan keluaran Builder: `[{ "type": "...", "data": { ... } }, ...]`. Setiap jenis blok = satu view `resources/views/blocks/<type>.blade.php` yang menerima `$data`. Jenis yang tidak dikenal diabaikan; nama view hanya huruf kecil dan garis bawah (disaring di `pages/show.blade.php`). Blok **tidak boleh** menerima HTML/CSS/JS mentah selain lewat `rich_text` (dibersihkan).

| `type` | Data | Keterangan | Starter |
|---|---|---|:-:|
| `hero` | `title`, `subtitle`, `primary_label`, `secondary_label`, `secondary_url` | Tombol utama selalu ke `$reportUrl` (Pengaturan). `secondary_url` hanya jalur internal | ✅ |
| `rich_text` | `content` (HTML) | Dibersihkan lewat `Html::clean` | ✅ |
| `latest_advisories` | `heading`, `count` (1–6) | Advisori terbit terbaru, badge keparahan | ✅ |
| `report_channels` | — | Kartu kanal, daftar "Siapkan informasi ini", peringatan; semuanya dari Pengaturan | ✅ |
| `steps` | `heading`, `items[]` (`title`, `description`) | Tiga langkah melapor (DESIGN 8.1) | — |
| `service_cards` | `heading`, `group` (opsional), `count` | Kartu layanan terbit | — |
| `latest_posts` | `heading`, `type` (`news`/`education`), `count` | Berita/edukasi terbaru | — |
| `portal_links` | `heading` | Semua `PortalLink` aktif | — |
| `contact_block` | `heading` | Nomor darurat, email keamanan, jam layanan dari Pengaturan | — |
| `document_list` | `heading`, `category` | Dokumen terbit per kategori (untuk halaman RFC-2350) | — |
| `agent_table` | `heading` | Tabel agen dengan filter OPD | — |
| `callout` | `level` (`info`/`warning`/`danger`), `text` | Kotak pemberitahuan dengan ikon + teks | — |
| `image` | `file`, `alt` (**wajib**), `caption` | Gambar di kolom isi | — |
| `button` | `label`, `url` | URL internal atau http(s) | — |

Blok bertanda "—" dibuat agent dengan pola yang sama dengan blok starter (`@includeIf`, data tervalidasi, token desain). Konfigurasi Builder di panel hanya mendaftarkan jenis di tabel ini.

## 5. Pengelola menu (FR-43)

Resource `MenuItem` dengan dua lokasi (`header`, `footer`). Kolom: lokasi, label, jenis (`page` atau `url`), halaman (bila jenis `page`), URL (bila jenis `url`: jalur internal seperti `/berita` atau `http(s)://`), buka di tab baru, induk (hanya butir tanpa induk yang boleh jadi induk: **satu tingkat submenu**), urutan, aktif. Urutan lewat tarik-lepas bila resource mendukung (`reorderable('sort')` pada tabel). Peringatan di formulir bila menu header melebihi enam butir (DESIGN 6.2). `MenuItem::tree()` sudah menyaring halaman yang belum terbit, URL berbahaya (`javascript:`, `data:`), dan butir nonaktif, serta memakai cache yang dibersihkan otomatis saat disimpan.

## 6. Pengaturan Situs (FR-44, FR-48)

Satu halaman admin (Page Filament kustom, bukan resource) dengan tab; menyimpan lewat `Settings::set()`. Kunci yang dipakai kode starter:

| Tab | Kunci | Tipe | Keterangan |
|---|---|---|---|
| Identitas | `site.name`, `site.tagline`, `site.logo` | teks, teks, gambar | |
| Beranda | `hero.title`, `hero.subtitle` | teks | Bawaan untuk blok `hero` |
| Kontak | `contact.address`, `contact.phone`, `contact.emergency_phone`, `contact.email_security`, `contact.hours` | teks | `email_security` memicu `security.txt` bila valid |
| PGP | `pgp.fingerprint`, `pgp.key_file` | teks, berkas (`.asc`) | Fingerprint tampil monospasi dengan tombol Salin |
| Keamanan | `security.policy_url`, `security.expires` | URL, tanggal | Dipakai `security.txt` |
| Media sosial | `social.facebook`, `social.instagram`, `social.youtube`, `social.x` | URL | Hanya `http`/`https` |
| Footer | `footer.text` | teks | |
| **Saluran Pelaporan** | `report.cta_type` (`page`/`email`/`whatsapp`/`url`), `report.cta_value` | pilihan + teks | **Tujuan tombol Lapor Insiden** di header dan hero |
| | `report.channels` | Repeater: `type` (`email`/`whatsapp`/`phone`/`url`), `label`, `value`, `hours`, `enabled` | Kartu kanal pada halaman Saluran Pelaporan |
| | `report.checklist` | daftar teks | "Siapkan informasi ini" |
| | `report.warning` | teks | Peringatan keamanan |
| Banner darurat | `emergency.enabled` (toggle), `emergency.text`, `emergency.level` (`info`/`warning`/`danger`) | | Tampil di atas header semua halaman |

Validasi di panel: email valid untuk `email`, nomor untuk `whatsapp`/`phone`, URL `http(s)` untuk `url`, slug halaman yang ada untuk `cta_type=page`. Kode tetap memvalidasi ulang saat render (`ReportChannelType::href`).

## 7. Publikasi: draf, terbit, terjadwal (FR-46)

- Status tersimpan hanya `draft` atau `published`. **Terjadwal = `published` dengan `published_at` di masa depan.** Tidak perlu cron: kueri publik memakai `scopePublished()` yang membandingkan dengan waktu sekarang.
- Formulir: Select status + DateTimePicker "Terbit pada" (kosong = langsung). Zona waktu `Asia/Jakarta`.
- **Pratinjau:** tombol membuka `route('preview.page'|'preview.post'|'preview.advisory', $record)` di tab baru. Rute ini 404 untuk non-staf, `noindex`, dan tidak di-cache.
- Konten draf dan terjadwal **tidak boleh** muncul di daftar, detail, menu, sitemap, atau pencarian publik.

## 8. Rute publik dan nama view

Semua rute publik hanya `GET` (`routes/public.example.php`). View yang harus dibuat agent mengikuti `DESIGN.md` bagian 8:

| Rute | Controller | View | Halaman (DESIGN) |
|---|---|---|---|
| `/` | `PageController@home` | `pages.show` | 8.1 Beranda |
| `/{slug}` | `PageController@show` | `pages.show` | 8.2 Halaman isi, 8.3 Saluran Pelaporan, 8.5 Kontak |
| `/layanan` | `ServiceController@index` | `services.index` | 8.2 |
| `/agen-siber` | `AgentController@index` | `agents.index` | 8.2 |
| `/dokumen` | `DocumentController@index` | `documents.index` | 8.2 |
| `/agenda` | `EventController@index` | `events.index` | 8.4 |
| `/advisori`, `/advisori/{slug}` | `AdvisoryController` | `advisories.index`, `advisories.show` | 8.4 |
| `/berita`, `/edukasi`, dan `/{path}/{slug}` | `PostController` | `posts.index`, `posts.show` | 8.4 |
| `/pratinjau/...` | `PreviewController` | memakai view di atas dengan `$preview = true` | — |
| `/.well-known/security.txt` | `SecurityTxtController` | teks biasa | 8.5 |

Layout `layouts.app` menerima `$site`, `$menuHeader`, `$menuFooter`, `$reportUrl`, `$emergency` dari `SiteComposer`. Layout wajib: strip identitas, banner darurat (bila `$emergency`), header dengan menu dan tombol Lapor Insiden (`$reportUrl`), `@yield('content')`, footer; `@yield('title')` dan `@yield('description')` untuk metadata.

## 9. Cache dan kinerja (FR-54, fase 2)

`Settings` dan `MenuItem::tree()` sudah di-cache dan dibersihkan otomatis saat disimpan. Untuk halaman penuh, pakai cache fragmen atau paket response cache, dibersihkan pada event `saved`/`deleted` model konten. Jangan men-cache rute pratinjau.

## 10. Keamanan masukan admin

- Teks kaya: selalu lewat `Html::clean`. Tanpa `ezyang/htmlpurifier` hasilnya teks biasa (aman); pasang paketnya agar format tampil: `composer require ezyang/htmlpurifier`.
- URL dari admin: hanya `http`/`https` atau jalur internal diawali `/` (bukan `//`). Tautan keluar diberi `rel="noopener"`.
- Slug: huruf kecil, angka, tanda hubung; bukan slug terpesan.
- Unggahan: lihat bagian 3. Jangan pernah menaruh unggahan di luar disk yang ditentukan atau mengeksekusinya.
- Semua perubahan konten, menu, dan pengaturan tercatat di activity log (siapa, apa, kapan).
- Panel admin **tidak** memakai `PublicSecurityHeaders` (Filament butuh skrip/gaya inline). Lindungi dengan 2FA, path tidak lazim, batas percobaan login, dan bila bisa batas IP.

## 11. Urutan membangun

1. Pasang proyek dan paket (`SETUP.md` bagian 1–8), salin kode starter (bagian 10.1), jalankan migrasi dan `SiteSeeder`.
2. Buat `layouts.app` dan komponen dari `DESIGN.md`; daftarkan `SiteComposer`.
3. Panel: resource Halaman (Builder dengan blok starter), Pengaturan Situs, Menu. Setelah tiga ini admin sudah bisa mengubah beranda, menu, dan kanal pelaporan.
4. Resource lain sesuai fase `PRD.md` bagian 14 (Advisori, Berita, Dokumen, Layanan, Agen, Portal Layanan; Agenda dan Edukasi di fase 2).
5. View publik per rute (bagian 8), blok sisa (bagian 4), Policy per peran (bagian 2).
6. `php artisan test`, lalu `scripts/verify_build.sh`.

## 12. Kriteria penerimaan (cuplikan dari PRD)

| FR | Diterima bila |
|---|---|
| FR-01, FR-42 | Admin menambah, menghapus, dan mengurutkan blok beranda tanpa developer |
| FR-05, FR-44 | Mengganti `report.cta_type`/`value` mengubah tujuan tombol Lapor Insiden di semua halaman |
| FR-06 | `security.txt` 404 sebelum email asli diisi, lalu memuat Contact/Expires/Canonical |
| FR-41 | Editor 403 pada Pengaturan dan Menu |
| FR-43 | Butir menu ke halaman draf tidak tampil di situs |
| FR-46 | Konten terjadwal tidak terlihat sebelum waktunya dan tayang sesudahnya tanpa langkah manual |
| FR-49 | Unggahan SVG atau tipe di luar daftar ditolak |
| Seluruhnya | Tidak ada rute tulis publik (uji `exposes no public write endpoints`) |
