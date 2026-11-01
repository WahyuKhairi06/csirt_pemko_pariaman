# Laporan Akhir Implementasi Website CSIRT Kota Pariaman

**Tanggal Laporan:** 26 Oktober 2026  
**Status Pekerjaan:** Selesai (Tahap 1 hingga Tahap 8 Berhasil Diselesaikan dan Diverifikasi)  
**Lingkungan Target:** Laravel 13, PHP 8.3, Filament 5, Tailwind CSS v4, SQLite / MySQL  

---

## 1. Ringkasan Pekerjaan

### 1.1 Tujuan Proyek
Membangun ulang portal publik dan sistem manajemen konten (CMS) resmi Computer Security Incident Response Team (CSIRT) Pemerintah Kota Pariaman di bawah Dinas Komunikasi dan Informatika (Diskominfo). Portal ini dirancang untuk:
- Menyediakan saluran informasi kesiapsiagaan dan tanggap insiden siber yang mudah diakses, cepat, dan transparan bagi Organisasi Perangkat Daerah (OPD), aparatur sipil negara (ASN), dan masyarakat Kota Pariaman.
- Mempublikasikan dokumen kepatuhan standar RFC-2350, direktori agen siber OPD, peringatan kerentanan (advisori keamanan), panduan edukasi keamanan informasi, serta agenda kegiatan keamanan siber.
- Menyediakan pengarah saluran pelaporan kedaruratan siber (email, telepon, hotline, WhatsApp) tanpa memproses data sensitif laporan langsung di server publik demi menjaga keamanan dan privasi.
- Mengelola seluruh konten dan navigasi melalui antarmuka panel administrasi mandiri (Filament Admin Panel) dengan pembagian hak akses bertingkat (Role-Based Access Control).

### 1.2 Cakupan Pekerjaan
- **Audit Situs Rujukan:** Analisis tata letak, hirarki informasi, dan pola interaksi situs rujukan CSIRT Provinsi Sumatera Barat (`csirt.sumbarprov.go.id`) tanpa menyalin kode sumber atau aset hak cipta.
- **Kerangka Tampilan Publik (Frontend):** Pembuatan tata letak semantik, navigasi desktop dengan dropdown keyboard-accessible, menu drawer ponsel, hero banner, kartu layanan, dan footer berstandar aksesibilitas WCAG 2.2 AA.
- **Halaman Informasi Publik:** Pembangunan halaman Beranda, Profil, Katalog Layanan, Dokumen & RFC-2350, Agenda Kegiatan, Direktori Agen Siber OPD, Advisori Keamanan, Kabar Berita, Edukasi Siber, Saluran Pelaporan, Kontak, serta rute standar RFC 9116 (`/.well-known/security.txt`).
- **Panel Admin CMS & RBAC:** Implementasi panel admin Filament di rute `/panel-csirt` dengan 11 resource terkelola, halaman pengaturan situs ber-tab, dan otorisasi server-side berbasis Spatie Laravel Permission.
- **Keamanan & Kualitas Konten:** Pembersihan HTML kaya dari risiko XSS, aturan validasi URL kustom (`SafeUrl`) penolak skema berbahaya (`javascript:`, `data:`), penanganan placeholder `[ISI: ...]` agar tidak menjadi tautan aktif, serta isolasi rute tulis publik.
- **Pengujian & Verifikasi Akhir:** Pelaksanaan pengujian otomatis (69 pengujian unit & fitur Pest), audit gaya kode (Laravel Pint), build aset produksi (Vite), serta pengujian interaksi visual desktop dan ponsel.

### 1.3 Status Implementasi
Seluruh tahapan telah diuji dan berfungsi penuh. Tidak ada kode produksi yang terhubung ke layanan luar tanpa izin, tidak ada formulir publik yang membuka celah injeksi, dan tidak ada kredensial atau data pribadi yang tersimpan di dalam repositori.

---

## 2. Halaman dan Fitur

### 2.1 Fitur yang Selesai Diimplementasikan
- **Beranda (Home):**
  - Banner darurat peringatan siber (dapat diaktifkan/dinonaktifkan melalui admin).
  - Hero banner dengan judul, subjudul, dan dua tombol aksi utama (Lapor Insiden dan Pelajari Layanan).
  - Ringkasan advisori keamanan siber terkini dengan label tingkat risiko (*Tinggi*, *Sedang*, *Rendah*, *Kritis*).
  - Konstruksi blok konten modular (Rich Text, Langkah Alur Penanganan, Kartu Layanan, Tautan Portal Terpadu).
  - Banner sanggahan prototipe untuk mencegah kesalahpahaman sebelum peluncuran resmi.
- **Profil CSIRT:**
  - Latar belakang pembentukan, visi, misi, fungsi tanggap insiden, serta dasar hukum organisasi.
- **Katalog Layanan Keamanan Siber:**
  - Klasifikasi 3 kelompok layanan resmi: Layanan Utama (Respons Insiden), Layanan Proaktif (Pencegahan & Audit), dan Layanan Peningkatan Kualitas Keamanan (Bimtek & Edukasi).
  - Penjelasan sasaran pengguna dan estimasi target penanganan (SLA).
- **Dokumen Resmi & RFC-2350:**
  - Publikasi dokumen profil penanganan insiden standar RFC-2350.
  - Pengelompokan dokumen berdasarkan kategori (Kebijakan, Panduan Teknis, Formulir, SOP) dengan informasi format dan ukuran berkas.
- **Advisori Keamanan Siber:**
  - Indeks peringatan dini kerentanan sistem dengan filter tingkat risiko.
  - Halaman detail advisori yang mencakup nomor advisori, sistem terdampak, referensi CVE, deskripsi teknis, dan langkah mitigasi/rekomendasi.
- **Kabar Berita & Edukasi Kesadaran Keamanan:**
  - Artikel terbitan berkategori Berita dan Edukasi publik.
  - Fitur ringkasan, gambar sampul berteks alternatif, dan pembersih format teks kaya.
- **Direktori Agen Siber OPD:**
  - Daftar kontak agen penanggung jawab keamanan siber di masing-masing dinas/badan/kecamatan.
  - Fitur penyaringan interaktif berdasarkan nama OPD.
- **Agenda & Kegiatan Siber:**
  - Jadwal kegiatan bimtek, simulasi penanganan insiden, dan sosialisasi keamanan informasi.
- **Saluran Pelaporan Insiden & Kontak:**
  - Panduan tata cara penyampaian laporan insiden dan daftar periksa dokumen pendukung.
  - Kartu saluran resmi (Email, Hotline Darurat 24/7, Telepon Kantor, WhatsApp).
  - Informasi jam operasional dan kontak darurat.
- **Standar RFC 9116 (`/.well-known/security.txt`):**
  - Berkas teks publik standar bagi peneliti keamanan siber yang otomatis aktif saat email keamanan valid diisi di pengaturan admin.
- **Panel Admin CMS (`/panel-csirt`):**
  - Kelola Halaman, Berita & Edukasi, Kategori, Agenda, Advisori Keamanan, Dokumen, Katalog Layanan, Agen Siber, Portal Layanan, Menu Navigasi, Pengguna & Peran, serta Pengaturan Situs.

### 2.2 Perubahan dari Rencana Awal
- **Peniadaan Formulir Laporan Publik Langsung di Website:**
  Sesuai audit kebutuhan keamanan dan privasi (PRD v0.2), situs publik tidak menerima pengunggahan data insiden atau data pribadi pelapor melalui form web guna mencegah risiko kebocoran data dan celah serangan siber. Tombol laporan diarahkan sebagai pengarah (*routing CTA*) ke saluran resmi terverifikasi (email terenkripsi, hotline, atau helpdesk eksternal resmi).
- **Penyesuaian Jalur Admin:**
  Jalur bawaan `/admin` dialihkan secara otomatis ke `/panel-csirt` guna mencegah benturan rute dan memperjelas identitas panel resmi instansi.

---

## 3. Panduan Penggunaan Website

### 3.1 Alur Pengunjung Publik (Masyarakat, ASN, dan OPD)
Pengunjung publik adalah tamu (*guest*) yang dapat membaca seluruh informasi tanpa memerlukan akun atau login:
1. **Membaca Beranda & Informasi Utama:**
   - Akses alamat situs untuk melihat pengumuman darurat, layanan prioritas, dan peringatan keamanan terbaru.
2. **Melaporkan Insiden Siber:**
   - Klik tombol **Lapor Insiden** pada header atau banner beranda.
   - Pengunjung akan diarahkan ke halaman **Saluran Pelaporan** yang memuat nomor darurat, email resmi, dan daftar periksa bukti insiden yang harus disiapkan.
3. **Mencari Advisori & Panduan:**
   - Buka menu **Informasi > Advisori Keamanan** untuk melihat panduan perbaikan kerentanan sistem.
   - Gunakan filter tingkat risiko untuk memilah peringatan yang paling mendesak.
4. **Mengunduh Dokumen RFC-2350:**
   - Buka menu **Dokumen** untuk menemukan berkas profil RFC-2350 dan pedoman teknis yang disediakan.
5. **Menemukan Agen Siber Instansi:**
   - Buka menu **Agen Siber** dan gunakan kotak pilihan instansi/OPD untuk mencari narahubung teknis di unit kerja masing-masing.

### 3.2 Panduan Pengelola (Admin CMS)
Akses panel admin dibatasi secara ketat bagi staf yang ditugaskan.

#### Langkah 1: Masuk ke Panel Administrasi
1. Buka peramban dan navigasikan ke alamat `/panel-csirt`.
2. Halaman akan menampilkan formulir masuk bertajuk *CSIRT Kota Pariaman - Masuk ke akun Anda*.
3. Masukkan alamat email resmi staf yang telah didaftarkan dan kata sandi yang sah.
4. Klik tombol **Masuk**. Setelah verifikasi berhasil, Anda akan diarahkan ke Dashboard CMS.

#### Langkah 2: Mengelola Berita dan Edukasi
1. Pada bilah navigasi kiri, klik grup **Konten > Berita & Edukasi**.
2. Untuk membuat artikel baru, klik tombol **Buat Berita & Edukasi**.
3. Pilih tipe artikel (*Berita* atau *Edukasi*), isi judul, ringkasan singkat, dan tulis isi artikel menggunakan editor teks.
4. Tentukan status publikasi:
   - Pilih **Draf** jika tulisan masih dalam proses penyusunan dan belum ingin ditampilkan ke publik.
   - Pilih **Terbit** dan atur waktu publikasi agar artikel langsung tampil di halaman depan.
5. Unggah gambar sampul (format JPG/PNG/WebP) dan lengkapi deskripsi alternatif (*alt text*) untuk aksesibilitas.
6. Klik **Simpan Perubahan**.

#### Langkah 3: Menerbitkan Advisori Keamanan Baru
1. Pada bilah navigasi kiri, klik grup **Operasional Keamanan > Advisori Keamanan**.
2. Klik tombol **Buat Advisori Keamanan**.
3. Isi nomor referensi advisori (misal: *ADV-2026-001*), judul ancaman, dan pilih tingkat keparahan (*Kritis*, *Tinggi*, *Sedang*, *Rendah*).
4. Masukkan nama sistem atau perangkat lunak yang terdampak, nomor referensi CVE jika ada, rincian ancaman, serta rekomendasi teknis penanganan.
5. Ubah status menjadi **Terbit** dan klik **Simpan Perubahan**.

#### Langkah 4: Memperbarui Pengaturan Situs & Kontak
1. Pada bilah navigasi kiri, klik grup **Navigasi & Sistem > Pengaturan Situs**.
2. Halaman menampilkan form terbagi dalam tab:
   - **Identitas:** Nama situs, slogan, judul hero, dan teks hak cipta footer.
   - **Kontak & Jam Kerja:** Alamat kantor fisik, nomor telepon kantor, telepon darurat, dan email keamanan.
   - **Keamanan & PGP:** Fingerprint kunci PGP resmi dan URL kebijakan kerentanan untuk rute `security.txt`.
   - **Saluran Pelaporan (CTA):** Mengatur perilaku tombol "Lapor Insiden" (ke halaman internal, WhatsApp, atau helpdesk eksternal) serta daftar kartu kanal yang aktif.
   - **Banner Darurat:** Sakelar untuk menampilkan pita pengumuman merah/kuning di atas situs saat insiden genting terjadi.
3. Klik tombol **Simpan Pengaturan**. Perubahan akan langsung diperbarui ke antarmuka publik dan cache sistem akan disegarkan otomatis.

#### Langkah 5: Mengatur Menu Navigasi
1. Pada bilah navigasi kiri, klik **Navigasi & Sistem > Menu Navigasi**.
2. Pilih lokasi menu (*Header Navigasi Atas* atau *Footer Bawah*).
3. Anda dapat menghubungkan menu ke halaman CMS yang sudah ada atau memasukkan tautan khusus yang aman.
4. Submenu dibatasi maksimal 1 tingkat untuk menjamin kemudahan akses di perangkat ponsel.

#### Langkah 6: Manajemen Pengguna & Peran (Khusus Superadmin)
1. Pada menu **Pengguna & Peran**, superadmin dapat membuat akun staf baru dan menugaskan peran yang sesuai (*koordinator*, *analis*, atau *editor*).
2. Sistem secara otomatis mencegah penghapusan akun diri sendiri yang sedang aktif untuk menjaga kontinuitas akses.

---

## 4. Berkas Utama Proyek

Berikut adalah berkas-berkas penting yang dibuat atau disesuaikan selama implementasi:

- `app/Providers/Filament/AdminPanelProvider.php`: Konfigurasi resmi panel admin Filament, jalur `/panel-csirt`, palet warna instansi, dan pengelompokan navigasi.
- `app/Models/User.php`: Model pengguna dengan antarmuka `FilamentUser` dan trait Spatie `HasRoles` yang mengontrol izin masuk panel via `canAccessPanel()`.
- `app/Rules/SafeUrl.php`: Aturan validasi kustom penangkal skema berbahaya (`javascript:`, `data:`, `vbscript:`, `//`) pada seluruh input tautan di panel admin.
- `app/Support/Html.php`: Utilitas sanitasi teks kaya yang menyaring tag jahat dan skrip berbahaya sebelum konten disajikan ke publik.
- `app/Support/Settings.php`: Pengelola terpusat pengaturan situs, penanganan placeholder `[ISI: ...]`, serta pembentukan tautan aman untuk telepon dan email.
- `app/Filament/Pages/ManageSettings.php`: Halaman antarmuka admin ber-tab untuk mengelola identitas, kontak resmi, PGP, saluran pelaporan, dan banner darurat.
- `app/Filament/Resources/`: Kumpulan 11 resource admin (Pages, Posts, Categories, Advisories, Documents, Services, Agents, Events, PortalLinks, MenuItems, Users).
- `app/Policies/`: Kumpulan 12 Model Policy yang mengontrol otorisasi server-side untuk setiap tindakan baca, buat, ubah, dan hapus data.
- `database/seeders/RoleSeeder.php` & `database/seeders/UserSeeder.php`: Seeder idempoten untuk menyiapkan peran Spatie dan akun dasar awal tanpa risiko data ganda.
- `database/seeders/SiteSeeder.php`: Pembangkit struktur awal beranda, profil, katalog layanan, dokumen RFC-2350, agenda, berita, dan kontak placeholder.
- `resources/views/layouts/app.blade.php`: Kerangka utama publik yang ramah aksesibilitas, dilengkapi skip-link, header navigasi, banner darurat, dan footer.
- `resources/js/nav.js`: Skrip navigasi independen tanpa dependensi luar yang menangani dropdown keyboard (Escape, Tab) dan menu ponsel secara aksesibel.
- `resources/css/tokens.css` & `resources/css/app.css`: Sistem token desain warna, tipografi, fokus terlihat, dan dukungan `prefers-reduced-motion`.

---

## 5. Peran dan Batas Akses (RBAC)

Otorisasi sistem menerapkan prinsip *Least Privilege* yang dipaksakan di sisi server:

| Peran / Status | Wilayah Akses | Hak dan Batas Kewenangan |
| :--- | :--- | :--- |
| **Pengunjung Publik (Guest)** | Seluruh Situs Publik | Akses baca saja tanpa login. Tidak memiliki akun di sistem dan tidak memiliki peran Spatie. |
| **superadmin** | Panel Admin (`/panel-csirt`) | Hak akses penuh terhadap seluruh konten, dokumen, peringatan advisori, pengaturan situs, dan pengelolaan akun staf. |
| **koordinator** | Panel Admin (`/panel-csirt`) | Mengelola seluruh konten publik, advisori, layanan, menu navigasi, dan pengaturan situs. Tidak memiliki hak mengelola pengguna/akun. |
| **analis** | Panel Admin (`/panel-csirt`) | Khusus mengelola operasional keamanan siber: Advisori Keamanan, Dokumen Resmi, dan Katalog Layanan. |
| **editor** | Panel Admin (`/panel-csirt`) | Khusus mengelola komunikasi publik: Halaman, Berita, Edukasi, Kategori, dan Agenda Kegiatan. |
| **user (standar)** | Tidak Ada Akses Admin | Peran dasar pengguna terautentikasi tanpa hak admin. Akses ke `/panel-csirt` ditolak dengan galat `403 Forbidden`. |

---

## 6. Hasil Pemeriksaan dan Pengujian

Seluruh pengujian dijalankan langsung pada sistem dengan hasil sebagai berikut:

### 6.1 Pengujian Otomatis (Pest Test Suite)
- **Perintah:** `php artisan test --compact`
- **Hasil:** Berhasil (Passed). Sebanyak 69 pengujian dengan 368 asersi berhasil 100% tanpa kegagalan.
- **Rincian:**
  - `SafeUrlTest`: 18 pengujian unit lulus (skema berbahaya ditolak, jalur internal diterima).
  - `AdminPanelAuthorizationTest`: 11 pengujian fitur lulus (akses superadmin diterima, peran user ditolak 403, form login Livewire tervalidasi).
  - `SecurityAndQualityAuditTest`: 9 pengujian fitur lulus (rute publik bebas login, nol endpoint tulis publik, alt text lengkap, sanitasi HTML).
  - `PublicPagesTest`: 10 pengujian fitur lulus (katalog layanan, dokumen, agenda, filter OPD agen siber, filter keparahan advisori).
  - `PublicLayoutTest`: 7 pengujian fitur lulus (single h1, landmark semantik, skip link, navigasi ARIA, banner darurat).
  - `PublicSiteTest`: 13 pengujian fitur lulus (security headers, security.txt RFC 9116, tree menu 1 level).
  - `ExampleTest`: 1 pengujian unit lulus.

### 6.2 Pemeriksaan Format Kode (Laravel Pint)
- **Perintah:** `vendor/bin/pint --format agent`
- **Hasil:** Berhasil (Passed). Seluruh berkas PHP memenuhi standar konvensi PSR-12 dan aturan proyek tanpa pelanggaran.

### 6.3 Kompilasi Aset Frontend (Vite)
- **Perintah:** `npm run build`
- **Hasil:** Berhasil (Passed) dalam 936ms. Berkas bundel CSS (77.61 kB) dan JS (1.38 kB) berhasil dibuat di `public/build/` dengan manifest yang valid.

### 6.4 Keterbatasan & Hal yang Belum Dijalankan
- Tidak ada pengujian unit otomatis yang gagal.
- Uji coba pengiriman email keluar nyata (`SMTP`) belum dilakukan karena server produksi belum dikonfigurasi (saat ini menggunakan driver log/lokal yang aman).

---

## 7. Pemeriksaan Visual dan Responsif

Pemeriksaan tampilan dilakukan menggunakan peramban internal dan dibandingkan terhadap prinsip tata letak situs rujukan CSIRT Provinsi Sumatera Barat (`csirt.sumbarprov.go.id`):

| Aspek yang Diperiksa | Kondisi Desktop (1280px) | Kondisi Ponsel (375px & 320px) | Hasil Evaluasi |
| :--- | :--- | :--- | :--- |
| **Header & Navigasi** | Bar navigasi horizontal penuh, menu dropdown dapat dioperasikan mouse & keyboard. | Menu disembunyikan dalam tombol hamburger; panel drawer terbuka penuh saat diklik. | Sangat baik, navigasi adaptif dan accessible. |
| **Hero Banner** | Dua kolom berimbang antara teks judul, subjudul, 2 tombol aksi, dan grafis perisai. | Tersusun vertikal rapi, ukuran font judul menyesuaikan ukuran layar tanpa terpotong. | Proporsional, tidak ada teks bertumpuk. |
| **Kartu Advisori & Layanan** | Grid multi-kolom (2 atau 3 kolom) dengan bayangan kartu halus dan badge status kontras. | Bertransformasi menjadi 1 kolom vertikal yang mudah digulir jari. | Bersih dan nyaman dibaca. |
| **Pergeseran Horizontal** | Lebar halaman terkunci di dalam batas layar 1280px. | Lebar dokumen sama dengan lebar jendela (*zero horizontal scrollbar* pada 375px dan 320px). | Lulus uji bebas scroll horizontal. |
| **Keterbatasan Rujukan** | Bagian yang pada situs rujukan sedang loading atau tidak stabil telah dibangun ulang secara lokal dengan data CMS mandiri. | Tidak menyalin kode atau elemen flash eksternal dari rujukan. | Desain lokal lebih stabil dan mandiri. |

---

## 8. Placeholder dan Keputusan yang Diperlukan Pemilik

Sesuai instruksi proyek, seluruh data resmi yang belum dapat dikonfirmasi tetap disimpan dalam bentuk placeholder `[ISI: ...]`. Nilai ini ditampilkan sebagai penanda di mode pengembangan, namun **dinonaktifkan dari tautan aktif** agar tidak menyesatkan publik.

Berikut daftar materi yang menunggu konfirmasi dan keputusan resmi dari pemilik proyek (Diskominfo Kota Pariaman):
1. **Identitas Organisasi & SK Tim:**
   - Nomor dan tanggal Surat Keputusan (SK) Walikota tentang Pembentukan Tim CSIRT Kota Pariaman.
   - Bagan struktur organisasi resmi dan nama Ketua / Koordinator Tim Pelaksana.
2. **Kontak Operasional Resmi:**
   - Alamat kantor fisik sekretariat CSIRT (saat ini: `[ISI: alamat kantor]`).
   - Nomor telepon resmi dinas (saat ini: `[ISI: telepon]`).
   - Nomor hotline telepon darurat 24/7 (saat ini: `[ISI: nomor darurat]`).
   - Nomor WhatsApp resmi aduan insiden (saat ini: `[ISI: nomor WhatsApp]`).
   - Alamat email resmi pelaporan (misal: `csirt@pariamankota.go.id`).
3. **Kunci Kriptografi & Kebijakan RFC 9116:**
   - Berkas kunci publik PGP (*Public PGP Key*) dan sidik jari (*fingerprint*) resmi untuk rute `/.well-known/security.txt`.
   - Dokumen kebijakan pengungkapan kerentanan (*Vulnerability Disclosure Policy*).
4. **Dokumen Resmi Final:**
   - Naskah final dokumen RFC-2350 CSIRT Kota Pariaman yang telah ditandatangani pimpinan.
   - Panduan teknis kesiapsiagaan insiden untuk OPD dalam format PDF resmi.
5. **Aset Visual & Logo:**
   - Berkas logo resmi Pemerintah Kota Pariaman dan lambang CSIRT Kota Pariaman resolusi tinggi berlatar transparan (SVG/PNG) dengan hak penggunaan yang sah.
6. **Domain & Penerbitan:**
   - Persetujuan alokasi subdomain resmi `csirt.pariamankota.go.id` dan penyediaan sertifikat SSL (HTTPS).

---

## 9. Cara Menjalankan dan Meninjau Aplikasi

Seluruh perintah di bawah ini mengacu pada lingkungan pengembangan proyek yang ada:

### 9.1 Menjalankan Aplikasi di Lingkungan Lokal
1. Buka terminal PowerShell pada direktori proyek:
   ```bash
   cd c:\laragon\www\csirt-pariaman
   ```
2. Pastikan dependensi backend dan database telah siap:
   ```bash
   composer install
   php artisan migrate
   php artisan db:seed
   ```
3. Bangun aset frontend atau jalankan server pengembangan:
   ```bash
   npm run build
   ```
4. Jalankan server lokal Laravel:
   ```bash
   php artisan serve --host=127.0.0.1 --port=8000
   ```

### 9.2 Meninjau Halaman Publik
- Buka peramban web dan kunjungi: `http://127.0.0.1:8000`
- Jelajahi tautan publik:
  - Profil: `http://127.0.0.1:8000/profil`
  - Katalog Layanan: `http://127.0.0.1:8000/layanan`
  - Dokumen & RFC-2350: `http://127.0.0.1:8000/dokumen`
  - Advisori Keamanan: `http://127.0.0.1:8000/advisori`
  - Berita: `http://127.0.0.1:8000/berita`
  - Edukasi: `http://127.0.0.1:8000/edukasi`
  - Direktori Agen Siber: `http://127.0.0.1:8000/agen-siber`
  - Agenda: `http://127.0.0.1:8000/agenda`
  - Saluran Pelaporan: `http://127.0.0.1:8000/saluran-pelaporan`
  - Kontak: `http://127.0.0.1:8000/kontak`

### 9.3 Meninjau Panel Admin Filament
- Kunjungi tautan: `http://127.0.0.1:8000/panel-csirt`
- Gunakan akun staf resmi yang telah didaftarkan melalui seeder atau administrator server untuk masuk. *(Catatan: Pengunjung publik tidak memiliki akun di panel ini).*

---

## 10. Catatan Serah Terima dan Langkah Selanjutnya

### 10.1 Risiko Tersisa
- **Ketergantungan Data Nyata:** Situs saat ini berstatus prototipe mandiri dengan data placeholder yang aman. Sebelum banner sanggahan prototipe diturunkan, seluruh teks kontak dan dokumen harus sudah disetujui pimpinan instansi agar tidak menimbulkan konsekuensi administratif atau hukum.
- **Kerahasiaan Kredensial Produksi:** Saat aplikasi dideploy ke peladen produksi, pastikan variabel lingkungan `APP_KEY`, `DB_PASSWORD`, dan kata sandi akun superadmin diganti dengan kombinasi unik yang kuat melalui file `.env` produksi.

### 10.2 Langkah Berikutnya yang Disarankan
1. **Pemeriksaan Konten oleh Pemilik:** Tim Diskominfo meninjau susunan halaman pada server uji coba untuk menyepakati naskah teks, visi misi, dan katalog layanan.
2. **Pengisian Data Kontak Resmi:** Administrator masuk ke `/panel-csirt` untuk mengisi alamat, telepon hotline, WhatsApp, dan mengunggah dokumen RFC-2350 final.
3. **Penyediaan Logo & Sertifikat SSL:** Menyematkan logo resmi Kota Pariaman dan mengonfigurasi protokol HTTPS (SSL/TLS) di peladen resmi.
4. **Penetapan Pengelola CMS:** Mendaftarkan akun masing-masing petugas OPD atau staf Diskominfo sesuai peran operasionalnya (*koordinator*, *analis*, atau *editor*).
5. **Peluncuran Resmi:** Menghubungkan domain `csirt.pariamankota.go.id` dan menurunkan banner sanggahan prototipe setelah persetujuan tertulis dari pemilik proyek diterbitkan.
