# DESIGN.md — Portal CSIRT Pemerintah Kota Pariaman

Panduan desain untuk website CSIRT Pemko Pariaman. Dibaca bersama `PRD.md`. Dokumen ini ditulis agar bisa langsung dipakai pengembang atau asisten pengkodean: semua nilai berupa token yang bisa disalin ke CSS/Tailwind.

> **Status identitas visual:** palet di bawah adalah **usulan**. Pedoman identitas resmi Pemko Pariaman (logo, warna) belum tersedia bagi saya. Bila ada, ganti token `--brand-*` dan `--accent-*`, lalu jalankan ulang tabel kontras di bagian 3.3. Situs referensi (csirt.sumbarprov.go.id) tidak dapat dibaca warna dan tipografinya, jadi desain ini bukan salinan tampilannya.

---

## 1. Arah desain

**Satu kalimat:** *tenang, tepercaya, dan jelas — seperti loket pelayanan yang rapi di kota pesisir.*

CSIRT adalah layanan darurat bagi orang yang sedang cemas (situs diretas, data bocor). Tampilan tidak boleh menakut-nakuti, tetapi juga tidak boleh terkesan main-main. Pengguna harus tahu dalam 3 detik: *ini situs resmi pemerintah* dan *di mana tombol untuk melapor*.

### 1.1 Prinsip

1. **Aksi utama selalu terlihat.** Tombol *Lapor Insiden* ada di header setiap halaman dan di hero beranda.
2. **Bahasa manusia dulu, istilah teknis kedua.** "Akun dibobol" lebih dulu daripada "account compromise"; istilah teknis boleh muncul sebagai keterangan kecil.
3. **Resmi tetapi hangat.** Warna biru tua membawa kesan institusi; aksen emas membawa rasa lokal yang hangat. Tidak ada gaya "hacker" (hijau neon, latar hitam, kode jatuh).
4. **Kontras dan keterbacaan sebelum gaya.** Target WCAG 2.2 AA; semua pasangan warna teks sudah dihitung.
5. **Ringan untuk jaringan lambat.** Sedikit ilustrasi berat, font ditanam sendiri, tidak ada animasi yang menahan konten.
6. **Jangan mengandalkan warna saja.** Status dan tingkat keparahan selalu memakai ikon dan teks bersama warna.

### 1.2 Suasana & motif

- **Motif Pariaman/Minang** dipakai secukupnya: pola geometris halus (terinspirasi ukiran dan songket) sebagai tekstur latar hero dan pemisah bagian, dengan opasitas rendah. Bukan ornamen penuh.
- **Ilustrasi:** garis sederhana dan bidang datar, tanpa tokoh kartun hacker. Subjek yang disarankan: perisai, kunci, laptop, jaringan titik-garis, siluet pantai dan pohon kelapa sebagai penanda lokal.
- **Foto:** kegiatan nyata tim CSIRT dan OPD (bimtek, rapat, simulasi). Lebih baik foto jujur berkualitas biasa daripada foto stok korporat generik.

---

## 2. Teknologi gaya

- **CSS custom properties** sebagai sumber kebenaran token (bagian 11).
- Dipakai bersama **Tailwind CSS v4** (pemetaan di bagian 11.2); token tetap berupa CSS custom properties sehingga bisa dipakai tanpa Tailwind.
- **Mobile-first**; breakpoint di bagian 6.
- Ikon: **Lucide** (garis 1.75 px, sudut membulat) — konsisten, ringan, lisensi bebas.
- Font ditanam sendiri (*self-hosted*), format WOFF2, dengan `font-display: swap`.

---

## 3. Warna

### 3.1 Palet inti

| Token | Hex | Peran |
|---|---|---|
| `--navy-900` | `#0B1F3A` | Latar footer, hero gelap, teks di atas emas |
| `--brand-700` | `#0B5FA5` | **Warna utama**: tombol primer, tautan, ikon aktif |
| `--brand-900` | `#083D6E` | Hover/pressed tombol primer, tautan dikunjungi |
| `--accent-400` | `#F2B233` | Aksen emas: sorotan, tombol di atas latar navy, garis dekoratif |
| `--accent-100` | `#FDF0D0` | Latar lembut untuk sorotan/pemberitahuan netral |
| `--ink` | `#12263F` | Teks utama |
| `--muted` | `#4A5D75` | Teks sekunder, keterangan |
| `--surface` | `#F4F7FB` | Latar bagian berselang-seling, kartu |
| `--white` | `#FFFFFF` | Latar halaman, kartu |
| `--border` | `#D5DEE8` | Garis pemisah dekoratif (bukan batas kontrol form) |
| `--border-input` | `#7B8DA4` | Batas kolom input, checkbox, radio |
| `--on-navy-muted` | `#C9D6E6` | Teks sekunder di atas navy |

### 3.2 Warna status

| Status | Teks / ikon | Latar | Dipakai untuk |
|---|---|---|---|
| Sukses | `#176B3A` | `#E6F4EA` | Konfirmasi tersalin, status aktif, pesan berhasil |
| Peringatan | `#8A5300` | `#FFF4DB` | Tingkat Sedang, perhatian |
| Bahaya | `#B3261E` | `#FDECEA` | Galat (admin), tingkat Kritis |
| Info | `#0B5FA5` | `#E8F1FA` | Informasi netral |

### 3.3 Kontras terverifikasi

Rasio dihitung dengan rumus WCAG 2.x. Ambang: teks biasa ≥ 4,5:1; teks besar dan komponen UI ≥ 3:1.

| Pasangan | Rasio | Lolos |
|---|---|---|
| `--ink` di atas putih | 15,28 | ✅ AA/AAA |
| `--ink` di atas `--surface` | 14,22 | ✅ AA/AAA |
| `--ink` di atas `--accent-100` | 13,49 | ✅ AA/AAA |
| `--muted` di atas putih | 6,74 | ✅ AA |
| `--muted` di atas `--surface` | 6,28 | ✅ AA |
| Putih di atas `--brand-700` (tombol primer) | 6,57 | ✅ AA |
| Putih di atas `--brand-900` (hover tombol) | 11,04 | ✅ AA/AAA |
| `--brand-700` di atas putih (tautan) | 6,57 | ✅ AA |
| `--brand-700` di atas `--surface` | 6,12 | ✅ AA |
| `--brand-900` di atas putih | 11,04 | ✅ AA/AAA |
| Putih di atas `--navy-900` | 16,52 | ✅ AA/AAA |
| `--accent-400` di atas `--navy-900` | 8,80 | ✅ AA |
| `--navy-900` di atas `--accent-400` (teks tombol emas) | 8,80 | ✅ AA |
| `--on-navy-muted` di atas `--navy-900` | 11,20 | ✅ AA |
| Putih di atas bahaya `#B3261E` | 6,54 | ✅ AA |
| Putih di atas sukses `#176B3A` | 6,56 | ✅ AA |
| Sukses `#176B3A` di atas `#E6F4EA` | 5,78 | ✅ AA |
| Peringatan `#8A5300` di atas `#FFF4DB` | 5,79 | ✅ AA |
| Bahaya `#B3261E` di atas `#FDECEA` | 5,72 | ✅ AA |
| Info `#0B5FA5` di atas `#E8F1FA` | 5,76 | ✅ AA |
| `--border-input` di atas putih (batas kontrol) | 3,39 | ✅ UI ≥ 3:1 |

### 3.4 Pasangan yang **dilarang**

| Pasangan | Rasio | Alasan |
|---|---|---|
| `--accent-400` sebagai **teks atau ikon** di atas putih/surface | 1,88 | Gagal; emas hanya boleh sebagai latar, garis dekoratif, atau di atas navy |
| `--accent-400` di atas `--brand-700` | 3,50 | Hanya untuk elemen besar/dekoratif, bukan teks kecil |
| `--border` (`#D5DEE8`) sebagai satu-satunya batas input | 1,36 | Terlalu pucat; pakai `--border-input` |
| Cincin fokus emas di atas latar terang | 1,88 | Pakai cincin biru (lihat 9.2) |

### 3.5 Aturan pemakaian

- Komposisi kasar: **~70% putih/surface, ~20% biru & navy, ~8% teks, ≤ 2% emas.** Emas itu bumbu.
- Satu tombol primer per area pandang. Tombol emas hanya muncul di atas latar navy (hero, footer, banner).
- Latar halaman gelap penuh **tidak dipakai** pada fase 1. Mode gelap ditunda ke fase berikutnya; bila dibuat, semua rasio di atas harus dihitung ulang.

---

## 4. Tipografi

### 4.1 Keluarga font

| Peran | Font | Fallback | Alasan |
|---|---|---|---|
| **Judul** | *Plus Jakarta Sans* (600, 700, 800) | `system-ui, sans-serif` | Geometris, ramah, terbaca baik untuk bahasa Indonesia |
| **Isi** | *Inter* (400, 500, 600) | `system-ui, sans-serif` | Sangat terbaca di ukuran kecil dan di layar murah |
| **Kode / teknis** | *JetBrains Mono* (400, 500) | `ui-monospace, monospace` | Fingerprint PGP, alamat email/IP, hash |

Hanya muat bobot yang dipakai. Total font di halaman ≤ 4 berkas WOFF2.

### 4.2 Skala

Skala dasar 16 px, rasio ±1,25. Nilai fluid memakai `clamp()` agar mulus dari 360 px sampai 1440 px.

| Token | Ukuran (mobile → desktop) | Bobot | Tinggi baris | Pemakaian |
|---|---|---|---|---|
| `display` | 32 → 48 px | 800 | 1,15 | Judul hero beranda saja |
| `h1` | 28 → 38 px | 700 | 1,2 | Judul halaman |
| `h2` | 22 → 28 px | 700 | 1,25 | Judul bagian |
| `h3` | 18 → 20 px | 600 | 1,3 | Judul kartu, sub-bagian |
| `body-lg` | 18 px | 400 | 1,65 | Paragraf pembuka |
| `body` | 16 px | 400 | 1,65 | Isi utama |
| `small` | 14 px | 400 | 1,5 | Keterangan, meta |
| `caption` | 12,5 px | 500 | 1,4 | Label kecil; jangan dipakai untuk teks penting |
| `mono` | 14–15 px | 400 | 1,5 | Fingerprint, nilai kontak yang bisa disalin |

### 4.3 Aturan

- Lebar baris teks isi **maksimum 68 karakter** (±`max-width: 68ch`).
- Judul tidak terpotong dengan "…" di navigasi; boleh melipat ke dua baris.
- **Huruf kapital semua** hanya untuk label kecil (mis. "ADVISORI"), dengan `letter-spacing: 0.06em`; tidak untuk kalimat.
- Angka tabel pakai `font-variant-numeric: tabular-nums`.
- Fingerprint PGP dan nilai kanal pelaporan (email, nomor) selalu monospasi dan diberi tombol salin.

---

## 5. Spasi, radius, bayangan

### 5.1 Skala spasi (kelipatan 4 px)

`--space-1: 4px · 2: 8px · 3: 12px · 4: 16px · 5: 24px · 6: 32px · 7: 48px · 8: 64px · 9: 96px`

- Jarak vertikal antar bagian halaman: **64 px** (mobile) → **96 px** (desktop).
- Padding kartu: **20–24 px**.
- Jarak antar elemen form: **20 px**.

### 5.2 Radius

| Token | Nilai | Pemakaian |
|---|---|---|
| `--radius-sm` | 6 px | Input, badge |
| `--radius-md` | 10 px | Tombol, kartu kecil |
| `--radius-lg` | 16 px | Kartu besar, panel hero |
| `--radius-full` | 999 px | Chip, avatar |

### 5.3 Elevasi

Bayangan halus dan sedikit; batas tipis lebih diutamakan daripada bayangan tebal.

| Token | Nilai | Pemakaian |
|---|---|---|
| `--shadow-1` | `0 1px 2px rgba(11,31,58,.08)` | Kartu dalam keadaan diam |
| `--shadow-2` | `0 6px 16px rgba(11,31,58,.10)` | Kartu saat hover, dropdown |
| `--shadow-3` | `0 16px 40px rgba(11,31,58,.16)` | Modal |

---

## 6. Layout & grid

### 6.1 Breakpoint

| Nama | Lebar min | Kolom | Gutter | Margin sisi |
|---|---|---|---|---|
| `xs` (dasar) | 0 | 4 | 16 px | 16 px |
| `sm` | 640 px | 4 | 16 px | 24 px |
| `md` | 768 px | 8 | 24 px | 32 px |
| `lg` | 1024 px | 12 | 24 px | 40 px |
| `xl` | 1280 px | 12 | 32 px | auto |

Lebar maksimum kontainer: **1200 px**, dipusatkan. Teks panjang (artikel) memakai kolom isi **720 px**.

### 6.2 Header

- Tinggi **64 px** (mobile) / **72 px** (desktop), latar putih, garis bawah `--border`, lengket (*sticky*) saat gulir.
- Kiri: logo Pemko Pariaman + wordmark "CSIRT Kota Pariaman" (dua baris di mobile, satu baris di desktop).
- Tengah (desktop): **enam butir** — Beranda · Profil · Layanan · Informasi · Dokumen · Kontak.
- Kanan: tombol primer **Lapor Insiden** (ikon perisai + teks). Di mobile tombol tetap terlihat di sebelah ikon menu.
- Di atas header, **strip identitas resmi** setinggi 32 px berlatar navy: teks "Situs resmi Pemerintah Kota Pariaman" dan, bila aktif, banner darurat.

### 6.3 Footer

- Latar `--navy-900`, teks putih, teks sekunder `--on-navy-muted`.
- Empat kolom (desktop) / bertumpuk (mobile): **Tentang & kontak** (alamat, telepon, email keamanan) · **Informasi** (Berita, Advisori, Edukasi, Agenda) · **Dokumen** (RFC-2350, Regulasi, Panduan) · **Media sosial & Portal Pemko**.
- Garis emas 3 px di tepi atas footer sebagai penanda.
- Baris bawah: hak cipta Diskominfo Kota Pariaman, Kebijakan Privasi, Peta Situs.

---

## 7. Komponen

Semua komponen memiliki status: *default, hover, focus-visible, active, disabled*, ditambah *loading* dan *error* bila relevan. Target sentuh **minimal 44 × 44 px**.

### 7.1 Tombol

| Varian | Tampilan | Dipakai |
|---|---|---|
| **Primer** | Latar `--brand-700`, teks putih; hover `--brand-900` | Aksi utama: Lapor Insiden, Buka kanal |
| **Primer-emas** | Latar `--accent-400`, teks `--navy-900`; hanya di atas navy | Aksi utama di hero gelap/footer |
| **Sekunder** | Latar putih, batas 1,5 px `--brand-700`, teks `--brand-700` | Aksi pendukung |
| **Tersier** | Tanpa latar, teks `--brand-700`, garis bawah saat hover | Tautan aksi ringan |
| **Bahaya** | Latar `#B3261E`, teks putih | Hapus konten (admin) |

Ukuran: tinggi 44 (standar) · 52 (besar, di hero) · 36 (padat, hanya di panel admin). Padding horizontal 20 px, radius `--radius-md`, bobot teks 600. Ikon di kiri teks, jarak 8 px.
*Disabled*: opasitas 45% dan `aria-disabled`; jangan hanya mengandalkan warna.

### 7.2 Kartu

| Jenis | Isi | Catatan |
|---|---|---|
| **Kartu portal layanan** | Ikon 40 px, judul `h3`, deskripsi 2 baris, tautan keluar dengan ikon panah-keluar | Ada di beranda; seluruh kartu bisa diklik; tautan eksternal diberi `rel="noopener"` dan penanda visual |
| **Kartu layanan CSIRT** | Ikon, nama layanan, siapa yang bisa meminta, target respons | Di Katalog Layanan |
| **Kartu advisori** | Badge keparahan, judul, ringkasan, tanggal, sistem terdampak | Badge selalu ikon + teks |
| **Kartu berita/edukasi** | Gambar rasio 16:9, kategori, judul maks 3 baris, tanggal | Gambar punya `alt` bermakna atau kosong bila dekoratif |
| **Kartu agen/orang** | Foto bulat 64 px (opsional), nama, jabatan, OPD | Kontak hanya yang resmi |

Gaya dasar: latar putih, batas 1 px `--border`, radius `--radius-lg`, `--shadow-1`; hover mengangkat ke `--shadow-2` (transisi 150 ms). Bila kartu berada di atas latar `--surface`, batas tetap dipertahankan.

### 7.3 Badge keparahan advisori

| Tingkat | Ikon | Teks | Warna |
|---|---|---|---|
| Rendah | lingkaran-info | "Rendah" | Info (`#0B5FA5` di `#E8F1FA`) |
| Sedang | segitiga-peringatan | "Sedang" | Peringatan (`#8A5300` di `#FFF4DB`) |
| Tinggi | segitiga-peringatan + tanda seru ganda | "Tinggi" | Bahaya (`#B3261E` di `#FDECEA`) |
| Kritis | oktagon-peringatan | "Kritis" | Putih di atas `#B3261E` (terisi penuh) |

Bentuk badge: radius penuh, tinggi 28 px, teks `caption` bobot 600.

### 7.4 Kartu kanal pelaporan (inti produk — halaman Saluran Pelaporan)

Situs **tidak punya form yang dikirim pengunjung**. Pelaporan dilakukan lewat kanal yang sudah ada, dan komponen inti produk adalah kartu kanal yang membuat pengunjung langsung tahu apa yang harus dilakukan.

- **Kartu kanal:** satu kartu per kanal (Email, WhatsApp/Telepon, Helpdesk), lebar sama dalam grid 1–3 kolom. Isi: ikon 40 px, nama kanal (`h3`), nilai kanal dalam monospasi (alamat email, nomor), jam layanan (`small`), tombol primer sesuai jenis (**Kirim email**, **Buka WhatsApp**, **Buka helpdesk**) dan tombol sekunder **Salin**.
- Kanal dan urutannya **diatur admin** (lihat `CMS-SPEC.md`); kartu kanal yang dimatikan tidak tampil. Tombol **Lapor Insiden** di header memakai tujuan yang sama.
- **Daftar "Siapkan informasi ini":** daftar bercentang statis (alamat situs atau sistem, waktu kejadian, tangkapan layar, apa yang sudah dicoba). Ikon centang hanya hiasan; daftar tetap daftar `<ul>` biasa.
- **Peringatan keamanan:** kotak berlatar `--warning-bg` dengan ikon peringatan: "Jangan kirim kata sandi atau kode OTP lewat kanal apa pun." Teks `--warning`, kontras 5,79.
- **Jam layanan:** satu baris jelas, jujur. Bila di luar jam layanan, tampilkan kanal darurat.
- **Tersalin:** setelah menekan Salin, tombol berubah menjadi "Tersalin" dengan ikon centang selama 2 detik, dan toast `role="status"` muncul.

### 7.5 Langkah alur penanganan (stepper statis)

Lima langkah horizontal (vertikal di mobile) yang **menjelaskan** alur penanganan insiden: *Laporan diterima → Triase → Penanganan → Pemulihan → Penutupan*. Stepper ini informasi, bukan status tiket pengunjung. Setiap langkah: lingkaran biru bernomor, judul `h3`, satu kalimat penjelas. Tidak ada keadaan "selesai" atau "aktif" karena tidak terhubung ke data apa pun.

### 7.6 Navigasi

- **Menu desktop:** butir teks `body` bobot 500; yang aktif diberi garis bawah emas 3 px (dekoratif) **dan** teks `--brand-900` bobot 600.
- **Dropdown** (Informasi, Dokumen): panel putih, `--shadow-2`, bisa dibuka dengan keyboard (Enter/Spasi) dan ditutup dengan Esc.
- **Menu mobile:** panel layar penuh dari kanan, butir 56 px tingginya, tombol Lapor Insiden tetap di dasar panel.
- **Remah roti (*breadcrumb*)** di semua halaman kedua ke bawah.
- Tautan **"Lewati ke konten utama"** sebagai elemen fokus pertama.

### 7.7 Banner & pemberitahuan

| Jenis | Tampilan | Dipakai |
|---|---|---|
| **Banner darurat** | Strip penuh lebar di atas header; latar `--accent-100`, teks `--ink`, garis kiri emas 4 px, ikon peringatan | Gangguan layanan, kampanye penipuan aktif |
| **Notifikasi inline** | Ikon + teks pada latar status | Hasil aksi di dalam halaman |
| **Toast** | Muncul bawah-tengah, hilang otomatis 6 detik, dapat ditutup, `role="status"` | Konfirmasi ringan (mis. "Fingerprint disalin") |

### 7.8 Tabel

- Dipakai untuk daftar Agen Siber dan dokumen di situs publik; di panel admin untuk semua daftar konten.
- Header baris `--surface`, teks 600, batas bawah 1 px `--border`; baris selang-seling tidak wajib.
- Di mobile, tabel berubah menjadi **daftar kartu** (satu kartu per baris) agar tidak perlu gulir ke samping.
- Pencarian dan filter di atas tabel.

### 7.9 Blok kode / fingerprint

Latar `--surface`, batas 1 px `--border`, radius `--radius-sm`, teks monospasi, tombol **Salin** di kanan atas. Fingerprint PGP dipecah per 4 karakter dengan spasi tipis agar mudah dibaca dan dicocokkan.

### 7.10 Komponen khusus admin

Panel admin memakai komponen yang sama dengan **kepadatan lebih rapat** (tinggi kontrol 36–40 px) dan sisi bilah navigasi kiri berlatar `--navy-900`. Tampilan daftar konten: kolom Judul, Jenis/Kategori, Status (badge Draf/Terbit/Terjadwal), Penulis, Terakhir diperbarui. Penerbitan dan penghapusan memakai konfirmasi eksplisit.

---

## 8. Templat halaman

### 8.1 Beranda

1. **Strip identitas** + (opsional) banner darurat
2. **Header**
3. **Hero** (latar `--navy-900` dengan pola geometris opasitas 6–8%): judul `display` putih — usulan: "Aman bersama di ruang digital Pariaman" — satu kalimat penjelas berwarna `--on-navy-muted`, tombol **Lapor Insiden** (primer-emas) dan **Pelajari layanan** (sekunder putih). Kolom kanan: ilustrasi perisai/jaringan atau foto tim; di mobile ilustrasi dipindah ke bawah atau disembunyikan.
4. **Tiga langkah melapor** ("Siapkan informasi → Hubungi kanal pelaporan → Kami menindaklanjuti") — tiga kartu berdampingan, ikon bernomor, dengan tautan ke halaman Saluran Pelaporan. Seluruh blok ini adalah blok beranda yang dapat diubah admin.
5. **Layanan kami** — grid 3 kolom kartu layanan, tautan "Lihat semua layanan".
6. **Advisori terbaru** — tiga kartu advisori, latar `--surface`.
7. **Portal Layanan Pemko** — carousel kartu; harus bisa dioperasikan keyboard, tidak memutar sendiri (atau punya tombol jeda), dan menampilkan 1 kartu di mobile, 3–4 di desktop.
8. **Berita & edukasi** — empat kartu terbaru.
9. **Kontak darurat** — blok menonjol: nomor, email keamanan, jam layanan.
10. **Footer**

### 8.2 Halaman isi (Profil, Layanan, Dokumen)

Judul `h1` + remah roti → paragraf pembuka `body-lg` → bagian-bagian `h2` dalam kolom 720 px, dengan daftar isi samping (desktop) untuk halaman panjang seperti RFC-2350. Dokumen resmi menampilkan kotak meta: versi, tanggal berlaku, tombol **Unduh PDF**.

### 8.3 Saluran Pelaporan

Satu kolom isi 720 px di atas grid kartu kanal, tanpa sidebar. Urutan: remah roti → `h1` "Saluran Pelaporan" → paragraf pembuka ramah ("Kami bantu cek. Hubungi kami lewat kanal di bawah, tidak perlu istilah teknis.") → **kartu kanal** (bagian 7.4) → "Siapkan informasi ini" → **peringatan keamanan** → jam layanan → stepper alur penanganan (bagian 7.5) → tautan ke Kontak Keamanan untuk peneliti. Pada mobile, kartu kanal bertumpuk dan tombol **Lapor Insiden** di header tetap terlihat.

### 8.4 Daftar & detail advisori / berita

Daftar: filter di atas (keparahan, tanggal, kategori), kartu bertumpuk, paginasi. Detail: badge, judul, tanggal, kolom isi 720 px, kotak "Sistem terdampak" dan "Langkah mitigasi" yang menonjol (latar `--surface`, batas kiri biru 4 px).

### 8.5 Kontak & Kontak Keamanan

Dua kolom di desktop: kiri alamat, telepon, jam layanan, peta tertanam yang dimuat saat diklik (agar halaman ringan dan privasi terjaga); kanan blok kontak keamanan (email, fingerprint PGP dengan tombol salin, unduh kunci publik, tautan kebijakan pengungkapan, `security.txt`).

### 8.6 Halaman galat (404/500)

Pesan ramah, satu kalimat penjelas, tombol **Kembali ke beranda** dan **Lapor Insiden**. Tanpa lelucon yang meremehkan.

---

## 9. Aksesibilitas

### 9.1 Daftar wajib

- Struktur HTML semantik: `header`, `nav`, `main`, `footer`; satu `h1` per halaman, urutan heading tidak melompat.
- Semua fungsi dapat dipakai dengan **keyboard saja**; urutan Tab mengikuti urutan visual.
- Semua gambar informatif punya `alt`; ikon dekoratif memakai `aria-hidden="true"`; tombol ikon-saja punya `aria-label`.
- Kolom pencarian dan filter publik: `<label>` terkait (boleh disembunyikan secara visual dengan `sr-only`); hasil pencarian diumumkan lewat `aria-live`.
- Pembaruan dinamis (toast "Tersalin", hasil pencarian) memakai `aria-live` yang sopan (`polite`).
- Bahasa dokumen `lang="id"`; bagian berbahasa Inggris diberi `lang="en"`.
- Target sentuh ≥ 44 px; jarak antar target ≥ 8 px.
- Tidak ada konten yang hanya terlihat saat *hover*.
- Hormati `prefers-reduced-motion` dan `prefers-contrast`.
- Teks bisa diperbesar sampai 200% tanpa kehilangan fungsi.

### 9.2 Indikator fokus

Semua elemen interaktif memakai **cincin fokus 3 px `--brand-700` dengan jarak 2 px** dari tepi elemen (rasio 6,57 di atas putih). Di atas latar navy, cincin berubah menjadi **`--accent-400`** (rasio 8,80). Dilarang `outline: none` tanpa pengganti.

---

## 10. Gerak & interaksi

- Durasi: **120 ms** (mikro: hover, fokus), **200 ms** (panel, dropdown), **300 ms** (modal). Kurva `cubic-bezier(.2,.0,.0,1)`.
- Tidak ada animasi yang berulang tanpa henti, tidak ada *parallax*, tidak ada konten yang muncul setelah gulir sebagai syarat untuk bisa dibaca.
- Carousel tidak berputar otomatis; bila terpaksa, ada tombol jeda yang jelas.
- `prefers-reduced-motion: reduce` → matikan transisi non-esensial.
- Status memuat: *skeleton* sederhana untuk daftar, tidak ada keadaan "mengirim" karena situs tidak punya form.

---

## 11. Token siap pakai

### 11.1 CSS

```css
:root {
  /* Warna */
  --navy-900: #0B1F3A;
  --brand-700: #0B5FA5;
  --brand-900: #083D6E;
  --accent-400: #F2B233;
  --accent-100: #FDF0D0;
  --ink: #12263F;
  --muted: #4A5D75;
  --surface: #F4F7FB;
  --white: #FFFFFF;
  --border: #D5DEE8;
  --border-input: #7B8DA4;
  --on-navy-muted: #C9D6E6;

  --success: #176B3A;  --success-bg: #E6F4EA;
  --warning: #8A5300;  --warning-bg: #FFF4DB;
  --danger:  #B3261E;  --danger-bg:  #FDECEA;
  --info:    #0B5FA5;  --info-bg:    #E8F1FA;

  /* Tipografi */
  --font-heading: "Plus Jakarta Sans", system-ui, sans-serif;
  --font-body: "Inter", system-ui, sans-serif;
  --font-mono: "JetBrains Mono", ui-monospace, monospace;

  --text-display: clamp(2rem, 1.4rem + 2.4vw, 3rem);
  --text-h1: clamp(1.75rem, 1.4rem + 1.4vw, 2.375rem);
  --text-h2: clamp(1.375rem, 1.2rem + 0.7vw, 1.75rem);
  --text-h3: clamp(1.125rem, 1.05rem + 0.3vw, 1.25rem);
  --text-body-lg: 1.125rem;
  --text-body: 1rem;
  --text-small: 0.875rem;
  --text-caption: 0.78rem;

  /* Spasi */
  --space-1: 4px;  --space-2: 8px;  --space-3: 12px; --space-4: 16px;
  --space-5: 24px; --space-6: 32px; --space-7: 48px; --space-8: 64px; --space-9: 96px;

  /* Bentuk */
  --radius-sm: 6px; --radius-md: 10px; --radius-lg: 16px; --radius-full: 999px;
  --shadow-1: 0 1px 2px rgba(11,31,58,.08);
  --shadow-2: 0 6px 16px rgba(11,31,58,.10);
  --shadow-3: 0 16px 40px rgba(11,31,58,.16);

  /* Layout */
  --container: 1200px;
  --prose: 720px;

  /* Gerak */
  --ease: cubic-bezier(.2, 0, 0, 1);
  --dur-1: 120ms; --dur-2: 200ms; --dur-3: 300ms;
}

body {
  background: var(--white);
  color: var(--ink);
  font: 400 var(--text-body)/1.65 var(--font-body);
}

:focus-visible {
  outline: 3px solid var(--brand-700);
  outline-offset: 2px;
}
.on-navy :focus-visible { outline-color: var(--accent-400); }

@media (prefers-reduced-motion: reduce) {
  * { transition: none !important; animation: none !important; }
}
```

### 11.2 Pemetaan Tailwind CSS v4

Proyek memakai Tailwind v4 (konfigurasi CSS-first, tanpa `tailwind.config.js`). Pemetaan lengkap ada di `assets/theme.css`; inti idenya: warna memakai `@theme inline` agar utilitas merujuk ke variabel di `tokens.css`.

```css
/* resources/css/app.css */
@import "tailwindcss";
@import "./tokens.css";
@import "./theme.css";

/* theme.css (cuplikan) */
@theme inline {
  --color-brand-700: var(--brand-700);
  --color-navy-900: var(--navy-900);
  --color-ink: var(--ink);
  /* ...selengkapnya di assets/theme.css */
}
@theme {
  --font-heading: "Plus Jakarta Sans", system-ui, sans-serif;
  --radius-md: 10px;
}
```

Hasilnya utilitas seperti `bg-brand-700`, `hover:bg-brand-900`, `text-on-navy-muted`, `border-line-input`, `rounded-md`, `font-heading` langsung tersedia.

### 11.3 Font self-hosted

```css
@import "@fontsource/plus-jakarta-sans/600.css";
@import "@fontsource/plus-jakarta-sans/700.css";
@import "@fontsource/plus-jakarta-sans/800.css";
@import "@fontsource/inter/400.css";
@import "@fontsource/inter/500.css";
@import "@fontsource/inter/600.css";
@import "@fontsource/jetbrains-mono/400.css";
```

Hanya bobot yang dipakai yang dimuat (sesuai bagian 4.1).

---

## 12. Suara & gaya penulisan (UX writing)

- Kalimat pendek, aktif, sapaan "Anda". Hindari singkatan yang belum dijelaskan (jelaskan "CSIRT" dan "RFC-2350" pada kemunculan pertama di tiap halaman).
- Nada tenang dan membantu, tidak menyalahkan: *"Kami bantu cek. Ceritakan apa yang terjadi."* bukan *"Anda wajib mengisi seluruh kolom."*
- Hindari bahasa menakut-nakuti ("SERANGAN BERBAHAYA!!!"). Gunakan fakta dan langkah.
- Tombol memakai kata kerja: *Lapor Insiden, Kirim email, Buka WhatsApp, Unduh PDF, Salin*.
- Pesan galat (halaman 404, panel admin) menjelaskan **apa yang salah dan cara memperbaikinya**.
- Pemberitahuan privasi singkat di dekat form: apa yang dikumpulkan, siapa yang melihat, berapa lama disimpan — tautan ke kebijakan lengkap.

**Contoh teks:**

| Tempat | Teks |
|---|---|
| Hero (judul) | Aman bersama di ruang digital Pariaman |
| Hero (penjelas) | CSIRT Kota Pariaman membantu OPD dan masyarakat menghadapi insiden keamanan siber, dari pelaporan sampai pemulihan. |
| Tombol utama | Lapor Insiden |
| Peringatan keamanan | Jangan kirim kata sandi atau kode OTP lewat kanal apa pun. |
| Judul halaman pelaporan | Saluran Pelaporan |
| Halaman 404 | Halaman ini tidak ditemukan. Mungkin alamatnya sudah berubah. |

---

## 13. Daftar periksa sebelum rilis

- [ ] Logo dan warna sudah diselaraskan dengan pedoman resmi Pemko Pariaman (atau palet usulan disetujui)
- [ ] Semua pasangan warna baru sudah dicek kontrasnya (bagian 3.3)
- [ ] Halaman Saluran Pelaporan dapat dipakai hanya dengan keyboard dan pembaca layar (tombol Salin dan tautan kanal terjangkau lewat Tab)
- [ ] Diuji di lebar 360, 768, 1024, 1440 px
- [ ] Diuji dengan zoom 200% dan mode kontras tinggi
- [ ] Lighthouse mobile: Aksesibilitas ≥ 95, Performa ≥ 85
- [ ] Font ditanam sendiri; tidak ada permintaan ke CDN pihak ketiga yang tidak perlu
- [ ] Semua tautan eksternal membuka dengan aman (`rel="noopener"`) dan diberi penanda visual
- [ ] Banner darurat dapat diaktifkan/dimatikan dari admin
- [ ] Teks halaman Saluran Pelaporan, jam layanan, dan peringatan keamanan telah ditinjau tim CSIRT

---

## 14. Referensi

- Struktur informasi mengacu pada hasil kajian [csirt.sumbarprov.go.id](https://csirt.sumbarprov.go.id/) (lihat `PRD.md` bagian 2). Gaya visual pada dokumen ini dirancang ulang, bukan disalin.
- Standar aksesibilitas: WCAG 2.2 level AA.
