# PRD — Website CSIRT Pemerintah Kota Pariaman

| | |
|---|---|
| **Nama produk (usulan)** | Portal CSIRT Pemko Pariaman — nama tim: *Pariamankota-CSIRT* (menyesuaikan pola penamaan CSIRT daerah lain, mis. MalangKota-CSIRT, Kedirikota-CSIRT; final mengikuti SK pembentukan) |
| **Pemilik produk** | Dinas Komunikasi dan Informatika Kota Pariaman |
| **Versi / tanggal** | v0.2 (draf) — 22 Oktober 2026 |
| **Referensi utama** | https://csirt.sumbarprov.go.id (CSIRT Sumatera Barat) |
| **Dokumen pendamping** | `DESIGN.md` (design system & panduan UI), `CMS-SPEC.md` (spesifikasi panel admin, pada skill pendamping) |

**Perubahan dari v0.1:** semua isi situs sekarang **dimasukkan dan diubah lewat panel admin, seperti WordPress**. Situs publik hanya membaca: **tidak ada form yang dikirim pengunjung**. Dihapus dari v0.1: form Lapor Insiden, tiket, Cek Status Tiket, langganan email advisori, form Hubungi Kami, dan CAPTCHA. Sebagai gantinya ada **saluran pelaporan yang tujuannya diatur admin** (bagian 8.1, FR-05).

---

## 1. Ringkasan & asumsi

Dokumen ini mendefinisikan kebutuhan produk untuk **website resmi CSIRT (Computer Security Incident Response Team) Pemerintah Kota Pariaman**, dengan mengambil situs CSIRT Sumbar sebagai referensi struktur. Situs ini menjadi **wajah publik** tim tanggap insiden siber kota: tempat OPD, ASN, dan masyarakat mengenal tim, membaca layanan dan advisori, mengetahui cara melapor, serta mengakses dokumen resmi (RFC-2350). Seluruh isinya dikelola tim CSIRT sendiri lewat panel admin tanpa perlu developer.

**Asumsi yang saya pakai — mohon dikoreksi bila keliru:**

1. Yang dimaksud adalah **situs CSIRT untuk Pemko Pariaman**, di bawah pengelolaan Diskominfo, bukan portal umum pemerintah kota.
2. **"Semua input dari admin"** berarti pengunjung tidak mengirim data apa pun lewat situs. Pelaporan insiden dilakukan lewat kanal yang sudah ada (email, WhatsApp/telepon, atau aplikasi helpdesk), dan tujuan tombol **Lapor Insiden** diatur admin. Penanganan insiden (tiket) terjadi di luar situs ini.
3. Nama tim, SK pembentukan, struktur organisasi, alamat, kontak, dan kunci PGP **belum tersedia** dan ditandai `[ISI]`. Saya tidak menemukan informasi publik tentang status CSIRT Pariaman; status pendaftaran ke BSSN perlu dikonfirmasi ke Diskominfo.
4. Domain yang diusulkan: `csirt.pariamankota.go.id` (perlu diverifikasi dengan pengelola domain pemko).
5. Bahasa utama Indonesia; Inggris untuk RFC-2350 (opsional, fase 3).

---

## 2. Hasil kajian situs referensi (csirt.sumbarprov.go.id)

### 2.1 Struktur yang teramati

| Area | Temuan |
|---|---|
| **Navigasi utama** | Beranda · Profil · Informasi (berisi *Informasi Layanan*) · RFC-2350 · Pengaduan · Hubungi Kami |
| **Beranda** | Bagian hero (saat saya ambil, isinya hanya tampil sebagai "Loading…", jadi tidak terbaca) lalu blok **"Portal Layanan"** berupa carousel kartu tautan ke layanan lain |
| **Kartu Portal Layanan** | Helpdesk Diskominfotik, PPID, Super Apps Sumbar Madani, Pelayanan Terpadu Satu Pintu, JDIH (produk hukum), LPSE, Komisi Informasi |
| **Halaman RFC-2350** | Ada di `/pages/rfc-2350`, tetapi isi dokumen tidak muncul pada hasil ambil halaman (hanya kerangka nav dan footer terbaca) |
| **Pengaduan** | Tidak ada form di situs CSIRT; menu mengarah keluar ke aplikasi helpdesk provinsi (`layanan.sumbarprov.go.id`). **Pola ini sejalan dengan keputusan v0.2** |
| **Footer** | Telepon Setda dan Diskominfo, alamat kantor, kolom *Informasi* (Berita, Foto, Agenda, Infografis, Video), tautan media sosial, hak cipta Diskominfotik |
| **Teknis** | Tampaknya aplikasi Next.js (terlihat dari metadata `next-head-count` dan pola tautan `pages/[slug]`); halaman berbasis slug |

### 2.2 Kekuatan yang layak ditiru

- Navigasi **sederhana, enam butir** — mudah dipahami ASN non-teknis.
- **RFC-2350 sebagai menu tingkat atas**, sesuai kebutuhan BSSN bahwa dokumen ini dipublikasikan di laman CSIRT.
- Blok "Portal Layanan" yang menghubungkan CSIRT ke ekosistem layanan pemerintah yang sudah ada.
- Pengaduan diarahkan ke kanal yang sudah ada, bukan membangun sistem baru.
- Footer berisi kontak lengkap yang konsisten di semua halaman.

### 2.3 Celah yang akan diperbaiki di versi Pariaman

| # | Celah di referensi | Perbaikan di produk ini |
|---|---|---|
| G1 | Menu *Informasi* (Berita, Foto, Agenda, Infografis, Video) pada footer masih bertaut `#` pada hasil ambil halaman — tampak belum terhubung | Modul konten benar-benar berfungsi dan diisi lewat admin (FR-20 s.d. FR-23, FR-45) |
| G2 | Tombol "Pengaduan" langsung melempar keluar tanpa penjelasan | Halaman **Saluran Pelaporan** yang menjelaskan kanal, apa yang perlu disiapkan pelapor, dan jam layanan (FR-05) |
| G3 | Tidak terlihat daftar layanan CSIRT, jam layanan, atau SLA | Halaman **Katalog Layanan** dengan target waktu respons (FR-04) |
| G4 | Tidak terlihat kontak keamanan (email khusus, kunci PGP, `security.txt`) | Halaman **Kontak Keamanan** + `/.well-known/security.txt` dari pengaturan (FR-06) |
| G5 | Tidak terlihat peringatan keamanan / advisori untuk OPD | Modul **Advisori & Peringatan Dini** (FR-30, FR-31) |
| G6 | Konten "Profil" tidak terbaca di hasil ambil halaman | Profil tim, struktur, dan **Agen Siber per OPD** ditampilkan jelas (FR-02, FR-03) |
| G7 | Ketergantungan pada developer untuk mengubah isi | **CMS ala WordPress**: halaman berblok, menu, pengaturan, semua dari admin (FR-42 s.d. FR-46) |

> **Catatan batasan kajian:** saya hanya membaca halaman beranda dan halaman RFC-2350 sebagai teks. Warna, tipografi, dan perilaku interaksi situs referensi **tidak** terbaca, sehingga `DESIGN.md` adalah rancangan baru, bukan salinan tampilan CSIRT Sumbar.

---

## 3. Latar belakang kebijakan

- BSSN membentuk dan membina CSIRT kabupaten/kota; unit kerja yang menangani CSIRT di pemerintah daerah adalah **Diskominfo**.
- Pendaftaran CSIRT sektor pemerintah ke BSSN mensyaratkan antara lain dokumen **RFC-2350**, profil dan layanan CSIRT, struktur organisasi, serta SK pembentukan. Dokumen RFC-2350 dipublikasikan pada website CSIRT.
- Kajian implementasi CSIRT di pemerintah daerah (studi kasus Tangsel) merekomendasikan pengembangan **website resmi CSIRT**, peningkatan literasi keamanan siber, dan SOP yang mengikat — tiga hal yang dijawab langsung oleh produk ini.

Sumber ada di bagian 17.

---

## 4. Tujuan & metrik keberhasilan

### 4.1 Tujuan

1. **Legitimasi & transparansi** — profil, mandat, layanan, dan RFC-2350 yang bisa diverifikasi publik.
2. **Jelas cara melapor** — pengunjung tahu ke mana dan bagaimana melapor insiden dalam kurang dari 30 detik.
3. **Edukasi** — meningkatkan literasi keamanan siber ASN dan warga Pariaman lewat berita, advisori, dan materi edukasi.
4. **Mandiri** — tim CSIRT mengelola seluruh isi situs sendiri, tanpa developer.

### 4.2 Metrik (target dievaluasi 3 bulan setelah rilis)

| Metrik | Target awal |
|---|---|
| Waktu admin menerbitkan satu berita/advisori, dari buka panel sampai tayang | ≤ 5 menit |
| Teks situs yang bisa diubah admin tanpa developer (di luar label antarmuka tetap) | 100% |
| Pengunjung menemukan tombol dan halaman **Saluran Pelaporan** (uji dengan 5 orang non-teknis) | ≥ 4 dari 5 dalam 30 detik |
| Skor Lighthouse (Performance / Accessibility / SEO) di mobile | ≥ 90 / ≥ 95 / ≥ 90 |
| Konten baru (berita/edukasi/advisori) terbit | ≥ 2 per bulan |
| OPD yang agen sibernya tercantum | 100% |

Semua target di atas adalah usulan awal, bukan angka dari data yang ada — sesuaikan dengan kapasitas tim.

---

## 5. Pengguna

### 5.1 Pembaca (publik, hanya membaca)

| Persona | Kebutuhan | Pain point |
|---|---|---|
| **Warga / pelapor umum** | Tahu harus melapor ke mana jika situs pemerintah diretas, ada hoaks atau penipuan mengatasnamakan pemko | Tidak tahu kanal; takut prosedur rumit |
| **ASN / Agen Siber OPD** | Kontak darurat, advisori, panduan dan dokumen | Informasi tersebar di grup chat |
| **Pimpinan OPD** | Memahami layanan CSIRT dan siapa agen siber OPD-nya | Tidak ada satu tempat rujukan |
| **Auditor / asesor (BSSN, Inspektorat)** | Memverifikasi RFC-2350, struktur, dan layanan | Dokumen tidak mudah ditemukan |
| **Peneliti keamanan** | Kontak dan kebijakan pengungkapan kerentanan | Tidak ada kontak resmi |

### 5.2 Pengelola (admin)

| Peran | Wewenang |
|---|---|
| **Super Admin** | Semuanya, termasuk pengguna, peran, dan pengaturan teknis |
| **Koordinator** | Semua konten, menu, pengaturan situs, banner darurat, penerbitan |
| **Analis** | Advisori, dokumen, katalog layanan |
| **Editor** | Halaman, berita/edukasi, agenda, galeri (tidak bisa mengubah menu dan pengaturan) |

Matriks izin rinci ada di `CMS-SPEC.md`.

---

## 6. Ruang lingkup

### 6.1 Termasuk (In scope)

Situs publik (hanya baca), panel admin untuk seluruh konten, halaman berblok ala WordPress, pengelola menu, pengaturan situs, modul advisori/berita/dokumen/layanan/agen/agenda/galeri, status draf-terbit-terjadwal dengan pratinjau, serta log audit.

### 6.2 Di luar lingkup

- Form apa pun yang dikirim pengunjung (lapor insiden, hubungi kami, komentar, langganan).
- Sistem tiket dan pelacakan insiden. Dapat dipertimbangkan kembali di fase mendatang bila kanal yang ada tidak mencukupi.
- Platform SIEM/SOC atau dasbor pemantauan teknis.
- Aplikasi mobile native.
- Pustaka media penuh ala WordPress (unggah per kolom dulu; lihat FR-49 dan fase 3).
- Integrasi dengan sistem BSSN.

---

## 7. Sitemap & arsitektur informasi

```
Beranda (halaman berblok, dapat disusun admin)
├─ Profil
│   ├─ Tentang CSIRT Pariaman
│   ├─ Visi, Misi, Mandat
│   ├─ Struktur Organisasi
│   └─ Agen Siber OPD
├─ Layanan
│   ├─ Katalog Layanan (reaktif · proaktif · kualitas keamanan)
│   └─ Alur Penanganan Insiden
├─ Informasi
│   ├─ Advisori & Peringatan Dini
│   ├─ Berita
│   ├─ Edukasi (artikel, infografis, video)
│   ├─ Agenda
│   └─ Galeri
├─ Dokumen
│   ├─ RFC-2350
│   └─ Regulasi, SOP, Panduan
├─ Kontak
│   ├─ Kontak & Alamat
│   └─ Kontak Keamanan (PGP, security.txt, kebijakan pengungkapan)
└─ Saluran Pelaporan  ← tujuan tombol "Lapor Insiden" di header
```

Navigasi utama dibatasi **enam butir**: *Beranda, Profil, Layanan, Informasi, Dokumen, Kontak*. **Lapor Insiden** tampil sebagai tombol aksi menonjol di header. Struktur menu dapat diubah admin (FR-43), dan halaman di luar daftar ini dapat dibuat admin kapan saja (FR-42).

---

## 8. Kebutuhan fungsional

Prioritas memakai MoSCoW: **M** = wajib fase 1, **S** = sebaiknya fase 1–2, **C** = bisa ditunda, **W** = tidak sekarang.

### 8.1 Situs publik (hanya baca)

| ID | Kebutuhan | Prioritas | Kriteria penerimaan |
|---|---|---|---|
| FR-01 | **Beranda** tersusun dari blok yang diatur admin: hero, tiga langkah, kartu layanan, advisori terbaru, portal layanan, berita terbaru, kontak darurat | M | Admin dapat menambah, menghapus, dan mengurutkan blok tanpa developer |
| FR-02 | **Halaman dinamis** (`/{slug}`): Profil, Visi-Misi, Kebijakan Privasi, dan halaman baru apa pun, termasuk halaman bertingkat | M | Halaman berstatus draf tidak terlihat publik; halaman tidak ada menghasilkan 404 |
| FR-03 | **Struktur & Agen Siber OPD**: bagan organisasi dan tabel agen per OPD (nama, OPD, jabatan, kontak resmi) | M | Dapat dicari dan difilter per OPD; datanya dari admin |
| FR-04 | **Katalog Layanan**: deskripsi, siapa yang bisa meminta, cara meminta, jam layanan, target waktu respons | M | Minimal layanan reaktif tersedia |
| FR-05 | **Saluran Pelaporan**: halaman informasi berisi kanal pelaporan (email, WhatsApp/telepon, URL helpdesk), apa yang perlu disiapkan pelapor, jam layanan, dan peringatan agar tidak mengirim kata sandi. **Tombol Lapor Insiden** di header mengarah ke tujuan yang diatur admin: halaman internal, `mailto:`, tautan WhatsApp, atau URL eksternal | M | Tujuan tombol dapat diganti dari pengaturan tanpa mengubah kode; tombol terlihat tanpa scroll di layar 360 px |
| FR-06 | **Kontak Keamanan**: email khusus, nomor darurat, jam operasional, fingerprint dan unduhan kunci publik PGP; berkas `/.well-known/security.txt` dibentuk dari pengaturan | M | Fingerprint dapat disalin satu klik; `security.txt` selalu cocok dengan pengaturan |
| FR-07 | **RFC-2350 & Dokumen**: tampil sebagai halaman web dan unduhan PDF; dokumen lain dikelompokkan per kategori | M | Memuat seluruh bagian standar RFC-2350 |
| FR-08 | **Portal Layanan Pemko**: kartu tautan ke PPID, JDIH, LPSE, PTSP, dll. | S | Kartu dapat ditambah, diubah, diurutkan dari admin |
| FR-09 | **Pencarian situs** (hanya membaca konten terbit) | S | Hasil tidak memuat konten draf |

### 8.2 Konten & advisori

| ID | Kebutuhan | Prioritas | Kriteria penerimaan |
|---|---|---|---|
| FR-20 | **Berita**: kategori, gambar sampul, ringkasan, tanggal terbit | M | Urut dari terbaru; paginasi |
| FR-21 | **Edukasi**: artikel, infografis (gambar yang bisa diunduh), video (embed YouTube) | S | Jenis konten dapat difilter |
| FR-22 | **Agenda** kegiatan (bimtek, simulasi, rakor), tampilan daftar | S | Agenda lampau dipisah dari yang akan datang |
| FR-23 | **Galeri foto** kegiatan | C | Satu album berisi banyak foto |
| FR-24 | RSS untuk berita | C | |
| FR-30 | **Advisori**: judul, tingkat keparahan (Rendah/Sedang/Tinggi/Kritis), sistem terdampak, langkah mitigasi, tanggal | M | Tingkat keparahan ditandai ikon + teks, tidak hanya warna |
| FR-31 | Daftar advisori dengan filter keparahan dan tanggal | S | |

### 8.3 Panel admin (CMS ala WordPress)

| ID | Kebutuhan | Prioritas | Kriteria penerimaan |
|---|---|---|---|
| FR-40 | **Login admin dengan 2FA wajib** (aplikasi authenticator + kode pemulihan) | M | Pengguna tanpa 2FA dipaksa mengaturnya setelah login |
| FR-41 | **Peran dan izin**: Super Admin, Koordinator, Analis, Editor | M | Editor tidak dapat membuka pengaturan atau menu; diuji otomatis |
| FR-42 | **Halaman berblok**: admin menyusun halaman dari blok (judul, teks kaya, gambar, tombol, kartu layanan, daftar dokumen, tabel agen, advisori terbaru, kontak, dll.), memilih templat halaman, dan mengatur induk halaman dan slug | M | Beranda dan halaman lain dapat dibuat dan diubah tanpa developer |
| FR-43 | **Pengelola menu**: menu header dan footer; butir menaut ke halaman, berita, atau URL; urutan dengan tarik-lepas; satu tingkat submenu | M | Perubahan langsung tampil di situs |
| FR-44 | **Pengaturan situs**: nama dan logo, kontak, jam layanan, PGP, media sosial, teks footer, **tujuan tombol Lapor Insiden**, teks hero, banner darurat (aktif/mati, teks, tingkat) | M | Tidak ada nilai kontak yang tertanam di kode |
| FR-45 | **CRUD konten**: Berita/Edukasi, Advisori, Dokumen, Layanan, Agen, Agenda, Galeri, Portal Layanan | M | Setiap jenis punya daftar, pencarian, filter, dan formulir ubah |
| FR-46 | **Status draf / terbit / terjadwal** dan **pratinjau draf** | M | Konten terjadwal tayang otomatis pada waktunya tanpa langkah manual |
| FR-47 | **Log audit**: siapa mengubah apa dan kapan | M | Tidak dapat diubah dari panel |
| FR-48 | **Banner darurat** dari pengaturan (mis. "Layanan X sedang terganggu") | S | Tampil di semua halaman bila aktif |
| FR-49 | **Unggah berkas aman**: tipe dan ukuran dibatasi, nama diacak, disimpan di disk terkontrol | M | Berkas di luar tipe yang diizinkan ditolak |
| FR-50 | **Riwayat perubahan halaman** dan pemulihan versi | C | |
| FR-51 | **Pustaka media** terpusat (unggah sekali, pakai di banyak tempat) | C | |

### 8.4 Fitur umum

| ID | Kebutuhan | Prioritas |
|---|---|---|
| FR-52 | Halaman 404 / 500 informatif dengan jalan pintas ke Saluran Pelaporan | M |
| FR-53 | RFC-2350 versi bahasa Inggris | C |
| FR-54 | Cache halaman publik yang dibersihkan otomatis saat admin menyimpan | S |

---

## 9. Kebutuhan non-fungsional

### 9.1 Keamanan (kritis — ini situs tim keamanan)

Keputusan "semua input dari admin" membuat permukaan serangan jauh lebih kecil: **satu-satunya titik masuk data adalah login admin.** Beban keamanan bergeser ke akun admin dan konten yang mereka masukkan.

- HTTPS wajib, HSTS aktif, TLS versi modern.
- Header keamanan pada rute publik: CSP ketat, `X-Content-Type-Options`, `Referrer-Policy`, `Permissions-Policy`, `frame-ancestors`.
- **Akun admin**: 2FA wajib, kata sandi di-hash modern, sesi dengan batas waktu, **pembatasan percobaan login**, path panel tidak lazim, dan bila memungkinkan dibatasi IP atau VPN.
- **Teks kaya** dari admin dibersihkan (sanitasi HTML) sebelum ditampilkan, dan CSP memblokir skrip inline sebagai lapisan kedua. Akun admin yang dibobol tidak boleh bisa menyisipkan skrip ke pengunjung.
- Unggahan admin: tipe dan ukuran dibatasi, nama diacak, tidak pernah dieksekusi.
- Tautan keluar diberi `rel="noopener"`; embed video memakai domain yang diizinkan saja.
- Semua input admin divalidasi di server; perlindungan CSRF, XSS, SQL injection.
- **Backup** harian basis data dan `storage/` dengan uji pemulihan berkala.
- Uji penetrasi atau tinjauan keamanan sebelum rilis publik. Situs CSIRT yang diretas akan merusak kepercayaan pada seluruh program.
- Karena situs tidak mengumpulkan data pengunjung, kebijakan privasi cukup menjelaskan log akses dan analitik agregat.

### 9.2 Kinerja & ketersediaan

- LCP < 2,5 detik di jaringan seluler 4G umum.
- Karena isi jarang berubah, halaman publik di-cache dan dibersihkan otomatis saat admin menyimpan (FR-54).
- Gambar dioptimalkan (WebP/AVIF), font ditanam sendiri agar tidak bergantung CDN pihak ketiga.
- Ketersediaan target 99,5% per bulan di luar pemeliharaan terjadwal.

### 9.3 Aksesibilitas

- Mengacu **WCAG 2.2 level AA**.
- Navigasi penuh dengan keyboard, fokus terlihat jelas, teks alternatif untuk gambar (kolom wajib saat admin mengunggah), pesan galat yang terbaca pembaca layar.
- Rasio kontras warna terverifikasi di `DESIGN.md`.

### 9.4 SEO & berbagi

- Metadata Open Graph per halaman (judul, deskripsi, gambar dapat diatur admin), sitemap XML, `robots.txt`, URL ramah-baca.
- Struktur heading logis (satu `h1` per halaman).

### 9.5 Kompatibilitas

- Desain *mobile-first*; diuji pada lebar 360, 768, 1024, 1440 px.
- Browser: dua versi mayor terakhir Chrome, Edge, Firefox, Safari, serta Chrome Android.

---

## 10. Alur pengguna utama

### 10.1 Warga menemukan cara melapor (membaca)

1. Dari halaman mana pun, tekan **Lapor Insiden** di header.
2. Tombol membuka tujuan yang diatur admin (halaman Saluran Pelaporan, atau langsung email/WhatsApp/helpdesk).
3. Di halaman Saluran Pelaporan, pengunjung melihat kanal, jam layanan, dan daftar hal yang perlu disiapkan (alamat situs, waktu kejadian, tangkapan layar), serta peringatan agar tidak mengirim kata sandi.
4. Pengunjung melapor lewat kanal pilihan di luar situs.

### 10.2 Editor menerbitkan berita

1. Masuk ke panel dengan 2FA → **Berita → Tambah**.
2. Isi judul, kategori, sampul (dengan teks alternatif), isi.
3. Simpan sebagai **draf**, buka **pratinjau**, lalu atur **terbit sekarang** atau **terjadwal**.
4. Berita tayang; cache halaman terkait dibersihkan otomatis.

### 10.3 Analis menerbitkan advisori

Buat advisori → pilih keparahan dan sistem terdampak → tulis mitigasi → pratinjau → terbit. Perubahan dicatat di log audit.

### 10.4 Koordinator mengubah beranda, menu, dan banner darurat

Panel → **Halaman → Beranda** → susun ulang blok → simpan. Panel → **Menu** → ubah urutan. Panel → **Pengaturan** → aktifkan banner darurat dan ubah tujuan tombol Lapor Insiden bila kanal berubah.

---

## 11. Model data ringkas

| Entitas | Atribut utama |
|---|---|
| **User** | nama, email, peran, status 2FA, login terakhir |
| **Page** | judul, slug, induk, templat, blok (JSON), status, terbit pada, SEO (judul, deskripsi, gambar), apakah beranda |
| **Post** | jenis (berita/edukasi), judul, slug, ringkasan, isi, sampul + teks alternatif, kategori, status, terbit pada |
| **Category** | nama, slug, jenis |
| **Advisory** | judul, slug, keparahan, ringkasan, sistem terdampak, mitigasi, status, terbit pada |
| **Document** | judul, kategori (RFC-2350/regulasi/SOP/panduan), berkas, versi, bahasa, tanggal berlaku, status |
| **Service** | nama, kelompok (reaktif/proaktif/kualitas), deskripsi, siapa yang bisa meminta, cara meminta, jam layanan, target respons, urutan |
| **Agent** | nama, OPD, jabatan, kontak resmi, foto, status aktif |
| **Event** | judul, mulai/selesai, lokasi, deskripsi, status |
| **Gallery** | judul, foto (banyak, dengan teks alternatif), status |
| **PortalLink** | judul, deskripsi, ikon, URL, urutan |
| **MenuItem** | menu (header/footer), label, tujuan (halaman/berita/URL), induk, urutan |
| **Setting** | kunci, nilai (kontak, PGP, banner darurat, tujuan tombol lapor, teks hero, dll.) |
| **AuditLog** | pelaku, aksi, objek, IP, waktu |

---

## 12. Konten yang harus disiapkan sebelum rilis

Konten adalah hambatan utama peluncuran situs CSIRT, bukan kode. Mulai sejak awal.

| Konten | Penanggung jawab (usulan) | Status |
|---|---|---|
| Nama resmi tim dan SK pembentukan | Diskominfo / Biro Hukum | `[ISI]` |
| Struktur organisasi dan daftar anggota tim | Diskominfo | `[ISI]` |
| Daftar Agen Siber tiap OPD | Diskominfo + OPD | `[ISI]` |
| Dokumen **RFC-2350** (ID, dan EN bila ada) | Koordinator CSIRT | `[ISI]` |
| Katalog layanan dan target respons | Koordinator CSIRT | `[ISI]` |
| **Kanal pelaporan yang dipakai** (email, WhatsApp/telepon, atau helpdesk) dan siapa yang memantaunya | Koordinator CSIRT | `[ISI]` |
| Email keamanan, nomor darurat, jam layanan | Diskominfo | `[ISI]` |
| Pasangan kunci PGP dan fingerprint | Analis senior | `[ISI]` |
| Kebijakan privasi dan kebijakan pengungkapan kerentanan | Diskominfo / Biro Hukum | `[ISI]` |
| Logo resmi Pemko Pariaman dan pedoman identitas visual | Diskominfo | `[ISI]` |
| Minimal 5 konten edukasi awal | Tim CSIRT | `[ISI]` |

**Struktur RFC-2350** yang dianjurkan dimuat di halaman: (1) Informasi dokumen, (2) Informasi kontak, (3) Piagam/mandat: misi, konstituen, otoritas, (4) Kebijakan: jenis insiden, kerja sama dan pengungkapan informasi, komunikasi dan autentikasi, (5) Layanan: reaktif dan proaktif, (6) Informasi pelaporan insiden (kanal, bukan form), (7) Disclaimer.

---

## 13. Integrasi & infrastruktur

| Kebutuhan | Catatan |
|---|---|
| **Penyimpanan berkas** | Disk server atau object storage; berkas publik (gambar, PDF) di disk `public`, berkas lain di disk privat |
| **Email (SMTP)** | Hanya untuk reset kata sandi dan kode 2FA email bila dipakai; domain pemko dengan SPF/DKIM/DMARC |
| **Analitik** | Analitik yang menghormati privasi (tanpa cookie lintas situs); hanya agregat |
| **Hosting** | Pusat data pemerintah daerah/PDN bila tersedia; jika tidak, VPS dengan hardening dan firewall `[ISI]` |
| **Tautan keluar** | PPID, JDIH, LPSE, PTSP, portal Pemko lain, dan kanal pelaporan `[ISI: URL resmi]` |

### 13.1 Tech stack (keputusan)

Stack berikut dipilih untuk fase 1. Alternatif (mis. Next.js seperti situs referensi dengan headless CMS) ditolak karena berarti mengelola dua sistem untuk tim yang kecil. WordPress sendiri tidak dipilih karena stack yang disepakati adalah Laravel; Filament memberi pengalaman admin yang sepadan.

| Lapisan | Pilihan | Catatan |
|---|---|---|
| Framework | **Laravel 13** (PHP **8.3+**) | Dukungan perbaikan keamanan hingga 17 Maret 2028 (dokumen Laravel) |
| Web server | Nginx + PHP-FPM, Ubuntu LTS | |
| Basis data | MySQL/MariaDB **atau** PostgreSQL | Pilih yang bisa dirawat tim ops Diskominfo; jenis yang sama di pengembangan dan produksi |
| Tampilan publik | Blade + Tailwind CSS v4 + Alpine.js | Dirender di server; tanpa Inertia/React. Hanya baca |
| Panel admin (CMS) | **Filament 5** | Resource per jenis konten, editor teks kaya, *Builder* untuk halaman berblok, unggah berkas, pengaturan situs |
| Peran & izin | `spatie/laravel-permission` | Super Admin, Koordinator, Analis, Editor (FR-41) |
| 2FA admin | MFA bawaan Filament, diwajibkan (`isRequired: true`) | App authenticator + kode pemulihan (FR-40) |
| Log audit | `spatie/laravel-activitylog` | FR-47 |
| Sanitasi HTML | `ezyang/htmlpurifier` | Untuk teks kaya sebelum ditampilkan; tanpa paket ini teks ditampilkan sebagai teks biasa (aman secara bawaan) |
| Header keamanan | Middleware `PublicSecurityHeaders` pada rute publik | CSP ketat, tidak dipasang pada panel admin |
| Antrean & cache | Redis; database bila trafik kecil | Bila server lebih dari satu, semua server memakai satu cache bersama (syarat MFA Filament) |
| Font | Self-hosted lewat paket `@fontsource/*` | Tanpa CDN pihak ketiga |
| Kualitas kode | Pest, Larastan, Pint, `composer audit` di CI | |
| Deploy | Instalasi langsung atau Docker Compose; GitHub Actions | |

Dihapus dibanding v0.1 karena tidak ada input publik: CAPTCHA (Turnstile/hCaptcha), honeypot, dan pemindaian unggahan ClamAV.

**Dampak ke hosting:** server produksi harus menjalankan **PHP 8.3 atau lebih baru**. Konfirmasi ini ke Diskominfo sebelum Fase 1 dimulai (lihat pertanyaan terbuka no. 5).

---

## 14. Rencana rilis

| Fase | Isi | Kriteria selesai |
|---|---|---|
| **Fase 0 — Persiapan** | Konfirmasi nama tim, SK, kanal pelaporan; kumpulkan konten pada bagian 12; tetapkan domain dan hosting | Semua `[ISI]` kritis terjawab |
| **Fase 1 — MVP** | FR-01 s.d. FR-08, FR-20, FR-30, FR-40 s.d. FR-47, FR-49, FR-52 | Tim dapat mengisi dan menerbitkan semua konten sendiri; RFC-2350 terpublikasi; lolos uji keamanan |
| **Fase 2 — Penguatan** | FR-09, FR-21, FR-22, FR-31, FR-48, FR-54 | Pencarian, edukasi, agenda, banner darurat, dan cache berjalan |
| **Fase 3 — Pengembangan** | FR-23, FR-24, FR-50, FR-51, FR-53; kajian apakah perlu form pelaporan atau tiket | Sesuai kebutuhan hasil evaluasi |

Estimasi waktu sengaja tidak saya cantumkan karena bergantung pada ukuran tim dan kesiapan konten.

---

## 15. Risiko

| Risiko | Dampak | Mitigasi |
|---|---|---|
| Konten (SK, RFC-2350, struktur tim) tidak siap | Rilis tertunda | Mulai Fase 0 segera; gunakan templat dari CSIRT daerah lain sebagai acuan struktur |
| **Akun admin dibobol** | Konten situs CSIRT diubah, tautan berbahaya disisipkan | 2FA wajib, path panel tidak lazim, batas IP/VPN, log audit, sanitasi HTML, CSP |
| Situs CSIRT sendiri diretas | Hilang kepercayaan | Bagian 9.1; uji penetrasi; patch rutin; backup |
| **Kanal pelaporan tidak dipantau** (email/WhatsApp tanpa penanggung jawab) | Laporan nyata terabaikan | Tetapkan penanggung jawab dan jam pantau sebelum rilis; tampilkan jam layanan jujur di situs |
| Tim kecil, situs tidak diperbarui | Konten usang | Jadwal editorial sederhana; target 2 konten per bulan; peran editor jelas |
| Admin terlalu bebas menyusun blok sehingga tampilan tidak konsisten | Desain berantakan | Blok dibatasi pada komponen design system; tidak ada HTML/CSS bebas |
| Ketergantungan satu orang pengembang | Risiko keberlanjutan | Dokumentasi, repositori terpusat, serah terima ke Diskominfo |
| Server produksi belum mendukung PHP 8.3+ | Laravel 13 tidak dapat dipasang | Konfirmasi versi PHP di Fase 0; siapkan opsi Docker atau upgrade server |

---

## 16. Pertanyaan terbuka

1. Apakah Pariaman sudah memiliki SK dan sudah terdaftar di BSSN? Jika belum, apakah situs ini sekaligus menjadi bagian dari berkas pendaftaran?
2. **Kanal pelaporan apa yang akan dipakai** (email, WhatsApp, telepon, atau helpdesk yang sudah ada), dan siapa yang memantaunya?
3. Jam layanan: 24/7, atau jam kerja saja? Ini menentukan teks di halaman Saluran Pelaporan.
4. Siapa yang berwenang menerbitkan advisori dan berita (siapa memegang peran Koordinator)?
5. Di mana situs akan di-hosting, siapa yang mengelola server, dan apakah server mendukung PHP 8.3+ (syarat Laravel 13)?
6. Apakah ada pedoman identitas visual resmi Pemko Pariaman (logo, warna) yang wajib dipakai? (`DESIGN.md` memakai palet usulan sampai ini dikonfirmasi.)
7. Apakah email keamanan khusus (mis. `csirt@…`) sudah ada atau perlu dibuat?
8. Apakah RFC-2350 versi bahasa Inggris diperlukan pada fase awal?

---

## 17. Sumber

- Situs referensi: [CSIRT Sumatera Barat](https://csirt.sumbarprov.go.id/) dan [halaman RFC-2350-nya](https://csirt.sumbarprov.go.id/pages/rfc-2350)
- [Pembentukan CSIRT — BSSN (materi, via CSIRT Ombudsman)](https://csirt.ombudsman.go.id/./assets/event/2_-PEMBENTUKAN-CSIRT-Ombudsman_sign.pdf): tujuan RFC-2350, unit kerja pengelola CSIRT di pemda
- [Mekanisme Pendaftaran CSIRT Sektor Pemerintah — BSSN](https://csirt.ombudsman.go.id/./assets/event/3_-MEKANISME-PENDAFTARAN-CSIRT_sign.pdf): syarat berkas pendaftaran
- [BSSN luncurkan CSIRT pemerintah daerah — GovInsider](https://govinsider.asia/indo-en/article/bssn-luncurkan-tim-tanggap-insiden-siber-csirt-pemerintah-daerah)
- [Implementasi kebijakan CSIRT pemda, studi kasus Tangsel — UNTIRTA (2025)](https://eprints.untirta.ac.id/53507)
- Tech stack: [Laravel 13 — rilis dan dukungan](https://laravel.com/docs/13.x/releases), [Filament 5 — instalasi](https://filamentphp.com/docs/5.x/introduction/installation.md) dan [multi-factor authentication](https://filamentphp.com/docs/5.x/users/multi-factor-authentication.md), [Spatie laravel-permission](https://spatie.be/docs/laravel-permission/installation-laravel), [Spatie laravel-activitylog](https://spatie.be/index.php/docs/laravel-activitylog/v5/installation-and-setup)
- [Peluncuran Mojokerto CSIRT — ANTARA Jatim](https://jatim.antaranews.com/berita/655445/pemkot-mojokerto-proteksi-data-melalui-csirt) dan [Kota Serang — ANTARA Banten](https://banten.antaranews.com/berita/265284/cegah-kejahatan-siber-diskominfo-kota-serang-buat-program-csirt): contoh pola penamaan dan pembentukan CSIRT kota
