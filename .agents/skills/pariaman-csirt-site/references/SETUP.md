# SETUP.md — Dari instalasi Laravel sampai skill terpasang di Antigravity

Panduan ini membangun kerangka proyek **Portal CSIRT Pemko Pariaman** (stack di `PRD.md` bagian 13.1) lalu memasang skill ini di Antigravity. Model situsnya: **publik hanya membaca, semua input lewat panel admin ala WordPress** (lihat `CMS-SPEC.md`).

> **Status verifikasi.** Perintah `composer` dan `php artisan` di bawah berasal dari dokumentasi resmi (Laravel, Filament, Spatie) dan **belum dijalankan** oleh penyusun panduan ini, karena sandbox penyusun tidak bisa mengakses Packagist. Yang sudah diuji langsung: pemetaan Tailwind v4 (`assets/theme.css`), paket font `@fontsource/*`, dan script kontras dan sinkron token. Kode starter CMS di `assets/laravel/` hanya diperiksa sintaks PHP-nya (`php -l`) dan logika enum-nya dengan uji PHP murni; belum pernah dijalankan di Laravel hidup, jadi jalankan `php artisan test` dan sesuaikan. Bila ada perintah yang gagal, salin pesan galatnya ke Antigravity beserta skill ini.

---

## 0. Prasyarat

| Kebutuhan | Versi | Catatan |
|---|---|---|
| PHP | **8.3 atau lebih baru** | Laravel 13 tidak lagi mendukung PHP 8.2 |
| Composer | 2.x | |
| Node.js + npm | LTS terbaru | Untuk Vite dan Tailwind |
| Basis data | MySQL/MariaDB **atau** PostgreSQL | Samakan jenisnya dengan server produksi |
| Git | terbaru | |
| Python 3 | 3.8+ | Hanya untuk `check_contrast.py` |

Ekstensi PHP yang dibutuhkan Laravel: `ctype, curl, dom, fileinfo, filter, hash, mbstring, openssl, pcre, pdo, session, tokenizer, xml`, ditambah driver basis data (`pdo_mysql` atau `pdo_pgsql`). Filament biasanya meminta `intl`. Bila ada yang kurang, Composer akan menyebutkannya saat instalasi.

Periksa: `php -v`, `composer --version`, `node -v`.

---

## 1. Pasang PHP, Composer, dan Laravel installer

**Sudah punya PHP dan Composer?** Cukup pasang installer:

```bash
composer global require laravel/installer
```

Pastikan folder bin global Composer ada di `PATH` (Linux/macOS biasanya `~/.config/composer/vendor/bin` atau `~/.composer/vendor/bin`; Windows `%APPDATA%\Composer\vendor\bin`). Periksa dengan `laravel --version`.

**Belum punya?** Satu perintah dari dokumentasi Laravel memasang PHP, Composer, dan installer sekaligus. Tutup lalu buka ulang terminal setelahnya.

```bash
# Linux
/bin/bash -c "$(curl -fsSL https://php.new/install/linux/8.5)"

# macOS
/bin/bash -c "$(curl -fsSL https://php.new/install/mac/8.5)"
```

```powershell
# Windows PowerShell (jalankan sebagai administrator)
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.5'))
```

> Samakan versi PHP lokal dengan server Diskominfo (minimal 8.3). Skrip di atas memasang PHP 8.5; itu aman untuk pengembangan asalkan kode tidak memakai fitur yang tidak ada di PHP 8.3.

---

## 2. Buat proyek

```bash
laravel new csirt-pariaman
cd csirt-pariaman
```

Installer akan bertanya beberapa hal. Pilihan yang disarankan (label pertanyaan bisa sedikit berbeda antarversi installer):

| Pertanyaan | Pilihan |
|---|---|
| Starter kit | **None** (panel admin memakai Filament; situs publik dibuat sendiri) |
| Testing framework | **Pest** |
| Database | MySQL atau PostgreSQL sesuai produksi (SQLite boleh untuk uji cepat) |
| Install npm dependencies | Ya |

Alternatif tanpa installer: `composer create-project laravel/laravel csirt-pariaman`.

Mulai repositori:

```bash
git init            # lewati bila installer sudah membuatnya
git add -A && git commit -m "Kerangka awal Laravel"
```

---

## 3. Basis data

Buat basis data dan pengguna khusus (jangan memakai `root`).

**MySQL/MariaDB**

```sql
CREATE DATABASE csirt_pariaman CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'csirt'@'localhost' IDENTIFIED BY 'GANTI_DENGAN_KATA_SANDI_KUAT';
GRANT ALL PRIVILEGES ON csirt_pariaman.* TO 'csirt'@'localhost';
```

`.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=csirt_pariaman
DB_USERNAME=csirt
DB_PASSWORD=GANTI_DENGAN_KATA_SANDI_KUAT
```

**PostgreSQL**

```bash
createdb csirt_pariaman
```

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=csirt_pariaman
DB_USERNAME=csirt
DB_PASSWORD=GANTI_DENGAN_KATA_SANDI_KUAT
```

Lalu:

```bash
php artisan migrate
```

---

## 4. Lokalisasi Indonesia

Di `.env`:

```env
APP_NAME="CSIRT Kota Pariaman"
APP_URL=http://localhost:8000
APP_LOCALE=id
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=id_ID
```

Di `config/app.php`, ubah zona waktu:

```php
'timezone' => 'Asia/Jakarta',
```

Opsional, terjemahan pesan validasi bahasa Indonesia lewat paket komunitas `laravel-lang` (ikuti dokumentasinya).

---

## 5. Panel admin: Filament 5

Syarat Filament 5: PHP 8.2+, Laravel 11.28+, Tailwind CSS 4.1+. Skeleton Laravel 13 memenuhinya.

```bash
composer require filament/filament:"^5.0"
php artisan filament:install --panels
php artisan make:filament-user
```

Perintah kedua membuat `app/Providers/Filament/AdminPanelProvider.php`. Jika `/admin` galat, pastikan provider itu terdaftar di `bootstrap/providers.php`. Sebelum bagian 7 dikerjakan, panel dapat dibuka di `http://localhost:8000/admin`; setelah itu alamatnya menjadi `/panel-csirt`.

---

## 6. Peran, izin, dan log audit (Spatie)

**Peran dan izin** (FR-41):

```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan optimize:clear
php artisan migrate
```

Tambahkan trait ke `app/Models/User.php`:

```php
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    // ...
}
```

Bila migrasi MySQL 8+ memunculkan error 1071 (panjang indeks), ikuti catatan *Prerequisites* di dokumentasi Spatie.

Buat seeder empat peran dari PRD:

```bash
php artisan make:seeder RoleSeeder
```

```php
// database/seeders/RoleSeeder.php
use Spatie\Permission\Models\Role;

public function run(): void
{
    foreach (['super-admin', 'koordinator', 'analis', 'editor'] as $nama) {
        Role::firstOrCreate(['name' => $nama, 'guard_name' => 'web']);
    }
}
```

```bash
php artisan db:seed --class=RoleSeeder
```

**Log audit** (FR-44):

```bash
composer require spatie/laravel-activitylog
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-migrations"
php artisan migrate
```

> Jika `composer require` menolak salah satu paket karena belum kompatibel dengan Laravel 13, catat pesannya. Jangan memaksa dengan `--ignore-platform-reqs`; minta Antigravity memeriksa versi paket yang kompatibel.

---

## 7. Kunci panel admin: batas akses dan 2FA wajib (FR-40)

Filament menyediakan *multi-factor authentication* bawaan (aplikasi authenticator, dengan kode pemulihan). Langkahnya:

**a. Migrasi kolom**

```bash
php artisan make:migration add_mfa_columns_to_users_table --table=users
```

```php
Schema::table('users', function (Blueprint $table) {
    $table->text('app_authentication_secret')->nullable();
    $table->text('app_authentication_recovery_codes')->nullable();
});
```

```bash
php artisan migrate
```

**b. Model `User`**

```php
use Filament\Auth\MultiFactor\App\Concerns\InteractsWithAppAuthentication;
use Filament\Auth\MultiFactor\App\Concerns\InteractsWithAppAuthenticationRecovery;
use Filament\Auth\MultiFactor\App\Contracts\HasAppAuthentication;
use Filament\Auth\MultiFactor\App\Contracts\HasAppAuthenticationRecovery;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser, HasAppAuthentication, HasAppAuthenticationRecovery
{
    use HasRoles;
    use InteractsWithAppAuthentication;
    use InteractsWithAppAuthenticationRecovery;

    // Hanya empat peran CSIRT yang boleh masuk panel
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasAnyRole(['super-admin', 'koordinator', 'analis', 'editor']);
    }
}
```

> Contoh di dokumentasi Filament juga menyertakan `MustVerifyEmail`; tambahkan bila Anda mengaktifkan verifikasi email.

**c. `AdminPanelProvider`**

```php
use Filament\Auth\MultiFactor\App\AppAuthentication;

public function panel(Panel $panel): Panel
{
    return $panel
        ->id('admin')
        ->path('panel-csirt')          // ganti dari /admin default; pilih yang tidak mudah ditebak
        ->login()
        ->profile()                    // tempat pengguna mengatur 2FA
        ->multiFactorAuthentication([
            AppAuthentication::make()->recoverable(),
        ], isRequired: true)           // pengguna tanpa 2FA dipaksa mengatur setelah login
        // ...
        ;
}
```

**d. Beri peran ke akun pertama**

```bash
php artisan tinker
>>> App\Models\User::first()->assignRole('super-admin');
```

Catatan: kode MFA Filament menyimpan status di *cache store* bawaan; bila nanti ada lebih dari satu server, semua server harus memakai cache yang sama (mis. Redis).

---

## 8. Frontend: token desain, Tailwind v4, font self-hosted

Skeleton Laravel memakai Tailwind v4 dengan Vite. Salin token dari skill (setelah skill dipasang di bagian 9, atau langsung dari zip):

```bash
cp .agents/skills/pariaman-csirt-site/assets/tokens.css resources/css/tokens.css
cp .agents/skills/pariaman-csirt-site/assets/theme.css  resources/css/theme.css
```

Pasang font self-hosted:

```bash
npm install @fontsource/plus-jakarta-sans @fontsource/inter @fontsource/jetbrains-mono
```

Ubah `resources/css/app.css`. **Pertahankan** baris `@source` dan blok lain yang sudah ada dari skeleton; tambahkan impor tepat setelah `@import 'tailwindcss';`:

```css
@import 'tailwindcss';
@import './tokens.css';
@import './theme.css';

@import '@fontsource/plus-jakarta-sans/600.css';
@import '@fontsource/plus-jakarta-sans/700.css';
@import '@fontsource/plus-jakarta-sans/800.css';
@import '@fontsource/inter/400.css';
@import '@fontsource/inter/500.css';
@import '@fontsource/inter/600.css';
@import '@fontsource/jetbrains-mono/400.css';

/* ...baris @source dan @theme bawaan skeleton tetap di sini */
```

Setelah ini utilitas seperti `bg-brand-700`, `text-ink`, `bg-navy-900`, `border-line-input`, `rounded-lg`, `font-heading` tersedia di Blade. Nilai warna hanya hidup di `resources/css/tokens.css`; jangan menyalin kode hex ke komponen.

Panel Filament memakai tema bawaannya pada fase 1. Tema kustom admin bisa menyusul (ikuti dokumentasi Filament).

---

## 9. Pasang skill di Antigravity (letak file)

Antigravity mendukung dua lokasi skill:

| Lingkup | Folder | Dipakai bila |
|---|---|---|
| **Proyek (disarankan)** | `<akar-proyek>/.agents/skills/` | Skill hanya untuk proyek CSIRT ini, ikut di-commit ke Git sehingga seluruh tim memakainya |
| Global | `~/.gemini/config/skills/` | Skill ingin tersedia di semua proyek di komputer ini |
| Global, Antigravity CLI | `~/.gemini/antigravity-cli/skills/` | Bila memakai CLI |

Perhatikan: nama folder proyek adalah **`.agents`** (dengan "s").

**Langkah (proyek):** dari dalam folder `csirt-pariaman`:

```bash
mkdir -p .agents/skills
unzip /jalur/ke/pariaman-csirt-site.zip -d .agents/skills/
```

Windows PowerShell:

```powershell
New-Item -ItemType Directory -Force .agents\skills | Out-Null
Expand-Archive -Path C:\jalur\ke\pariaman-csirt-site.zip -DestinationPath .agents\skills\
```

Hasil akhirnya harus seperti ini (`SKILL.md` langsung di bawah folder skill, bukan satu tingkat lebih dalam):

```
csirt-pariaman/                       ← akar proyek Laravel (buka folder ini di Antigravity)
├── .agents/
│   └── skills/
│       └── pariaman-csirt-site/
│           ├── SKILL.md
│           ├── references/
│           │   ├── PRD.md
│           │   ├── DESIGN.md
│           │   ├── CMS-SPEC.md           ← spesifikasi panel admin
│           │   └── SETUP.md
│           ├── assets/
│           │   ├── tokens.css
│           │   ├── theme.css
│           │   └── laravel/              ← kode starter CMS (bagian 10.1)
│           ├── scripts/
│           │   ├── check_contrast.py
│           │   ├── check_tokens_sync.py
│           │   └── verify_build.sh
│           └── examples/
│               └── saluran-pelaporan.html
├── app/
├── bootstrap/
├── config/
├── database/
├── resources/
│   └── css/
│       ├── app.css
│       ├── tokens.css                ← salinan hidup (hasil langkah 8)
│       └── theme.css
├── routes/
├── composer.json
└── ...
```

Jika `unzip` membuat `.agents/skills/pariaman-csirt-site/pariaman-csirt-site/`, pindahkan isinya satu tingkat ke atas.

**Pemeriksaan:**

1. Buka folder `csirt-pariaman` di Antigravity (**File → Open Folder**).
2. Mulai percakapan agen baru dan tanyakan: `What skills are available?` Skill `pariaman-csirt-site` harus muncul. Di Antigravity CLI, jalankan `/skills`.
3. Jika tidak terdeteksi: periksa nama folder `.agents`, pastikan `SKILL.md` berada tepat satu tingkat di bawah `pariaman-csirt-site/`, lalu buka percakapan baru.
4. Skill dipicu otomatis lewat kecocokan dengan `description`. Bila tidak terpanggil, sebut namanya: *"Gunakan skill pariaman-csirt-site untuk membuat halaman Lapor Insiden."*

**Contoh perintah pertama ke agen:**

- `Gunakan skill pariaman-csirt-site. Salin kode starter CMS ke proyek (SETUP bagian 10.1), jalankan migrasi dan SiteSeeder, lalu buat layouts.app sesuai CMS-SPEC bagian 8 dan DESIGN.md bagian 6.`
- `Gunakan skill pariaman-csirt-site. Buat Filament Resource Halaman dengan Builder blok (CMS-SPEC bagian 4), plus halaman Pengaturan Situs dan Menu (bagian 5 dan 6).`
- `Gunakan skill pariaman-csirt-site. Buat blok steps, service_cards, dan contact_block sesuai pola blok starter dan DESIGN.md bagian 8.1.`
- `Gunakan skill pariaman-csirt-site. Buat Filament Resource Advisori dengan badge keparahan, status draf/terjadwal/terbit, dan tombol Pratinjau (FR-30, FR-45, FR-46).`

---

## 10. Peta: kebutuhan PRD → letak file di Laravel

| Kebutuhan | Letak di proyek |
|---|---|
| Rute publik (semuanya `GET`) | `routes/web.php` (dari `routes/public.example.php`) |
| Controller halaman publik, pratinjau, `security.txt` | `app/Http/Controllers/` |
| Model konten, menu, pengaturan | `app/Models/` + migrasi di `database/migrations/` |
| Enum (status, keparahan, jenis kanal, dst.) | `app/Enums/` |
| Pengaturan Situs (kunci-nilai, ber-cache) | `app/Support/Settings.php`; halaman admin di `app/Filament/Pages/` |
| Panel admin: resource per konten (FR-45), Builder halaman (FR-42), menu (FR-43) | `app/Filament/Resources/`, `app/Filament/Pages/` |
| Kebijakan akses per peran (FR-41) | `app/Policies/` + peran di `RoleSeeder` |
| Blok halaman (FR-42) | `resources/views/blocks/<type>.blade.php` |
| Tampilan publik | `resources/views/` (layout di `layouts/app.blade.php`, komponen di `components/`) |
| Data bersama layout (menu, kontak, tombol lapor, banner) | `app/View/Composers/SiteComposer.php` |
| Pembersih teks kaya | `app/Support/Html.php` (+ `ezyang/htmlpurifier`) |
| Header keamanan, CSP (hanya rute publik) | `app/Http/Middleware/PublicSecurityHeaders.php` |
| Berkas `/.well-known/security.txt` (FR-06) | Dibangkitkan `SecurityTxtController` dari Pengaturan; **jangan** menaruh berkas statis di `public/` |
| Unggahan admin (FR-49) | Disk `public` (`storage/app/public`, `php artisan storage:link`); tipe dibatasi, SVG ditolak |
| Tombol Salin | `resources/js/copy.js` (impor dari `resources/js/app.js`) |
| Tes | `tests/Feature/` (Pest) |

### 10.1 Kode starter CMS (assets/laravel/)

Skill membawa kerangka kode untuk sisi publik dan model data CMS. Panel Filament sengaja **tidak** disertakan: API Filament berbeda antarversi, jadi agen membuatnya mengikuti `CMS-SPEC.md`. Salin dari akar proyek Laravel:

```bash
S=.agents/skills/pariaman-csirt-site/assets/laravel
cp -r $S/app/. app/
cp -r $S/database/. database/
cp -r $S/resources/. resources/
cp -r $S/tests/. tests/
```

> Starter tidak memuat `User.php`, `DatabaseSeeder.php`, atau `welcome.blade.php`, jadi tidak ada berkas bawaan Laravel yang tertimpa. Tetap cek `git status` setelah menyalin. `routes/public.example.php` sengaja tidak disalin (langkah 1).

Lalu, masih manual:

1. **Rute.** Tempel isi `routes/public.example.php` ke `routes/web.php` (hapus rute `welcome` bawaan). Daftarkan composer di `AppServiceProvider::boot()` seperti dicontohkan di komentar berkas itu.
2. **Layout.** Buat `resources/views/layouts/app.blade.php` sesuai `CMS-SPEC.md` bagian 8 (strip identitas, banner darurat, header + tombol Lapor Insiden ke `$reportUrl`, `@yield('content')`, footer) dan `DESIGN.md` bagian 6. Tambahkan `import './copy';` di `resources/js/app.js` dan muat `@vite(['resources/css/app.css','resources/js/app.js'])`.
3. **View publik** yang belum ada: `posts.index`, `posts.show`, `advisories.index`, `advisories.show`, `documents.index`, `services.index`, `agents.index`, `events.index` (nama dan isi di `CMS-SPEC.md` bagian 8). View `pages.show`, empat blok, dan badge keparahan sudah ada.
4. **Paket pembersih HTML:** `composer require ezyang/htmlpurifier`. Tanpa ini teks kaya tampil sebagai teks biasa (aman, tapi tanpa format).
5. **Basis data:** `php artisan migrate`, lalu `php artisan db:seed --class=RoleSeeder` dan `php artisan db:seed --class=SiteSeeder`. Seeder mengisi halaman awal, menu, dan pengaturan dengan placeholder `[ISI: ...]` dan aman dijalankan ulang. Tambahkan `php artisan storage:link`.
6. **Panel admin:** minta agen membuat Resource, halaman Pengaturan Situs, dan Menu mengikuti `CMS-SPEC.md` bagian 2–6 (urutan di bagian 11).
7. **Uji:** `php artisan test`. `PublicSiteTest` mencakup halaman draf/terjadwal, rute tetap tidak bisa ditimpa slug dinamis, tombol lapor yang bisa diatur admin (nilai berbahaya ditolak), tautan kanal yang aman, menu, pembersihan HTML, `security.txt`, dan **tidak adanya rute tulis publik**.
8. **Isi data resmi** lewat panel (kontak, kanal pelaporan, PGP). `security.txt` baru aktif setelah email keamanan asli diisi.

Catatan: `PublicSecurityHeaders` hanya dipasang pada rute publik (sudah begitu di berkas rute). **Jangan** dipasang pada panel Filament: panel memakai skrip dan gaya inline yang akan diblokir CSP ketat.

---

## 11. Jalankan dan periksa

```bash
npm install
npm run build
composer run dev       # server Laravel, antrean, dan Vite sekaligus; buka http://localhost:8000
```

Alternatif minimal: `php artisan serve`. Panel admin: `http://localhost:8000/panel-csirt` (atau `/admin` bila bagian 7 belum dikerjakan).

Periksa kontras bila token berubah:

```bash
python3 .agents/skills/pariaman-csirt-site/scripts/check_contrast.py resources/css/tokens.css
```

Kode keluar 0 berarti semua 23 pasangan lolos.

Alat mutu kode:

```bash
./vendor/bin/pint            # gaya kode
php artisan test             # tes
composer audit               # kerentanan dependensi
```

Atau semuanya sekaligus (plus build aset, kontras, sinkron token, dan peringatan produksi):

```bash
bash .agents/skills/pariaman-csirt-site/scripts/verify_build.sh
```

---

## 12. Catatan sebelum produksi

- `.env` produksi: `APP_ENV=production`, `APP_DEBUG=false`, `APP_KEY` unik; jangan pernah commit `.env`.
- Jalankan `php artisan optimize` setelah deploy. Situs tidak mengirim email, jadi antrean tidak wajib; pakai cache bersama (Redis) bila server lebih dari satu.
- Dokumen akar web server mengarah ke folder `public/`, bukan akar proyek.
- Aktifkan HTTPS dan HSTS; atur header keamanan sesuai `PRD.md` bagian 9.1.
- Backup basis data dan folder `storage/` secara harian dan uji pemulihannya.
- Lakukan uji penetrasi atau tinjauan keamanan sebelum rilis publik.
- Isi semua `[ISI]` lewat panel admin (SK, kontak, kanal pelaporan, PGP) sebelum rilis; jangan menayangkan placeholder. Tentukan siapa yang memantau kanal pelaporan (PRD, pertanyaan terbuka no. 2).
- Panel admin: batasi percobaan login, pertimbangkan batas IP, dan pastikan semua pengguna sudah mengatur 2FA.

---

## 13. Pemecahan masalah singkat

| Gejala | Kemungkinan penyebab dan tindakan |
|---|---|
| `laravel: command not found` | Folder bin global Composer belum ada di `PATH` (bagian 1) |
| Composer menolak versi PHP | PHP < 8.3; perbarui PHP (bagian 0) |
| `/admin` galat setelah `filament:install` | Provider belum terdaftar di `bootstrap/providers.php` |
| Gambar unggahan tidak tampil (404) | `php artisan storage:link` belum dijalankan, atau `APP_URL` salah |
| Utilitas Tailwind tidak muncul (mis. `bg-brand-700`) | `tokens.css` dan `theme.css` belum diimpor di `app.css`, atau urutan impor terbalik; jalankan ulang `npm run build` |
| Font tidak berubah | Impor `@fontsource/*` belum ada di `app.css`, atau nama keluarga font di `tokens.css` diubah |
| Skill tidak muncul di Antigravity | Nama folder bukan `.agents`, `SKILL.md` terlalu dalam, atau percakapan lama; buka percakapan baru |
| MySQL error 1071 saat migrasi Spatie | Ikuti catatan *Prerequisites* Spatie tentang panjang indeks |

---

## Sumber

- [Laravel — instalasi](https://laravel.com/docs/13.x/installation)
- [Laravel News — Laravel 13 dirilis](https://laravel-news.com/index.php/laravel-13-released)
- [Filament 5 — instalasi](https://filamentphp.com/docs/5.x/introduction/installation.md)
- [Filament 5 — multi-factor authentication](https://filamentphp.com/docs/5.x/users/multi-factor-authentication.md)
- [Spatie laravel-permission — instalasi](https://spatie.be/docs/laravel-permission/installation-laravel)
- [Spatie laravel-activitylog — instalasi](https://spatie.be/index.php/docs/laravel-activitylog/v5/installation-and-setup)
- [Google Codelabs — skill Antigravity](https://codelabs.developers.google.com/getting-started-with-antigravity-skills)
