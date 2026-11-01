# BUKU PANDUAN SISTEM DAN PENGGUNAAN WEBSITE
## Portal Resmi & Sistem Manajemen Konten (CMS) CSIRT Pemerintah Kota Pariaman

---

> **INSTRUKSI FORMAT UNTUK CLAUDE AI (GENERATOR PDF):**
> Dokumen Markdown ini disusun secara terstruktur sebagai naskah **Buku Panduan Resmi (User & System Manual)** untuk dikonversi menjadi dokumen **PDF profesional**. Saat membuat PDF dari dokumen ini:
> 1. **Gaya Visual:** Gunakan tata letak dokumen resmi instansi pemerintah yang bersih dan modern (warna aksen Biru Tua/Navy `#0B2447`, Biru Instansi `#19376D`, teks Abu Gelap `#1E293B`).
> 2. **Tipografi:** Gunakan font sans-serif formal seperti *Inter*, *Plus Jakarta Sans*, atau *Arial/Helvetica* untuk teks utama, dan *JetBrains Mono* / *Consolas* untuk blok kode/URL.
> 3. **Halaman Sampul (Cover Page):** Buat halaman sampul penuh dari bagian "Informasi Dokumen" di bawah sebelum masuk ke Daftar Isi.
> 4. **Pemisah Halaman (Page Break):** Setiap judul bab utama (`## BAB ...`) harus dimulai pada halaman baru (*page break*).
> 5. **Tabel & Kotak Catatan:** Format seluruh tabel dengan header berwarna biru tua dan baris selang-seling (*zebra striping*). Format blok kutipan (`>`) sebagai kotak informasi (*callout box*) berbingkai kiri tebal.
> 6. **Header & Footer PDF:** Tambahkan header berisi *"Buku Panduan Sistem Website CSIRT Kota Pariaman"* dan footer berisi nomor halaman (*Halaman X dari Y*).

---

## INFORMASI DOKUMEN (HALAMAN SAMPUL)

| Atribut Dokumen | Keterangan |
| :--- | :--- |
| **Judul Dokumen** | Buku Panduan Sistem, Administrasi CMS, dan Tata Cara Penggunaan Website CSIRT Pemerintah Kota Pariaman |
| **Instansi Pemilik** | Dinas Komunikasi dan Informatika (Diskominfo) Pemerintah Kota Pariaman |
| **Unit Pelaksana** | Tim Tanggap Insiden Siber / *Computer Security Incident Response Team* (CSIRT) Kota Pariaman |
| **Versi Dokumen** | 1.0 (Edisi Lengkap Sistem & Operasional) |
| **Tanggal Terbit** | Oktober 2026 |
| **Platform Teknologi** | Laravel 13, PHP 8.3, Filament Admin Panel v5, Tailwind CSS v4, MySQL/SQLite |
| **Zona Waktu Sistem** | Waktu Indonesia Barat (`Asia/Jakarta` / WIB) |
| **Klasifikasi Dokumen** | Panduan Operasional Internal & Publik |

---

## DAFTAR ISI

1. **BAB 1: Pendahuluan dan Arsitektur Sistem**
   - 1.1 Latar Belakang dan Tujuan Sistem
   - 1.2 Prinsip Desain dan Arsitektur Keamanan
   - 1.3 Standar Internasional yang Diterapkan (RFC 2350 & RFC 9116)
   - 1.4 Spesifikasi Teknis dan Struktur Rute Sistem
2. **BAB 2: Pembagian Peran dan Hak Akses (RBAC)**
   - 2.1 Konsep Otorisasi *Least Privilege*
   - 2.2 Penjelasan Fungsi Setiap Peran (*Role*)
   - 2.3 Matriks Hak Akses Modul (Lengkap)
   - 2.4 Aturan Keamanan Akun dan Sesi
3. **BAB 3: Panduan Penggunaan Situs Publik**
   - 3.1 Tata Letak Umum dan Fitur Aksesibilitas
   - 3.2 Halaman Beranda (*Home*) dan Banner Darurat
   - 3.3 Halaman Profil CSIRT
   - 3.4 Halaman Katalog Layanan Keamanan Siber
   - 3.5 Halaman Dokumen Resmi dan RFC-2350
   - 3.6 Halaman Advisori Keamanan Siber
   - 3.7 Halaman Berita dan Edukasi Keamanan Informasi
   - 3.8 Halaman Direktori Agen Siber OPD
   - 3.9 Halaman Agenda Kegiatan Siber
   - 3.10 Halaman Saluran Pelaporan Insiden dan Kontak
   - 3.11 Endpoint Standar `/.well-known/security.txt`
4. **BAB 4: Panduan Dasar Panel Admin CMS (`/panel-csirt`)**
   - 4.1 Cara Masuk (*Login*) dan Keluar (*Logout*)
   - 4.2 Struktur Navigasi Panel Administrasi
   - 4.3 Siklus Hidup Konten: Draf, Terbit, dan Terjadwal
   - 4.4 Fitur Pratinjau Staf (*Staff Preview*)
5. **BAB 5: Panduan Modul Konten dan Publikasi**
   - 5.1 Modul Halaman (*Pages*) dan Penyusun Blok (*Page Builder*)
   - 5.2 Referensi Lengkap 13 Blok *Page Builder*
   - 5.3 Modul Berita dan Edukasi (*Posts*)
   - 5.4 Modul Kategori Artikel (*Categories*)
   - 5.5 Modul Agenda Kegiatan (*Events*)
6. **BAB 6: Panduan Modul Operasional Keamanan Siber**
   - 6.1 Modul Advisori Keamanan (*Advisories*)
   - 6.2 Modul Dokumen Resmi & RFC-2350 (*Documents*)
   - 6.3 Modul Katalog Layanan (*Services*)
7. **BAB 7: Panduan Modul Direktori, Navigasi, dan Pengaturan Situs**
   - 7.1 Modul Direktori Agen Siber OPD (*Agents*)
   - 7.2 Modul Tautan Portal Layanan (*Portal Links*)
   - 7.3 Modul Menu Navigasi (*Menu Items*)
   - 7.4 Halaman Pengaturan Situs & Kanal Pelaporan (*Manage Settings*)
   - 7.5 Mekanisme Pengaman Placeholder `[ISI: ...]`
8. **BAB 8: Panduan Manajemen Pengguna dan Peran (Khusus Superadmin)**
   - 8.1 Melihat Daftar Pengguna
   - 8.2 Menambah Akun Staf Baru
   - 8.3 Mengubah Peran (*Role*) dan Mereset Kata Sandi
   - 8.4 Menghapus Akun dan Proteksi Akun Sendiri
9. **BAB 9: Pemeliharaan Teknis, Optimasi, dan Daftar Periksa Produksi**
   - 9.1 Sistem Keamanan Berlapis yang Diterapkan
   - 9.2 Perintah Terminal (Artisan CLI) untuk Pemeliharaan
   - 9.3 Daftar Periksa Sebelum Peluncuran Resmi (*Go-Live Checklist*)
10. **BAB 10: Pertanyaan Umum (FAQ) dan Pemecahan Masalah (*Troubleshooting*)**

---

## BAB 1: PENDAHULUAN DAN ARSITEKTUR SISTEM

### 1.1 Latar Belakang dan Tujuan Sistem
Website **CSIRT Pemerintah Kota Pariaman** adalah portal informasi publik dan sistem manajemen konten (*Content Management System* / CMS) resmi milik Tim Tanggap Insiden Siber di bawah naungan **Dinas Komunikasi dan Informatika (Diskominfo) Kota Pariaman**.

Sistem ini dibangun dengan tujuan utama:
1. **Pusat Informasi Tanggap Insiden:** Menyediakan rujukan resmi bagi Organisasi Perangkat Daerah (OPD), Aparatur Sipil Negara (ASN), dan masyarakat umum ketika menghadapi insiden keamanan siber.
2. **Publikasi Peringatan Dini (*Early Warning*):** Menyebarkan advisori kerentanan sistem, panduan mitigasi teknis, serta materi edukasi kesadaran keamanan siber (*cybersecurity awareness*).
3. **Transparansi Standar Operasional:** Mempublikasikan dokumen resmi tim sesuai standar internasional **RFC-2350**, katalog layanan beserta target waktu tanggap (*Service Level Agreement* / SLA), serta direktori narahubung Agen Siber di setiap OPD.
4. **Kemandirian Pengelolaan Konten:** Memungkinkan tim internal Diskominfo dan CSIRT mengelola seluruh halaman, menu, berita, advisori, hingga kontak darurat melalui antarmuka web tanpa perlu mengubah kode program.

### 1.2 Prinsip Desain dan Arsitektur Keamanan
Berbeda dengan situs web umum, portal CSIRT merupakan target bernilai tinggi bagi pelaku ancaman siber. Oleh karena itu, website ini dirancang dengan prinsip **"Zero Public Write Endpoint"** (Nol Titik Masuk Tulis Publik):
- **Situs Publik Murni Baca (*Read-Only*):** Seluruh rute publik hanya melayani permintaan pembacaan informasi (`HTTP GET`). Tidak ada formulir komentar publik, tidak ada registrasi pengguna publik, dan tidak ada formulir unggah bukti insiden di halaman publik.
- **Pengarah Saluran Pelaporan (*Routing CTA*):** Pelaporan insiden siber mengandung informasi sensitif (log sistem, celah keamanan, atau data instansi). Situs ini berfungsi mengarahkan pelapor ke saluran komunikasi resmi yang aman (Email terenkripsi PGP, Hotline 24/7, WhatsApp resmi, atau portal *helpdesk* terpisah) beserta daftar periksa informasi yang harus disiapkan.
- **Isolasi Panel Administrasi:** Seluruh proses penulisan dan pembaruan data diisolasi di dalam jalur khusus `/panel-csirt` yang dilindungi autentikasi sesi, token anti-CSRF, dan otorisasi berbasis peran (*Role-Based Access Control*).

### 1.3 Standar Internasional yang Diterapkan (RFC 2350 & RFC 9116)
Website ini mematuhi dua standar utama *Internet Engineering Task Force* (IETF) untuk tim tanggap insiden siber:
1. **RFC 2350 (*Expectations for Computer Security Incident Response*):** Standar dokumen profil resmi CSIRT yang menjelaskan mandat, struktur kewenangan, informasi kontak, kunci kriptografi PGP, serta jenis layanan tim. Sistem menyediakan kategori khusus `RFC-2350` pada modul Dokumen dan blok halaman khusus untuk menampilkannya.
2. **RFC 9116 (`/.well-known/security.txt`):** Standar file teks mesin-terbaca yang memudahkan peneliti keamanan siber (*ethical hacker* / *bug reporter*) menemukan kontak pelaporan kerentanan resmi, kunci PGP, tanggal kedaluwarsa informasi keamanan, dan URL halaman kebijakan pengungkapan kerentanan.

### 1.4 Spesifikasi Teknis dan Struktur Rute Sistem
| Komponen | Spesifikasi |
| :--- | :--- |
| **Kerangka Kerja Backend** | Laravel 13.x (PHP 8.3+) |
| **Panel Administrasi (CMS)** | Filament v5.x (Berbasis Livewire) |
| **Manajemen Hak Akses** | Spatie Laravel Permission (`roles` & `model_has_roles`) |
| **Antarmuka & Gaya Visual** | Blade Template Engine + Tailwind CSS v4 + Vanilla JS (`nav.js`) |
| **Penyimpanan Basis Data** | MySQL / MariaDB (Mendukung SQLite untuk pengujian) |
| **Zona Waktu Aplikasi** | `Asia/Jakarta` (WIB / UTC+7) |

**Peta Rute URL Utama:**

| Jalur URL (*Route*) | Fungsi Halaman | Akses |
| :--- | :--- | :--- |
| `/` | Halaman Beranda Utama | Publik (`GET`) |
| `/profil` | Halaman Profil, Visi Misi & Dasar Hukum CSIRT | Publik (`GET`) |
| `/layanan` | Katalog Layanan Keamanan Siber (Reaktif, Proaktif, Kualitas) | Publik (`GET`) |
| `/dokumen` | Daftar Dokumen Resmi & Dokumen RFC-2350 | Publik (`GET`) |
| `/advisori` | Indeks Peringatan & Advisori Keamanan (dengan filter tingkat risiko) | Publik (`GET`) |
| `/advisori/{slug}` | Halaman Detail Advisori, Sistem Terdampak & Mitigasi | Publik (`GET`) |
| `/berita` dan `/berita/{slug}` | Indeks dan Detail Artikel Berita Kegiatan CSIRT | Publik (`GET`) |
| `/edukasi` dan `/edukasi/{slug}` | Indeks dan Detail Artikel Edukasi & Tips Keamanan Siber | Publik (`GET`) |
| `/agen-siber` | Direktori Agen Siber OPD (dengan filter per instansi/OPD) | Publik (`GET`) |
| `/agenda` | Jadwal Agenda, Bimtek, dan Sosialisasi Keamanan Siber | Publik (`GET`) |
| `/saluran-pelaporan` | Panduan & Kanal Resmi Pelaporan Insiden Siber | Publik (`GET`) |
| `/kontak` | Informasi Alamat Sekretariat, Jam Layanan & Kontak | Publik (`GET`) |
| `/{slug}` | Halaman Dinamis CMS Lainnya | Publik (`GET`) |
| `/.well-known/security.txt` | Dokumen Teks Standar RFC 9116 | Publik (`GET`) |
| `/pratinjau/halaman/{id}` | Pratinjau Draf Halaman (Khusus Staf Login) | Staf Terautentikasi |
| `/pratinjau/pos/{id}` | Pratinjau Draf Berita/Edukasi (Khusus Staf Login) | Staf Terautentikasi |
| `/pratinjau/advisori/{id}` | Pratinjau Draf Advisori (Khusus Staf Login) | Staf Terautentikasi |
| `/admin` | Pengalihan otomatis (*Redirect*) ke `/panel-csirt` | Sistem |
| `/panel-csirt` | Dashboard & Modul Panel Administrasi CMS | Staf sesuai *Role* |

---

## BAB 2: PEMBAGIAN PERAN DAN HAK AKSES (RBAC)

### 2.1 Konsep Otorisasi *Least Privilege*
Sistem menerapkan prinsip **Hak Akses Minimum (*Least Privilege*)** yang divalidasi langsung di sisi server melalui **12 Kelas *Model Policy* Laravel** dan metode `canAccessPanel()` pada model `User`. Menu yang tidak diizinkan bagi suatu peran akan **disembunyikan secara otomatis** dari bilah navigasi kiri, dan akses langsung melalui URL akan ditolak oleh server dengan status **`403 Forbidden`**.

### 2.2 Penjelasan Fungsi Setiap Peran (*Role*)

Sistem memiliki **5 peran terdaftar** di database ditambah status pengunjung tamu:

1. **Pengunjung Publik (*Guest* — Tanpa Login):**
   - Masyarakat umum, pegawai ASN, atau pihak luar yang mengakses website.
   - Hanya dapat melihat dan mengunduh informasi publik yang berstatus **Terbit (`published`)**. Tidak membutuhkan akun.
2. **`superadmin` (Administrator Utama Sistem):**
   - Pemegang kendali tertinggi atas seluruh sistem CMS.
   - Memiliki akses penuh ke seluruh 11 modul data, halaman Pengaturan Situs, serta **satu-satunya peran yang dapat membuka menu Pengguna & Peran** untuk menambah akun staf, mengganti kata sandi, atau mengatur role.
3. **`koordinator` (Ketua / Koordinator Pelaksana CSIRT):**
   - Pengelola penuh operasional dan konten portal.
   - Memiliki seluruh kewenangan `superadmin` (termasuk mengubah Pengaturan Situs, Banner Darurat, Menu Navigasi, Direktori Agen Siber, Advisori, Dokumen, dan Berita), **kecuali** manajemen akun pengguna (`Pengguna & Peran`).
4. **`analis` (Analis Teknis Keamanan Siber):**
   - Staf teknis yang bertugas menangani kerentanan, insiden, dan standarisasi teknis.
   - Hanya memiliki akses pada grup **Operasional Keamanan**, yaitu modul **Advisori Keamanan**, **Dokumen Resmi & RFC-2350**, serta **Katalog Layanan**.
5. **`editor` (Staf Humas & Publikasi Konten):**
   - Staf komunikasi publik yang bertugas menyusun informasi kegiatan, edukasi literasi keamanan, dan halaman informasi umum.
   - Hanya memiliki akses pada grup **Konten**, yaitu modul **Halaman**, **Berita & Edukasi**, **Kategori**, dan **Agenda Kegiatan**.
6. **`user` (Akun Terdaftar Non-Admin):**
   - Peran dasar cadangan tanpa hak akses ke panel admin.
   - Jika pengguna dengan peran `user` mencoba masuk ke `/panel-csirt`, sistem secara otomatis menolak akses dengan pesan **`403 Forbidden`**.

### 2.3 Matriks Hak Akses Modul (Lengkap)

Setiap tanda **✅ (Diizinkan)** mencakup hak untuk **Melihat Daftar (*ViewAny*)**, **Melihat Detail (*View*)**, **Membuat Baru (*Create*)**, **Mengubah (*Update*)**, dan **Menghapus (*Delete*)** pada modul tersebut.

| Grup Navigasi | Nama Modul / Fitur di Panel Admin | `superadmin` | `koordinator` | `analis` | `editor` | `user` |
| :--- | :--- | :---: | :---: | :---: | :---: | :---: |
| **Akses Panel** | Login ke `/panel-csirt` | ✅ | ✅ | ✅ | ✅ | ❌ (403) |
| **Akses Pratinjau** | Rute `/pratinjau/*` (Lihat Draf) | ✅ | ✅ | ✅ | ✅ | ❌ (404) |
| **Konten** | **Halaman** (`/panel-csirt/pages`) | ✅ | ✅ | ❌ | ✅ | ❌ |
| **Konten** | **Berita & Edukasi** (`/panel-csirt/posts`) | ✅ | ✅ | ❌ | ✅ | ❌ |
| **Konten** | **Kategori** (`/panel-csirt/categories`) | ✅ | ✅ | ❌ | ✅ | ❌ |
| **Konten** | **Agenda** (`/panel-csirt/events`) | ✅ | ✅ | ❌ | ✅ | ❌ |
| **Operasional Keamanan** | **Advisori Keamanan** (`/panel-csirt/advisories`) | ✅ | ✅ | ✅ | ❌ | ❌ |
| **Operasional Keamanan** | **Layanan** (`/panel-csirt/services`) | ✅ | ✅ | ✅ | ❌ | ❌ |
| **Operasional Keamanan** | **Dokumen** (`/panel-csirt/documents`) | ✅ | ✅ | ✅ | ❌ | ❌ |
| **Operasional Keamanan** | **Agen Siber** (`/panel-csirt/agents`) | ✅ | ✅ | ❌ | ❌ | ❌ |
| **Navigasi & Sistem** | **Menu Navigasi** (`/panel-csirt/menu-items`) | ✅ | ✅ | ❌ | ❌ | ❌ |
| **Navigasi & Sistem** | **Portal Layanan** (`/panel-csirt/portal-links`) | ✅ | ✅ | ❌ | ❌ | ❌ |
| **Navigasi & Sistem** | **Pengaturan Situs** (`/panel-csirt/manage-settings`) | ✅ | ✅ | ❌ | ❌ | ❌ |
| **Navigasi & Sistem** | **Pengguna & Peran** (`/panel-csirt/users`) | ✅ | ❌ | ❌ | ❌ | ❌ |

### 2.4 Aturan Keamanan Akun dan Sesi
- **Enkripsi Kata Sandi:** Seluruh kata sandi disimpan menggunakan algoritma *one-way hashing* **Bcrypt**. Tidak ada seorang pun (termasuk `superadmin` atau pemilik database) yang dapat melihat teks asli kata sandi yang sudah tersimpan; kata sandi hanya dapat diatur ulang (*reset*).
- **Proteksi Penghapusan Diri Sendiri:** Di dalam `UserPolicy`, seorang `superadmin` **dilarang menghapus akunnya sendiri** yang sedang digunakan login (`$user->id !== $model->id`). Hal ini mencegah hilangnya akses admin secara tidak sengaja.

---

## BAB 3: PANDUAN PENGGUNAAN SITUS PUBLIK

Bab ini menjelaskan fungsi setiap halaman yang dilihat oleh masyarakat, ASN, dan perwakilan OPD saat mengunjungi situs CSIRT Kota Pariaman.

### 3.1 Tata Letak Umum dan Fitur Aksesibilitas
Setiap halaman publik memiliki struktur standar yang konsisten:
1. **Tautan Lewati ke Konten Utama (*Skip Link*):** Muncul saat pengunjung menekan tombol `Tab` pertama kali di keyboard, memudahkan pengguna pembaca layar (*screen reader*) langsung melompat ke isi halaman.
2. **Pita Sanggahan Pengembangan (*Prototype Disclaimer*):** Ditampilkan di bagian paling atas selama aplikasi belum disetel ke mode produksi (`APP_ENV=production`).
3. **Banner Darurat Siber (*Emergency Banner*):** Pita pengumuman berwarna Biru (Informasi), Kuning (Peringatan), atau Merah (Bahaya/Kritis) yang muncul di bagian atas seluruh halaman jika diaktifkan oleh Koordinator/Superadmin saat terjadi insiden siber luas.
4. **Header & Navigasi Utama:**
   - Menampilkan identitas situs **CSIRT Kota Pariaman**.
   - Menu navigasi horizontal pada layar desktop (mendukung *dropdown* 1 tingkat yang dapat ditutup dengan tombol `Escape` atau klik di luar).
   - Tombol menu *Hamburger* (garis tiga) pada layar ponsel/tablet yang membuka laci navigasi (*mobile drawer*).
   - Tombol menonjol **"Lapor Insiden"** di sisi kanan atas yang mengarahkan pelapor ke halaman/kanal pelaporan resmi.
5. **Footer Situs:** Menampilkan ringkasan profil CSIRT, alamat sekretariat, jam pelayanan, kontak resmi, tautan cepat footer, dan hak cipta `© Diskominfo Kota Pariaman`.

### 3.2 Halaman Beranda (*Home* — `/`)
Halaman utama yang merangkum informasi terpenting situs:
- **Hero Banner:** Menampilkan slogan utama, deskripsi singkat peran CSIRT Kota Pariaman, tombol utama **Lapor Insiden**, dan tombol sekunder menuju halaman layanan/profil.
- **Peringatan & Advisori Terbaru:** Menampilkan kartu peringatan keamanan siber terkini lengkap dengan lencana (*badge*) tingkat keparahan.
- **Alur Penanganan Insiden:** Menampilkan tahapan terstruktur bagaimana laporan insiden diterima, dianalisis, ditangani, hingga dipulihkan.
- **Ringkasan Layanan & Tautan Portal:** Menampilkan kartu layanan utama serta tautan menuju sistem pemerintahan terkait.

### 3.3 Halaman Profil CSIRT (`/profil`)
Menyajikan informasi kelembagaan tim tanggap insiden siber Kota Pariaman, meliputi latar belakang pembentukan, visi dan misi, ruang lingkup konstituen (OPD di lingkungan Pemko Pariaman), serta dasar hukum/SK pembentukan tim.

### 3.4 Halaman Katalog Layanan Keamanan Siber (`/layanan`)
Menampilkan daftar seluruh layanan resmi CSIRT yang dikelompokkan ke dalam **3 kategori standar BSSN/FIRST**:
1. **Layanan Reaktif (*Reactive Services*):** Layanan tanggap darurat saat insiden terjadi, seperti peringatan dini (*alerts & warnings*), penanganan insiden siber (*incident handling*), dan koordinasi pemulihan.
2. **Layanan Proaktif (*Proactive Services*):** Layanan pencegahan sebelum insiden terjadi, seperti asesmen kerentanan (*vulnerability assessment*), audit konfigurasi keamanan aplikasi, dan pemindaian celah keamanan.
3. **Peningkatan Kualitas Keamanan (*Security Quality Management Services*):** Layanan edukasi, bimbingan teknis (Bimtek), analisis risiko, serta peningkatan kesadaran keamanan informasi bagi ASN.

Setiap kartu layanan menampilkan rincian: **Deskripsi Layanan**, **Sasaran Pemohon**, **Mekanisme Permohonan**, **Jam Layanan**, dan **Target Waktu Respons (SLA)**.

### 3.5 Halaman Dokumen Resmi dan RFC-2350 (`/dokumen`)
Menyediakan pusat unduhan berkas resmi yang dikelompokkan menurut kategori:
- **RFC-2350:** Dokumen spesifikasi dan profil resmi CSIRT Kota Pariaman.
- **Regulasi:** Peraturan Walikota, SK Tim, atau kebijakan keamanan informasi daerah.
- **SOP:** Standar Operasional Prosedur penanganan insiden.
- **Panduan:** Buku saku atau pedoman teknis pengamanan sistem bagi OPD.
- **Lainnya:** Formulir atau dokumen pendukung lainnya.

Setiap baris dokumen menampilkan judul, versi (misal `v1.0`), bahasa (`id`), tanggal berlaku, format berkas (`PDF`/`DOCX`), ukuran berkas otomatis (KB/MB), serta tombol **Unduh**.

### 3.6 Halaman Advisori Keamanan Siber (`/advisori` & `/advisori/{slug}`)
Berfungsi sebagai buletin peringatan kerentanan sistem (*security bulletin*):
- **Fitur Filter Tingkat Risiko:** Pengunjung dapat menyaring daftar advisori berdasarkan tingkat keparahan: **Semua**, **Kritis**, **Tinggi**, **Sedang**, atau **Rendah**.
- **Halaman Detail Advisori:** Ketika salah satu judul diklik, halaman menampilkan:
  - Lencana tingkat keparahan (menggunakan kombinasi warna, ikon, dan teks agar ramah bagi penderita buta warna).
  - Tanggal publikasi dan ringkasan ancaman.
  - **Sistem Terdampak:** Daftar perangkat lunak, sistem operasi, atau versi aplikasi yang rentan.
  - **Langkah Mitigasi & Rekomendasi:** Instruksi teknis terperinci untuk menambal (*patching*) atau mengamankan sistem.

### 3.7 Halaman Berita (`/berita`) dan Edukasi (`/edukasi`)
Meskipun dikelola dari satu modul yang sama di panel admin, keduanya dipisahkan di halaman publik agar pengunjung mudah memilah informasi:
- **Berita (`/berita`):** Memuat liputan kegiatan resmi CSIRT, rapat koordinasi, simulasi insiden (*tabletop exercise*), dan rilis pers.
- **Edukasi (`/edukasi`):** Memuat artikel tips keamanan siber praktis bagi ASN dan warga (misal: cara mengenali email *phishing*, mengamankan akun dengan 2FA, manajemen kata sandi).
- **Fitur Detail Artikel:** Mendukung tampilan gambar sampul ber-alt-text, isi artikel terformat rapi, penyematan video YouTube resmi (jika ada), serta tombol unduh lampiran berkas (jika disediakan).

### 3.8 Halaman Direktori Agen Siber OPD (`/agen-siber`)
Menampilkan daftar personel penghubung (*contact person* / Agen Siber) yang ditunjuk di setiap Organisasi Perangkat Daerah (Dinas, Badan, Kantor, Kecamatan) di Kota Pariaman.
- **Fitur Filter Instansi/OPD:** Pengunjung dapat memilih nama OPD dari kotak pilihan (*dropdown*) lalu menekan tombol **Terapkan** untuk menampilkan agen siber khusus di instansi tersebut.

### 3.9 Halaman Agenda Kegiatan Siber (`/agenda`)
Menampilkan daftar kegiatan keamanan siber baik yang akan datang maupun yang telah terlaksana, lengkap dengan informasi **Nama Kegiatan**, **Waktu Mulai & Selesai (WIB)**, **Lokasi Pelaksanaan**, dan **Deskripsi Kegiatan**.

### 3.10 Halaman Saluran Pelaporan Insiden (`/saluran-pelaporan`) dan Kontak (`/kontak`)
Halaman rujukan utama saat terjadi insiden siber (seperti *web defacement*, infeksi *ransomware*, kebocoran data, atau serangan DDoS):
1. **Peringatan Keamanan Penting:** Kotak peringatan agar pelapor **tidak pernah** mengirimkan kata sandi, kode OTP, atau token rahasia saat melapor.
2. **Kartu Kanal Pelaporan Aktif:** Menampilkan tombol aksi langsung menuju saluran yang telah diverifikasi (Email Resmi, WhatsApp Aduan, Telepon Darurat, atau Portal Helpdesk) beserta jam operasional masing-masing kanal.
3. **Daftar Periksa "Siapkan Informasi Ini":** Daftar poin bukti awal yang wajib disiapkan pelapor sebelum menghubungi CSIRT (seperti URL terdampak, waktu kejadian, tangkapan layar gejala, dan kontak PIC teknis OPD).

### 3.11 Endpoint Standar `/.well-known/security.txt`
Dapat diakses langsung pada URL `https://domain-csirt/well-known/security.txt`.
- Jika alamat email keamanan resmi sudah diisi di Pengaturan Situs (bukan placeholder `[ISI: ...]`), halaman ini menghasilkan teks standar RFC 9116 berisi baris `Contact:`, `Expires:`, `Preferred-Languages: id, en`, `Canonical:`, serta `Policy:` (jika diisi).

---

## BAB 4: PANDUAN DASAR PANEL ADMIN CMS (`/panel-csirt`)

### 4.1 Cara Masuk (*Login*) dan Keluar (*Logout*)
1. Buka peramban web (*Chrome*, *Edge*, *Firefox*, atau *Safari*) dan kunjungi alamat:
   - Lingkungan Lokal: `http://127.0.0.1:8000/panel-csirt` (atau `http://csirt-pariaman.test/panel-csirt`)
   - *(Catatan: Mengakses `/admin` akan otomatis diarahkan ke `/panel-csirt`)*.
2. Masukkan **Alamat Email** dan **Kata Sandi** akun staf Anda.
3. Klik tombol **Masuk** (*Sign in*).
4. Untuk keluar dari sesi setelah selesai bekerja, klik ikon profil nama Anda di pojok kanan atas layar, lalu pilih **Keluar** (*Sign out*).

### 4.2 Struktur Navigasi Panel Administrasi
Bilah menu di sisi kiri layar (*sidebar*) dikelompokkan menjadi **3 Grup Utama** sesuai fungsi kerja:

```
📂 Konten
   ├── 📄 Halaman
   ├── 📰 Berita & Edukasi
   ├── 🏷️ Kategori
   └── 📅 Agenda

📂 Operasional Keamanan
   ├── 🛡️ Advisori Keamanan
   ├── 🛠️ Layanan
   ├── 📁 Dokumen
   └── 👥 Agen Siber

📂 Navigasi & Sistem
   ├── 🧭 Menu Navigasi
   ├── 🔗 Portal Layanan
   ├── ⚙️ Pengaturan Situs
   └── 👤 Pengguna & Peran
```

### 4.3 Siklus Hidup Konten: Draf, Terbit, dan Terjadwal
Pada modul **Halaman**, **Berita & Edukasi**, **Advisori Keamanan**, **Dokumen**, **Layanan**, dan **Agenda**, terdapat pengaturan publikasi dengan tiga perilaku:
1. **Draf (`Status = Draf`):**
   - Konten disimpan di database tetapi **tidak akan tampil** di halaman publik maupun di daftar terbaru. Gunakan status ini saat artikel/advisori masih ditulis atau menunggu persetujuan pimpinan.
2. **Terbit Langsung (`Status = Terbit`, `Waktu Terbit` dikosongkan atau diisi waktu lampau/sekarang):**
   - Konten langsung tayang dan dapat dibaca oleh pengunjung publik detik itu juga.
3. **Terbit Terjadwal (`Status = Terbit`, `Waktu Terbit` diisi tanggal/jam di masa depan):**
   - Sistem mengenali konten ini sebagai **Terjadwal**. Konten belum akan muncul di halaman publik sampai jam pada `Waktu Terbit` (WIB) tercapai. Saat waktunya tiba, konten otomatis tayang tanpa perlu dibuka kembali oleh admin.

### 4.4 Fitur Pratinjau Staf (*Staff Preview*)
Sebelum mengubah status konten dari **Draf** menjadi **Terbit**, staf yang sedang login dapat melihat tampilan nyata konten tersebut di kerangka situs publik melalui rute pratinjau:
- Pratinjau Halaman: `/pratinjau/halaman/{id}`
- Pratinjau Berita/Edukasi: `/pratinjau/pos/{id}`
- Pratinjau Advisori: `/pratinjau/advisori/{id}`

> **Catatan Keamanan Pratinjau:** Halaman pratinjau menyertakan meta tag `noindex, nofollow` agar tidak diindeks oleh Google, dan otomatis mengembalikan galat `404 Not Found` jika dibuka oleh pengunjung yang belum login sebagai staf.

---

## BAB 5: PANDUAN MODUL KONTEN DAN PUBLIKASI

Bab ini ditujukan bagi pengguna dengan peran **`editor`**, **`koordinator`**, dan **`superadmin`**.

### 5.1 Modul Halaman (*Pages* — `/panel-csirt/pages`)
Modul ini digunakan untuk membuat dan mengubah halaman informasi statis/dinamis seperti **Beranda**, **Profil**, **Saluran Pelaporan**, **Kontak**, atau halaman baru lainnya.

**Cara Membuat / Mengedit Halaman:**
1. Klik menu **Konten > Halaman**, lalu klik tombol **Buat** di kanan atas (atau klik **Ubah** pada baris halaman yang sudah ada).
2. Isi bagian **Informasi Halaman**:
   - **Judul Halaman** *(Wajib)*: Nama halaman (contoh: `Profil CSIRT Kota Pariaman`).
   - **Slug URL** *(Wajib)*: Terisi otomatis dari judul (hanya huruf kecil, angka, dan tanda hubung `-`).
     > **Penting:** Sistem memblokir *slug* yang sudah dipakai oleh rute tetap sistem (`admin`, `panel-csirt`, `login`, `logout`, `layanan`, `agen-siber`, `dokumen`, `agenda`, `berita`, `edukasi`, `advisori`, `pratinjau`, `up`, `storage`).
   - **Templat** *(Wajib)*: Pilih tata letak halaman (`Bawaan (Standar)`, `Penuh (Lebar)`, atau `Beranda`).
   - **Halaman Induk** *(Opsional)*: Pilih jika halaman ini merupakan sub-halaman dari halaman lain.
   - **Jadikan sebagai Halaman Beranda**: Aktifkan sakelar ini **hanya** untuk satu halaman yang ingin dijadikan halaman utama (`/`).
3. Atur bagian **Publikasi** (`Status` dan `Terbit Pada`).
4. Susun isi halaman menggunakan **Penyusun Blok Konten (*Builder*)** (lihat rincian 13 blok pada Sub-bab 5.2). Anda dapat menambah blok, mengurutkan ulang blok dengan menarik ikon geser (*drag & drop*), melipat blok, atau menghapus blok.
5. *(Opsional)* Buka bagian **Optimasi Mesin Pencari (SEO)** untuk mengisi *Judul SEO (Meta Title)* dan *Deskripsi SEO (Meta Description)*.
6. Klik tombol **Simpan** (*Save*).

### 5.2 Referensi Lengkap 13 Blok *Page Builder*
Ketika menyusun halaman di modul **Halaman**, Anda dapat memilih kombinasi dari **13 jenis blok modular** berikut:

| No | Nama Blok | Fungsi Tampilan di Halaman Publik | Kolom Isian (*Fields*) di Panel Admin |
| :-: | :--- | :--- | :--- |
| 1 | **Hero Banner** (`hero`) | Spanduk utama berlatar biru tua di bagian atas halaman dengan judul besar dan 2 tombol aksi. | • `Judul Hero` *(Wajib)*<br>• `Subjudul / Deskripsi`<br>• `Label Tombol Utama` (bawaan: *Lapor Insiden*, otomatis mengarah ke CTA Pelaporan)<br>• `Label Tombol Sekunder` & `Tautan Sekunder` |
| 2 | **Teks Kaya (Rich Text)** (`rich_text`) | Paragraf artikel bebas dengan subjudul (H2/H3), daftar poin, teks tebal/miring, dan tautan. | • `Isi Konten` *(Wajib — Editor WYSIWYG, otomatis disanitasi dari skrip berbahaya)* |
| 3 | **Daftar Advisori Terbaru** (`latest_advisories`) | Menampilkan grid kartu peringatan keamanan siber terbaru secara otomatis dari modul Advisori. | • `Judul Bagian` (bawaan: *Peringatan & Advisori Keamanan*)<br>• `Jumlah Advisori` (angka 1 s.d. 6, bawaan: 3) |
| 4 | **Kartu Saluran Pelaporan** (`report_channels`) | Menampilkan daftar kartu kanal pelaporan aktif, daftar periksa bukti, dan peringatan keamanan dari Pengaturan Situs. | • `Judul Bagian (Opsional)` (placeholder: *Kanal Resmi Pelaporan Insiden*) |
| 5 | **Langkah-Langkah (Steps)** (`steps`) | Menampilkan tahapan berurutan bernomor (1, 2, 3...) untuk menjelaskan alur prosedur/SOP. | • `Judul Bagian` (bawaan: *Alur Penanganan Insiden*)<br>• `Daftar Langkah` (*Repeater*: `Judul Langkah` & `Deskripsi Langkah`) |
| 6 | **Kartu Layanan** (`service_cards`) | Menampilkan kartu layanan dari modul Katalog Layanan, baik semua kelompok maupun kelompok tertentu. | • `Judul Bagian` (bawaan: *Layanan Kami*)<br>• `Kelompok Layanan` *(Opsional: Reaktif / Proaktif / Kualitas)*<br>• `Batas Jumlah` (bawaan: 6) |
| 7 | **Berita & Edukasi Terbaru** (`latest_posts`) | Menampilkan grid kartu artikel Berita atau Edukasi terbaru secara otomatis. | • `Judul Bagian`<br>• `Tipe Artikel` (`Berita` atau `Edukasi`)<br>• `Jumlah Artikel` (bawaan: 3) |
| 8 | **Tautan Portal Layanan** (`portal_links`) | Menampilkan kartu tautan ke aplikasi/portal eksternal dari modul Portal Layanan. | • `Judul Bagian` (bawaan: *Layanan Siber Terpadu*) |
| 9 | **Blok Kontak Darurat** (`contact_block`) | Menampilkan kartu informasi alamat kantor, telepon, email keamanan, jam kerja, dan PGP dari Pengaturan Situs. | • `Judul Bagian` (bawaan: *Hubungi Tim CSIRT*) |
| 10 | **Daftar Dokumen** (`document_list`) | Menampilkan tabel unduhan berkas dari modul Dokumen (bisa difilter khusus RFC-2350, SOP, dll.). | • `Judul Bagian` (bawaan: *Dokumen Terkait*)<br>• `Kategori Dokumen` *(Opsional: RFC-2350, Regulasi, SOP, Panduan, Lainnya)* |
| 11 | **Tabel Agen Siber** (`agent_table`) | Menampilkan daftar agen siber OPD aktif langsung di dalam halaman. | • `Judul Bagian` (bawaan: *Daftar Agen Siber OPD*) |
| 12 | **Pemberitahuan (Callout)** (`callout`) | Kotak sorotan berbingkai untuk menampilkan catatan penting atau peringatan di tengah halaman. | • `Tingkat`: `Informasi (Biru)`, `Peringatan (Kuning/Emas)`, atau `Bahaya / Kritis (Merah)`<br>• `Isi Pemberitahuan` *(Wajib)* |
| 13 | **Tombol Aksi** (`button`) | Menampilkan satu tombol tautan menonjol menuju halaman internal atau situs eksternal. | • `Label Tombol` *(Wajib)*<br>• `Tautan URL` *(Wajib — divalidasi dengan `SafeUrl`)* |

### 5.3 Modul Berita dan Edukasi (*Posts* — `/panel-csirt/posts`)
Modul ini mengelola artikel untuk halaman `/berita` dan `/edukasi`.

**Langkah Pengisian:**
1. Buka **Konten > Berita & Edukasi**, lalu klik **Buat**.
2. Pada bagian **Konten Artikel**:
   - **Tipe Artikel** *(Wajib)*:
     - Pilih **`Berita`** agar artikel terbit di `/berita/{slug}`.
     - Pilih **`Edukasi`** agar artikel terbit di `/edukasi/{slug}`.
   - **Kategori**: Pilih kategori yang sesuai (daftar kategori otomatis menyesuaikan dengan Tipe Artikel yang dipilih).
   - **Judul** *(Wajib)* & **Slug** *(Wajib — otomatis terisi)*.
   - **Ringkasan Singkat (*Excerpt*)**: Paragraf pendek (1–2 kalimat) yang tampil pada kartu daftar artikel.
   - **Isi Lengkap** *(Wajib)*: Isi artikel utama menggunakan editor teks kaya.
3. Pada bagian **Media & Berkas Pendukung**:
   - **Gambar Sampul**: Unggah foto format `JPG`, `PNG`, atau `WEBP` (maksimal **4 MB**). *Format SVG ditolak demi keamanan.*
   - **Teks Alternatif Sampul (Aksesibilitas)**: **Wajib diisi apabila Anda mengunggah Gambar Sampul.** Jelaskan isi gambar secara singkat (misal: *"Suasana pembukaan Bimtek Agen Siber di Aula Balai Kota Pariaman"*) untuk membantu tunanetra pengguna pembaca layar.
   - **Tautan Video YouTube *(Opsional)***: Masukkan URL YouTube valid (`https://www.youtube.com/watch?v=...` atau `https://youtu.be/...`) jika artikel disertai dokumentasi video.
   - **Lampiran Berkas *(Opsional)***: Unggah berkas materi pendamping berformat `PDF`, `DOCX`, atau `XLSX` (maksimal **20 MB**).
4. Pada bagian **Publikasi**: Pilih status (`Draf` / `Terbit`) dan waktu terbit, lalu klik **Simpan**.

### 5.4 Modul Kategori Artikel (*Categories* — `/panel-csirt/categories`)
Digunakan untuk mengelompokkan artikel Berita maupun Edukasi:
- **Tipe** *(Wajib)*: Pilih `Berita` atau `Edukasi`.
- **Nama Kategori** *(Wajib)*: Contoh: *Kegiatan*, *Pengumuman*, *Tips Keamanan*, *Waspada Phishing*.
- **Slug** *(Wajib)*: Terisi otomatis dari nama kategori.

### 5.5 Modul Agenda Kegiatan (*Events* — `/panel-csirt/events`)
Digunakan untuk mempublikasikan jadwal kegiatan CSIRT di halaman `/agenda`:
- **Nama Kegiatan / Agenda** *(Wajib)* & **Slug** *(Wajib)*.
- **Lokasi**: Tempat pelaksanaan (contoh: *Ruang Rapat Diskominfo Kota Pariaman* atau *Daring via Zoom*).
- **Waktu Mulai** *(Wajib)* & **Waktu Selesai** *(Harus sama atau setelah Waktu Mulai, dalam zona waktu WIB)*.
- **Deskripsi Kegiatan**: Penjelasan singkat agenda dan peserta kegiatan.
- **Status** (`Draf` / `Terbit`) & **Waktu Terbit**.

---

## BAB 6: PANDUAN MODUL OPERASIONAL KEAMANAN SIBER

Bab ini ditujukan bagi pengguna dengan peran **`analis`**, **`koordinator`**, dan **`superadmin`**.

### 6.1 Modul Advisori Keamanan (*Advisories* — `/panel-csirt/advisories`)
Digunakan untuk menerbitkan peringatan dini kerentanan perangkat lunak atau ancaman siber terkini ke halaman `/advisori`.

**Langkah Pengisian:**
1. Buka **Operasional Keamanan > Advisori Keamanan**, lalu klik **Buat**.
2. Isi bagian **Informasi Advisori**:
   - **Judul Advisori** *(Wajib)*: Disarankan menyertakan kode referensi atau CVE jika ada (contoh: *Peringatan Kerentanan Eksekusi Kode Jarak Jauh pada Web Server (CVE-2026-XXXX)*).
   - **Slug** *(Wajib)*: Terisi otomatis.
   - **Tingkat Keparahan (*Severity*)** *(Wajib)*: Pilih salah satu dari 4 level:
     - `Rendah` (*Low*) — Risiko minimal, dampak terbatas.
     - `Sedang` (*Medium*) — Perlu perhatian dan penjadwalan perbaikan.
     - `Tinggi` (*High*) — Celah berbahaya, harus segera diperbaiki.
     - `Kritis` (*Critical*) — Kerentanan darurat yang sedang dieksploitasi aktif, wajib ditangani seketika.
   - **Ringkasan Ancaman** *(Wajib)*: Gambaran umum celah keamanan dalam 2–3 kalimat.
   - **Sistem Terdampak**: Sebutkan produk dan versi yang rentan (contoh: *Linux Kernel < 6.8, Apache HTTP Server 2.4.x*).
   - **Langkah Mitigasi & Rekomendasi** *(Wajib)*: Panduan teknis langkah demi langkah bagi admin sistem OPD untuk mengatasi kerentanan tersebut.
3. Atur bagian **Publikasi** (`Draf` / `Terbit` & `Waktu Terbit`), lalu klik **Simpan**.

### 6.2 Modul Dokumen Resmi & RFC-2350 (*Documents* — `/panel-csirt/documents`)
Digunakan untuk mengunggah dokumen pedoman, regulasi, dan dokumen spesifikasi RFC-2350 ke halaman `/dokumen`.

**Langkah Pengisian:**
1. Buka **Operasional Keamanan > Dokumen**, lalu klik **Buat**.
2. Isi atribut dokumen:
   - **Judul Dokumen** *(Wajib)*: Nama resmi dokumen (contoh: *Dokumen RFC-2350 CSIRT Kota Pariaman*).
   - **Kategori Dokumen** *(Wajib)*: Pilih salah satu:
     - `RFC-2350` (Profil resmi CSIRT sesuai standar IETF)
     - `Regulasi` (Perwako, SK Pembentukan, Kebijakan)
     - `SOP` (Standar Operasional Prosedur)
     - `Panduan` (Pedoman teknis / buku saku)
     - `Lainnya`
   - **Versi**: Nomor versi dokumen (bawaan: `v1.0`).
   - **Bahasa**: Kode bahasa dokumen (bawaan: `id` untuk Bahasa Indonesia, atau `en` untuk Bahasa Inggris).
   - **Tanggal Berlaku**: Tanggal mulai berlakunya dokumen.
   - **Urutan**: Angka urutan tampil (angka lebih kecil tampil lebih atas, misal `1`, `2`, `3`).
   - **Berkas Dokumen** *(Wajib)*: Unggah file berformat **`PDF`**, **`DOCX`**, atau **`XLSX`** dengan ukuran maksimal **20 MB**. *(Sistem secara otomatis menghitung ukuran file dalam byte untuk ditampilkan di halaman publik).*
3. Pilih **Status** (`Draf` / `Terbit`) dan klik **Simpan**.

### 6.3 Modul Katalog Layanan (*Services* — `/panel-csirt/services`)
Digunakan untuk mengelola daftar layanan keamanan siber yang ditampilkan di halaman `/layanan`.

**Langkah Pengisian:**
1. Buka **Operasional Keamanan > Layanan**, lalu klik **Buat**.
2. Isi rincian layanan:
   - **Kelompok Layanan** *(Wajib)*:
     - `Layanan reaktif` (*Reactive*)
     - `Layanan proaktif` (*Proactive*)
     - `Peningkatan kualitas keamanan` (*Quality*)
   - **Nama Layanan** *(Wajib)* & **Slug** *(Wajib)*.
   - **Urutan Tampilan**: Nomor urut tampilan kartu.
   - **Deskripsi Layanan** *(Wajib)*: Penjelasan cakupan layanan.
   - **Sasaran Pemohon**: Siapa yang berhak mengajukan layanan (bawaan: *Organisasi Perangkat Daerah (OPD) Pemko Pariaman*).
   - **Mekanisme Permohonan**: Cara mengajukan layanan (bawaan: *Melalui Saluran Resmi Pelaporan CSIRT Kota Pariaman*).
   - **Jam Layanan**: Waktu operasional layanan (bawaan: *Senin - Jumat, 08.00 - 16.00 WIB*).
   - **Target Waktu Respons (SLA)**: Estimasi waktu tanggap awal (bawaan: *Maksimal 1 x 24 Jam*).
3. Pilih **Status** (`Draf` / `Terbit`) dan klik **Simpan**.

---

## BAB 7: PANDUAN MODUL DIREKTORI, NAVIGASI, DAN PENGATURAN SITUS

Bab ini ditujukan bagi pengguna dengan peran **`koordinator`** dan **`superadmin`**.

### 7.1 Modul Direktori Agen Siber OPD (*Agents* — `/panel-csirt/agents`)
Mengelola daftar personel perwakilan keamanan siber dari setiap instansi/OPD yang tampil di halaman `/agen-siber`.
- **Nama Lengkap** *(Wajib)*: Nama personel agen siber.
- **Instansi / OPD** *(Wajib)*: Nama dinas/badan/kecamatan. *(Nilai pada kolom ini secara otomatis membentuk daftar filter dropdown OPD di halaman publik).*
- **Jabatan**: Jabatan struktural/fungsional (contoh: *Pranata Komputer Ahli Muda*).
- **Kontak Resmi**: Email dinas atau nomor telepon kantor (hindari mencantumkan nomor pribadi tanpa izin).
- **Urutan**: Angka pengurutan daftar.
- **Status Aktif**: Sakelar untuk menampilkan atau menyembunyikan agen dari halaman publik tanpa menghapus datanya.
- **Foto Resmi *(Opsional)***: Foto profil berformat `JPG`, `PNG`, atau `WEBP` (maksimal **4 MB**).

### 7.2 Modul Tautan Portal Layanan (*Portal Links* — `/panel-csirt/portal-links`)
Mengelola daftar kartu tautan cepat menuju portal eksternal Pemerintah Kota Pariaman atau instansi terkait:
- **Nama Portal / Layanan** *(Wajib)*: Contoh: *Portal Resmi Pemko Pariaman*, *LPSE Kota Pariaman*, *BSSN*.
- **Alamat URL** *(Wajib)*: Harus berupa URL lengkap berawalan `http://` atau `https://`.
- **Ikon**: Nama ikon pendukung (contoh: `globe`, `shield`, `lock`, `server`).
- **Urutan**, **Deskripsi Singkat**, dan sakelar **Aktif**.

### 7.3 Modul Menu Navigasi (*Menu Items* — `/panel-csirt/menu-items`)
Mengelola struktur menu pada **Header Navigasi Atas** dan **Footer Bawah** situs.

**Ketentuan & Kolom Isian:**
- **Lokasi Menu** *(Wajib)*: Pilih `Header Navigasi Atas` atau `Footer Bawah`.
- **Menu Induk**: Kosongkan jika butir ini adalah menu tingkat utama. Pilih salah satu menu utama jika ingin menjadikannya **submenu (*dropdown*)**.
  > **Batasan Aksesibilitas:** Sistem membatasi struktur menu maksimal **1 tingkat submenu** (Induk -> Anak) agar menu tetap nyaman dioperasikan dengan keyboard dan layar ponsel.
- **Label Menu** *(Wajib)*: Teks yang tampil di menu (contoh: *Profil*, *Informasi*, *Advisori Keamanan*).
- **Tipe Tautan** *(Wajib)*:
  1. `Halaman Dinamis (CMS)`: Memilih langsung dari daftar halaman yang ada di modul Halaman.
  2. `Tautan Kustom / Rute Tetap`: Memasukkan jalur internal (seperti `/layanan`, `/dokumen`, `/advisori`, `/berita`, `/edukasi`, `/agen-siber`, `/agenda`) atau URL eksternal (`https://...`).
- **Urutan**: Angka urutan tampil dari kiri ke kanan (atau atas ke bawah pada submenu).
- **Buka di Tab Baru (`_blank`)**: Aktifkan jika tautan mengarah ke situs eksternal.
- **Aktif Ditampilkan**: Sakelar untuk mengaktifkan/menonaktifkan menu. *(Setiap perubahan menu otomatis memperbarui cache navigasi situs).*

### 7.4 Halaman Pengaturan Situs & Kanal Pelaporan (`/panel-csirt/manage-settings`)
Halaman ini adalah **pusat kendali utama identitas dan saluran komunikasi website**. Seluruh perubahan di halaman ini langsung menyinkronkan Header, Beranda, Halaman Kontak, Halaman Saluran Pelaporan, Footer, dan file `security.txt`.

Halaman dibagi ke dalam **5 Tab Pengaturan**:

#### Tab 1: Identitas
- **Nama Situs**: Nama utama portal (bawaan: `CSIRT Kota Pariaman`).
- **Slogan / Tagline**: Slogan singkat yang juga menjadi meta deskripsi bawaan situs.
- **Judul Hero Beranda** & **Subjudul Hero Beranda**: Teks utama spanduk beranda.
- **Teks Footer (Hak Cipta)**: Teks di bagian paling bawah situs (contoh: `© Diskominfo Kota Pariaman`).

#### Tab 2: Kontak & Jam Kerja
- **Alamat Kantor**: Alamat lengkap sekretariat CSIRT Diskominfo Kota Pariaman.
- **Telepon Kantor**: Nomor telepon reguler jam kerja.
- **Telepon Darurat (Hotline)**: Nomor darurat penanganan insiden 24/7.
- **Email Keamanan (Resmi)**: Alamat email resmi pelaporan insiden (contoh: `csirt@pariamankota.go.id`).
- **Jam Layanan**: Informasi hari dan jam pelayanan kantor.

#### Tab 3: Keamanan & PGP (`security.txt`)
- **Fingerprint Kunci PGP**: Sidik jari kunci kriptografi publik PGP tim CSIRT untuk komunikasi email terenkripsi.
- **URL Kebijakan Pengungkapan Kerentanan**: Tautan lengkap (`https://...`) menuju halaman kebijakan pengungkapan kerentanan.
- **Tanggal Kedaluwarsa `security.txt`**: Tanggal batas validitas file `/.well-known/security.txt` sesuai standar RFC 9116.

#### Tab 4: Saluran Pelaporan (CTA)
Tab ini mengatur ke mana pelapor diarahkan saat menekan tombol **"Lapor Insiden"**:
1. **Tombol Utama "Lapor Insiden"**:
   - **Tipe Tujuan Tombol**:
     - `Halaman Internal`: Mengarahkan ke slug halaman di dalam situs (bawaan: `saluran-pelaporan`).
     - `Email`: Membuka aplikasi email pelapor (`mailto:`).
     - `WhatsApp`: Membuka chat WhatsApp resmi (`https://wa.me/62...`).
     - `Tautan Eksternal (Helpdesk)`: Mengarahkan ke sistem tiket eksternal (`https://...`).
   - **Nilai Tujuan (Slug / Email / Nomor / URL)**: Isi sesuai tipe yang dipilih di atas.
2. **Daftar Kartu Kanal Pelaporan (*Repeater*)**:
   - Mengelola kartu-kartu saluran yang tampil di halaman Saluran Pelaporan.
   - Setiap kartu memiliki: **Tipe** (`Email`, `WhatsApp`, `Telepon`, `Tautan / Portal`), **Label Kanal**, **Nilai / Kontak**, **Jam Operasional**, dan sakelar **Aktif**.
   - *Catatan:* Untuk tipe WhatsApp/Telepon, nomor berawalan `08xx` otomatis dikonversi sistem menjadi format internasional `628xx`.
3. **Panduan Pelaporan & Peringatan**:
   - **Daftar Periksa "Siapkan Informasi Ini"**: Poin-poin bukti insiden yang harus disiapkan pelapor.
   - **Peringatan Keamanan**: Pesan larangan mengirim kata sandi, token, atau kode OTP.

#### Tab 5: Banner Darurat
Digunakan saat terjadi insiden siber berskala besar atau pengumuman mendesak:
- **Aktifkan Banner Darurat di Seluruh Situs**: Sakelar hidup/mati.
- **Tingkat Keparahan Banner**:
  - `Informasi (Biru)`
  - `Peringatan (Kuning/Emas)`
  - `Bahaya / Kritis (Merah)`
- **Isi Pesan Banner**: Teks pengumuman singkat yang akan muncul di bagian paling atas setiap halaman publik.

Setelah selesai mengubah tab mana pun, klik tombol **Simpan Pengaturan** di bagian bawah.

### 7.5 Mekanisme Pengaman Placeholder `[ISI: ...]`
Pada instalasi awal, data kontak yang belum dikonfirmasi secara resmi ditulis dengan format diawali **`[ISI: ...]`** (contoh: `[ISI: alamat kantor]`, `[ISI: telepon]`, `[ISI: email keamanan]`).
Sistem memiliki pengaman otomatis pada kelas `App\Support\Settings`:
1. Selama nilai masih berawalan `[ISI`, sistem **tidak akan mengubahnya menjadi tautan aktif** (`tel:`, `mailto:`, atau `wa.me`) agar pengunjung tidak mengeklik tautan palsu/rusak.
2. Di lingkungan pengembangan (`APP_ENV=local`), teks `[ISI: ...]` tetap ditampilkan agar admin mudah melihat data mana yang belum dilengkapi.
3. Di lingkungan produksi (`APP_ENV=production`), nilai yang masih berawalan `[ISI` otomatis **disembunyikan** agar tidak terbaca sebagai informasi resmi yang salah.
4. Begitu Anda mengganti teks `[ISI: ...]` di menu **Pengaturan Situs** dengan nomor telepon atau email asli yang valid, tautan dan kartu kanal pelaporan akan **aktif secara otomatis**.

---

## BAB 8: PANDUAN MANAJEMEN PENGGUNA DAN PERAN (KHUSUS SUPERADMIN)

Modul ini hanya dapat diakses oleh pengguna dengan peran **`superadmin`** melalui menu **Navigasi & Sistem > Pengguna & Peran** (`/panel-csirt/users`).

### 8.1 Melihat Daftar Pengguna
Tabel pengguna menampilkan kolom **Nama Lengkap**, **Alamat Email**, lencana warna **Peran (*Role*)**, dan **Terdaftar Pada**. Anda dapat mencari pengguna melalui kotak pencarian di kanan atas tabel.

### 8.2 Menambah Akun Staf Baru
1. Buka menu **Pengguna & Peran**, lalu klik tombol **Buat** di pojok kanan atas.
2. Isi formulir **Informasi Akun**:
   - **Nama Lengkap** *(Wajib)*: Nama lengkap beserta gelar/unit kerja bila perlu.
   - **Alamat Email** *(Wajib)*: Alamat email resmi yang akan dipakai untuk login (harus unik, belum pernah didaftarkan sebelumnya).
   - **Kata Sandi** *(Wajib saat membuat akun baru)*: Masukkan kata sandi yang kuat (kombinasi huruf besar, huruf kecil, angka, dan simbol).
   - **Peran (Role)**: Pilih satu peran sesuai tugas staf tersebut (`superadmin`, `koordinator`, `analis`, atau `editor`).
3. Klik tombol **Buat** / **Simpan**. Staf tersebut kini dapat langsung login di `/panel-csirt`.

### 8.3 Mengubah Peran (*Role*) dan Mereset Kata Sandi Lewat Panel
1. Pada tabel **Pengguna & Peran**, klik tombol **Ubah** (*Edit*) pada baris pengguna yang dituju.
2. **Untuk Mengganti Peran:** Hapus peran lama pada kolom **Peran (Role)** dan pilih peran yang baru.
3. **Untuk Mereset Kata Sandi:**
   - Ketikkan kata sandi baru pada kolom **Kata Sandi**.
   - *Penting:* Jika Anda hanya ingin mengubah nama, email, atau peran tanpa mengubah kata sandi pengguna tersebut, **biarkan kolom Kata Sandi tetap kosong**.
4. Klik **Simpan Perubahan**.

### 8.4 Menghapus Akun dan Proteksi Akun Sendiri
- Anda dapat menghapus akun staf yang sudah tidak bertugas melalui tombol hapus di dalam halaman edit atau tindakan massal (*bulk action*) pada tabel.
- Sistem secara otomatis **menolak penghapusan akun yang sedang Anda gunakan login sendiri** untuk memastikan portal selalu memiliki minimal satu `superadmin` aktif.

---

## BAB 9: PEMELIHARAAN TEKNIS, OPTIMASI, DAN DAFTAR PERIKSA PRODUKSI

Bab ini ditujukan bagi administrator server / tim teknis IT Diskominfo Kota Pariaman.

### 9.1 Sistem Keamanan Berlapis yang Diterapkan
1. **Sanitasi HTML (`App\Support\Html`):** Seluruh input dari *Rich Editor* (Isi Halaman, Isi Berita/Edukasi, Langkah Mitigasi Advisori) dibersihkan dari tag `<script>`, `<iframe>` liar, atribut event (`onclick`, `onerror`), dan skema berbahaya sebelum ditampilkan ke pengunjung guna menangkal serangan *Stored XSS*.
2. **Validasi Tautan Aman (`App\Rules\SafeUrl`):** Seluruh input URL pada Menu Navigasi, Portal Layanan, Tombol Blok, dan Pengaturan Situs menolak skema berbahaya seperti `javascript:`, `data:`, `vbscript:`, dan protokol relatif `//`.
3. **Pembatasan Tipe Berkas Unggahan:** Gambar sampul dan foto agen hanya menerima `JPG`, `PNG`, dan `WEBP` (menolak `SVG` yang berisiko membawa payload XML/XSS). Dokumen hanya menerima `PDF`, `DOCX`, dan `XLSX`.
4. **Header Keamanan HTTP (`App\Http\Middleware\PublicSecurityHeaders`):** Seluruh respons publik menyertakan header pelindung `Content-Security-Policy` (CSP), `X-Content-Type-Options: nosniff`, `X-Frame-Options: SAMEORIGIN`, dan `Referrer-Policy: strict-origin-when-cross-origin`.

### 9.2 Perintah Terminal (Artisan CLI) untuk Pemeliharaan

Jalankan perintah berikut melalui terminal pada direktori proyek (`c:\laragon\www\csirt-pariaman`):

| Kebutuhan Administrasi Teknis | Perintah Terminal |
| :--- | :--- |
| **Menjalankan migrasi dan data awal (Seeder)** | `php artisan migrate --seed` |
| **Membersihkan seluruh cache sistem** | `php artisan optimize:clear` |
| **Mengoptimalkan komponen Filament & View (Lokal/Produksi)** | `php artisan filament:optimize`<br>`php artisan view:cache` |
| **Mengoptimalkan penuh untuk Server Produksi** | `php artisan optimize`<br>`php artisan filament:optimize` |
| **Membangun aset CSS & JS produksi (Vite)** | `npm run build` |
| **Menjalankan seluruh pengujian otomatis (90 tes Pest)** | `php artisan test --compact` |
| **Memeriksa dan merapikan standar kode PHP** | `vendor/bin/pint` |

**Cara Mereset Kata Sandi Superadmin Melalui Terminal (Jika Lupa Sandi):**
Apabila seluruh `superadmin` lupa kata sandi untuk masuk ke `/panel-csirt`, administrator server dapat meresetnya melalui **Laravel Tinker**:
```powershell
php artisan tinker
```
Lalu ketik perintah berikut di dalam konsol Tinker:
```php
$user = App\Models\User::where('email', 'superadmin@csirt.pariamankota.go.id')->first();
$user->password = bcrypt('SandiBaruYangKuat#2026!');
$user->save();
exit
```

### 9.3 Daftar Periksa Sebelum Peluncuran Resmi (*Go-Live Checklist*)
Sebelum domain resmi `csirt.pariamankota.go.id` dibuka untuk publik, pastikan daftar periksa berikut telah diselesaikan:
- [ ] **Konfigurasi `.env` Produksi:**
  - Setel `APP_ENV=production` dan `APP_DEBUG=false` (agar banner prototipe hilang dan pesan error teknis disembunyikan).
  - Setel `APP_URL=https://csirt.pariamankota.go.id` dan `APP_TIMEZONE=Asia/Jakarta`.
  - Pastikan `CACHE_STORE=file` (atau `redis`) dan `SESSION_DRIVER=file` (atau `database`/`redis`).
- [ ] **Penggantian Data Placeholder `[ISI: ...]`:**
  - Masuk ke `/panel-csirt/manage-settings` dan ganti seluruh nilai `[ISI: ...]` dengan Alamat Kantor, Telepon, Hotline Darurat, Email Keamanan, Jam Layanan, serta Fingerprint PGP resmi Diskominfo Kota Pariaman.
- [ ] **Pengunggahan Dokumen RFC-2350 Final:**
  - Unggah berkas PDF resmi dokumen RFC-2350 yang telah disahkan pimpinan pada menu **Operasional Keamanan > Dokumen**.
- [ ] **Penautan Storage Publik:**
  - Pastikan perintah `php artisan storage:link` telah dijalankan agar gambar sampul berita, foto agen, dan dokumen unduhan dapat diakses publik.
- [ ] **Pengamanan Akun Awal:**
  - Ganti kata sandi bawaan akun `superadmin@csirt.pariamankota.go.id` dan buat akun terpisah untuk masing-masing staf (`koordinator`, `analis`, `editor`).

---

## BAB 10: PERTANYAAN UMUM (FAQ) DAN PEMECAHAN MASALAH

**1. Mengapa artikel Berita, Advisori, atau Dokumen yang baru saya buat belum muncul di halaman depan?**
- Periksa kolom **Status** pada data tersebut, pastikan sudah diubah dari `Draf` menjadi **`Terbit`**.
- Periksa kolom **Waktu Terbit**. Jika terisi waktu yang lebih maju dari jam sekarang (WIB), maka konten masih berstatus *Terjadwal* dan baru akan tampil setelah melewati jam tersebut. Kosongkan kolom `Waktu Terbit` jika ingin langsung tayang.

**2. Mengapa nomor telepon atau email di halaman Saluran Pelaporan tidak muncul sebagai tombol yang bisa diklik?**
- Periksa di menu **Pengaturan Situs > Tab Saluran Pelaporan (CTA)**. Pastikan sakelar **Aktif** pada kartu kanal tersebut menyala, dan pastikan nilainya sudah diisi dengan nomor telepon atau alamat email yang valid (bukan teks placeholder `[ISI: ...]`).

**3. Mengapa saya tidak bisa menyimpan artikel Berita/Edukasi setelah mengunggah Gambar Sampul?**
- Demi standar aksesibilitas tunanetra (WCAG 2.2 AA), setiap kali Anda mengunggah **Gambar Sampul**, kolom **Teks Alternatif Sampul (Aksesibilitas)** di sebelahnya menjadi **wajib diisi**. Isi dengan deskripsi singkat gambar tersebut, lalu klik Simpan.

**4. Mengapa menu tertentu (misalnya Pengaturan Situs atau Pengguna & Peran) tidak muncul di layar saya?**
- Tampilan menu menyesuaikan dengan **Peran (*Role*)** akun Anda. Menu *Pengguna & Peran* hanya muncul bagi `superadmin`, dan menu *Pengaturan Situs* hanya muncul bagi `superadmin` serta `koordinator`. Hubungi `superadmin` jika Anda membutuhkan penyesuaian hak akses.

**5. Mengapa saya tidak bisa membuat halaman baru dengan slug `berita` atau `layanan`?**
- Kata kunci seperti `berita`, `edukasi`, `layanan`, `dokumen`, `advisori`, `agenda`, dan `agen-siber` adalah jalur tetap sistem (*Reserved Slugs*) yang memiliki halaman indeks khusus. Untuk mengubah isi daftar layanan atau berita, kelola langsung melalui modul **Layanan** atau **Berita & Edukasi** di bilah menu kiri.

---
*Akhir Dokumen Buku Panduan Sistem CSIRT Pemerintah Kota Pariaman.*

