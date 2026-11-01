---
name: pariaman-csirt-site
description: Membangun, mengubah, atau meninjau website CSIRT Pemerintah Kota Pariaman (portal tanggap insiden siber Diskominfo) dengan Laravel 13, Blade, Tailwind v4, dan panel admin Filament ala WordPress, sesuai PRD dan design system yang disepakati. Gunakan saat diminta membuat halaman, blok halaman, pengelola menu, pengaturan situs, saluran pelaporan, advisori, RFC-2350, resource admin, migrasi, atau styling untuk proyek CSIRT Pariaman / Pemko Pariaman. Use for building or reviewing the Pariaman CSIRT Laravel CMS website against its PRD and design tokens.
---

# Website CSIRT Pemko Pariaman

## Tujuan

Membantu membangun portal CSIRT Pemko Pariaman agar **konsisten dengan PRD dan design system** di folder `references/`. Portal ini dipakai orang yang sedang cemas (situs diretas, data bocor), jadi aksi utama harus jelas, bahasa harus awam, dan keamanan situsnya sendiri harus terjaga.

## Model situs (inti keputusan PRD v0.2)

**Situs publik hanya membaca. Semua input masuk lewat panel admin ala WordPress.** Admin mengatur halaman (berblok), menu, konten, kontak, kanal pelaporan, dan tujuan tombol Lapor Insiden tanpa developer. Tidak ada formulir, sistem tiket, cek status, langganan email, atau CAPTCHA di sisi publik. Pelaporan insiden dilakukan lewat kanal yang diatur admin (email, WhatsApp, telepon, URL helpdesk). Bila pengguna meminta fitur yang menerima input dari publik, sebutkan bahwa itu mengubah keputusan PRD dan tanyakan dulu.

## Stack (keputusan, jangan diganti tanpa persetujuan)

Laravel 13 (PHP 8.3+) · Nginx + PHP-FPM · MySQL/MariaDB atau PostgreSQL · Blade + Tailwind CSS v4 + Alpine.js untuk situs publik · **Filament 5** untuk panel admin · `spatie/laravel-permission` (peran) · `spatie/laravel-activitylog` (audit) · MFA bawaan Filament (diwajibkan) · `ezyang/htmlpurifier` (pembersih teks kaya) · Pest, Larastan, Pint. Rincian dan alasan ada di `references/PRD.md` bagian 13.1.

Situs publik **tidak** memakai Inertia/React. Livewire hanya di panel admin.

## Sumber kebenaran

| Kebutuhan | Berkas |
|---|---|
| Fitur, prioritas, alur, model data, fase rilis, stack | `references/PRD.md` |
| Warna, tipografi, komponen, template halaman, aksesibilitas | `references/DESIGN.md` |
| Spesifikasi panel admin: peran, resource, blok, menu, pengaturan, publikasi, rute dan view | `references/CMS-SPEC.md` |
| Instalasi proyek, penempatan file, peta PRD → file Laravel | `references/SETUP.md` |
| Token desain (salinan acuan) | `assets/tokens.css` |
| Pemetaan token ke Tailwind v4 | `assets/theme.css` |
| Contoh hasil yang benar untuk halaman Saluran Pelaporan | `examples/saluran-pelaporan.html` |
| Kode starter CMS: migrasi, seeder, enum, model, controller, middleware, view blok, uji Pest | `assets/laravel/` (belum dijalankan di Laravel hidup; sintaks PHP dan logika enum sudah diperiksa) |
| Cek kontras warna otomatis | `scripts/check_contrast.py` |
| Cek token selaras dengan pemetaan Tailwind | `scripts/check_tokens_sync.py` |
| Verifikasi akhir proyek (Pint, uji, audit, build, kontras, formulir publik) | `scripts/verify_build.sh` |

Baca hanya bagian yang relevan dengan tugas. Kebutuhan di PRD diberi ID (`FR-xx`); sebutkan ID tersebut saat melaporkan apa yang sudah dikerjakan.

## Langkah kerja

1. **Tentukan lingkup.** Cocokkan permintaan dengan ID kebutuhan di `references/PRD.md` dan fase di bagian 14 PRD. Jika di luar fase yang berjalan, sebutkan dan tanyakan dulu.
2. **Cek proyek yang ada.** Lihat `composer.json`, `package.json`, dan struktur `app/`, `resources/`, `routes/`. Ikuti konvensi yang sudah ada. Jika proyek Laravel belum ada, arahkan ke `references/SETUP.md` bagian 1–8 dan jangan membangun di luar proyek.
3. **Mulai dari starter, bukan dari nol.** Bila kode starter belum disalin, ikuti `references/SETUP.md` bagian 10.1. Pola blok, model, dan controller baru meniru yang ada di `assets/laravel/`.
4. **Pakai token, bukan nilai mentah.** Token hidup di `resources/css/tokens.css` dan dipetakan ke Tailwind lewat `resources/css/theme.css`. Gunakan utilitas seperti `bg-brand-700`, `text-ink`, `border-line`, `font-heading`. Jangan menulis kode hex di komponen.
5. **Ikuti template halaman** di `references/DESIGN.md` bagian 8 dan komponen di bagian 7. Untuk Saluran Pelaporan, tiru `examples/saluran-pelaporan.html`, lalu terjemahkan ke Blade.
6. **Tentukan di mana sebuah fitur hidup** menurut `references/CMS-SPEC.md`: konten baru → Resource Filament + Policy + view publik; bagian halaman baru → blok `resources/views/blocks/<type>.blade.php` + daftar di Builder; nilai yang bisa berubah (kontak, jam, tujuan tombol) → kunci Pengaturan, bukan kode.
7. **Data resmi yang belum ada = placeholder.** Nama tim, SK, alamat, telepon, email keamanan, fingerprint PGP, dan kanal pelaporan ditandai `[ISI: ...]`. Jangan mengarang nilai yang tampak asli. Placeholder tidak boleh menjadi tautan aktif (starter sudah menyaringnya).
8. **Verifikasi sebelum selesai:**
   - Jika token warna berubah atau pasangan warna baru dipakai: `python3 .agents/skills/pariaman-csirt-site/scripts/check_contrast.py resources/css/tokens.css` sampai kode keluar 0.
   - `bash .agents/skills/pariaman-csirt-site/scripts/verify_build.sh` dari akar proyek (Pint, `php artisan test`, `composer audit`, build aset, kontras, sinkron token, deteksi `<form` di view publik). Perbaiki semua yang GAGAL; laporkan peringatan.
   - Telusuri daftar periksa `references/DESIGN.md` bagian 13 untuk halaman yang disentuh, dan kriteria penerimaan `references/CMS-SPEC.md` bagian 12.
   - Pastikan halaman bisa dipakai dengan keyboard saja dan setiap gambar punya teks alternatif.
9. **Laporkan singkat**: berkas yang dibuat/diubah, ID `FR-xx` yang tercakup, dan hal yang masih `[ISI]` atau perlu keputusan. Nyatakan jujur bila sesuatu belum dijalankan.

## Contoh

**Permintaan:** "Buat halaman Saluran Pelaporan."
**Respons yang benar:** merujuk `FR-05`; halaman dinamis dengan slug `saluran-pelaporan` berisi blok `rich_text` dan `report_channels`; kartu kanal dari Pengaturan (`report.channels`), bukan di kode; tombol aksi memakai tautan aman (`mailto:`, `wa.me`, `tel:`, atau `http(s)`); tombol Salin lewat `resources/js/copy.js`; daftar "Siapkan informasi ini" dan peringatan jangan kirim kata sandi dari Pengaturan; **tanpa** `<form>`. Mulai dari `examples/saluran-pelaporan.html`.

**Permintaan:** "Ganti tombol Lapor Insiden agar membuka WhatsApp."
**Respons yang benar:** tidak mengubah kode; atur `report.cta_type = whatsapp` dan `report.cta_value` di Pengaturan Situs. Bila admin belum punya layarnya, buat halaman Pengaturan (`CMS-SPEC.md` bagian 6) dan tampilkan tujuan lewat `Settings::reportCtaUrl()`.

**Permintaan:** "Tambahkan blok kartu layanan di beranda."
**Respons yang benar:** buat blok `service_cards` (`CMS-SPEC.md` bagian 4) dengan view `blocks/service_cards.blade.php`, daftarkan di Builder Halaman, ambil layanan lewat scope `published()`, dan tampilkan tanpa menyentuh kode beranda; admin yang menaruhnya lewat panel.

**Permintaan:** "Tambahkan badge keparahan di daftar advisori."
**Respons yang benar:** gunakan komponen `x-badge-severity` (ikon + teks + warna) yang sudah ada; tidak mengandalkan warna saja.

**Permintaan:** "Buat tombol di hero warna emas dengan teks emas."
**Respons yang benar:** tolak kombinasi itu dengan alasan kontras (emas sebagai teks di atas terang hanya 1,88:1) dan tawarkan tombol primer-emas (latar emas, teks `navy-900`) di atas latar navy.

**Permintaan:** "Tambah formulir kontak / lapor insiden di situs."
**Respons yang benar:** jelaskan bahwa PRD v0.2 memutuskan situs tanpa input publik (tanpa formulir, tiket, CAPTCHA); tawarkan kanal pelaporan yang diatur admin. Lanjut membuat formulir hanya setelah pengguna secara eksplisit mengubah keputusan itu, dengan konsekuensi keamanan (validasi, batas laju, CAPTCHA, penyimpanan data) dibahas dulu.

## Batasan (jangan dilakukan)

- Jangan menambah **rute tulis publik** (`POST/PUT/PATCH/DELETE`) atau `<form>` di view publik (kecuali bila PRD diubah). Uji `exposes no public write endpoints` harus tetap lulus.
- Jangan menanam nilai kontak, jam layanan, PGP, atau tujuan tombol lapor di kode atau view; semuanya dari Pengaturan.
- Jangan memberi admin HTML/CSS/JS mentah. Halaman hanya dari blok terbatas; teks kaya selalu lewat `Html::clean`.
- Jangan menerima URL dari admin tanpa validasi: hanya `http`/`https` atau jalur internal `/...` (bukan `//`); tolak `javascript:` dan `data:`.
- Jangan menaruh emas (`accent-400`) sebagai **teks atau ikon** di atas latar putih/terang.
- Jangan memakai `outline: none` tanpa indikator fokus pengganti.
- Jangan menambah butir menu header di atas enam. *Lapor Insiden* adalah tombol aksi, bukan butir menu.
- Jangan memakai gaya "hacker" (hijau neon, latar hitam penuh, efek kode jatuh) dan jangan membuat mode gelap pada fase 1.
- Jangan memuat font atau skrip dari CDN pihak ketiga yang tidak perlu; font ditanam sendiri lewat `@fontsource/*`. Tanpa skrip inline di halaman publik (CSP `script-src 'self'`).
- Jangan mengizinkan unggah SVG atau tipe berkas di luar daftar di `CMS-SPEC.md` bagian 3, dan jangan menyimpan unggahan di luar disk yang ditentukan.
- Jangan membuat query dengan menyambung string dari input; pakai Eloquent atau parameter terikat.
- Jangan menonaktifkan 2FA admin, melewati Policy, atau memberi akses panel ke pengguna tanpa peran CSIRT.
- Jangan memasang `PublicSecurityHeaders` pada panel Filament (CSP ketat memblokir skrip panel).
- Jangan menaruh `security.txt` statis di `public/`; berkas dibangkitkan dari Pengaturan.
- Jangan mengganti stack (mis. ke Next.js atau Inertia/React) tanpa persetujuan.
- Jangan mengarang data kontak, SK, struktur organisasi, atau kunci PGP.
- Jangan memakai `--ignore-platform-reqs` atau memaksa instalasi paket yang tidak kompatibel; laporkan konfliknya.
- Jangan menyalin tampilan situs lain; desain ini sengaja dirancang ulang.
