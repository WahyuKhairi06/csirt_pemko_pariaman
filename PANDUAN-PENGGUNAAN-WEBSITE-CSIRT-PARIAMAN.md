# Buku Panduan Penggunaan Website CSIRT Kota Pariaman

**Versi:** 1.0  
**Tanggal:** 26 Oktober 2026  
**Status:** Panduan operasional berdasarkan fitur yang tersedia di aplikasi

## 1. Tentang Panduan Ini

Panduan ini menjelaskan cara menggunakan website publik CSIRT Kota Pariaman dan mengelola kontennya melalui panel administrasi. Panduan ditujukan untuk masyarakat, ASN/OPD, editor konten, analis, koordinator, dan superadmin.

Website publik bersifat baca saja. Pengunjung dapat membaca informasi tanpa membuat akun atau masuk. Pelaporan insiden dilakukan melalui kanal resmi yang ditampilkan di website; situs ini tidak menyediakan formulir untuk mengirim laporan.

> **Penting:** Aplikasi masih menggunakan sejumlah placeholder [ISI: ...]. Pastikan seluruh konten, kontak, tautan, dokumen, dan identitas resmi telah dikonfirmasi sebelum situs dipublikasikan sebagai portal resmi.

## 2. Mengenal Jenis Akses

| Pengguna | Cara akses | Keterangan |
|---|---|---|
| Pengunjung publik | Tanpa login | Dapat membaca halaman publik. Dalam aplikasi disebut guest dan tidak memiliki role Spatie. |
| Superadmin | Login ke panel Filament | Memiliki akses pengelolaan menyeluruh, termasuk akun dan role. |
| Koordinator | Login ke panel Filament | Mengelola konten dan pengaturan sesuai izin yang diberikan. |
| Analis | Login ke panel Filament | Mengelola materi operasional keamanan yang diizinkan, seperti advisori, dokumen, dan layanan. |
| Editor | Login ke panel Filament | Mengelola halaman, berita/edukasi, kategori, dan agenda sesuai izin. |
| user | Login tidak memberi akses panel | Role standar yang tidak dapat masuk ke panel admin. Role ini bukan pengunjung publik. |

> Hak akses di atas mengikuti konfigurasi aplikasi saat panduan dibuat. Guest bukan role Spatie. Pemberian role harus dilakukan oleh petugas yang berwenang dan mengikuti kebijakan organisasi.

## 3. Panduan untuk Pengunjung Publik

### 3.1 Membaca informasi

Gunakan navigasi utama untuk membuka halaman profil, layanan, dokumen, berita, edukasi, agenda, advisori, agen siber, saluran pelaporan, dan kontak yang tersedia. Sebagian halaman bersumber dari konten yang dikelola admin; informasi yang belum disetujui dapat masih berupa placeholder.

### 3.2 Menemukan layanan

1. Buka halaman **Layanan** atau bagian layanan di Beranda.
2. Pilih layanan yang sesuai.
3. Baca sasaran pemohon, mekanisme permohonan, jam layanan, serta target respons yang tercantum.
4. Ikuti kanal permohonan resmi yang ditampilkan.

### 3.3 Membaca advisori keamanan

1. Buka **Advisori Keamanan**.
2. Gunakan filter tingkat keparahan bila tersedia.
3. Buka advisori untuk membaca sistem terdampak, ringkasan ancaman, dan langkah mitigasi.
4. Sampaikan advisori kepada pengelola sistem terkait sesuai prosedur instansi.

### 3.4 Mengunduh dokumen

1. Buka **Dokumen & RFC-2350**.
2. Cari dokumen berdasarkan judul atau kategori yang ditampilkan.
3. Buka atau unduh berkas dari tautan dokumen.
4. Pastikan versi dan tanggal berlakunya sesuai kebutuhan.

### 3.5 Mencari agen siber OPD

1. Buka **Agen Siber OPD**.
2. Pilih atau cari nama OPD pada filter.
3. Gunakan kontak kedinasan yang tercantum untuk koordinasi.

### 3.6 Melaporkan insiden

1. Pilih tombol **Lapor Insiden** atau buka **Saluran Pelaporan**.
2. Ikuti petunjuk dan kanal yang ditampilkan. Tombol dapat membuka halaman internal, email, WhatsApp, atau portal eksternal sesuai pengaturan resmi.
3. Siapkan informasi yang diminta pada daftar periksa.
4. Jangan mengirim kata sandi, token autentikasi, atau kode OTP.

> Website tidak menerima laporan melalui formulir dan tidak menyediakan pelacakan tiket. Pastikan tujuan kanal pelaporan telah diverifikasi oleh Diskominfo sebelum digunakan.

## 4. Masuk ke Panel Administrasi

1. Buka alamat website dan tambahkan /panel-csirt pada alamatnya. Di komputer lokal, alamat dapat berupa http://127.0.0.1:8000/panel-csirt jika aplikasi dijalankan pada port 8000.
2. Masukkan email dan kata sandi akun staf yang diberikan melalui jalur resmi.
3. Klik **Masuk**.
4. Jika akun tidak dapat masuk, hubungi superadmin. Jangan membagikan kata sandi melalui email umum, chat publik, atau dokumen panduan.

> Jangan gunakan atau menyebarkan kredensial contoh. Pengunjung publik tidak memerlukan akun untuk membaca website.

Panel menampilkan kelompok navigasi **Konten**, **Operasional Keamanan**, dan **Navigasi & Sistem**. Menu yang terlihat bergantung pada role akun.

## 5. Alur Kerja Umum di Panel

1. Buka resource yang sesuai dari navigasi panel.
2. Pilih tindakan membuat data baru atau mengedit data yang sudah ada.
3. Isi kolom wajib dan periksa kembali ejaan, kontak, tautan, tanggal, serta status publikasi.
4. Untuk konten yang belum siap, pilih **Draf**.
5. Untuk menerbitkan, pilih **Terbit**. Waktu publikasi dapat dikosongkan untuk terbit segera atau diatur ke waktu mendatang jika kolom tersebut tersedia.
6. Simpan perubahan.
7. Gunakan tindakan **Pratinjau** jika tersedia, kemudian periksa halaman publik.

> Konten draf dan konten yang dijadwalkan untuk waktu mendatang tidak semestinya muncul bagi pengunjung sebelum waktunya. Selalu tinjau hasil pada website setelah menyimpan.

## 6. Mengelola Konten

### 6.1 Halaman dan blok beranda

Menu: **Konten → Halaman**

1. Buat halaman baru atau buka halaman yang akan diperbarui.
2. Isi judul dan slug URL. Slug hanya boleh memakai huruf kecil, angka, dan tanda hubung.
3. Pilih templat halaman dan, bila diperlukan, halaman induk.
4. Susun isi melalui **Penyusun Blok**, bukan dengan menempelkan kode HTML, CSS, atau JavaScript.
5. Gunakan blok yang tersedia, seperti Hero Banner, Teks Kaya, Advisori Terbaru, Saluran Pelaporan, Langkah-Langkah, Kartu Layanan, Berita & Edukasi Terbaru, Portal Layanan, Kontak, Daftar Dokumen, Tabel Agen Siber, Pemberitahuan, dan Tombol Aksi.
6. Atur status publikasi, simpan, lalu pratinjau.

> Hanya satu halaman yang dapat ditetapkan sebagai beranda. Jangan menghapus halaman beranda aktif sebelum menunjuk penggantinya. Tautan tombol harus menuju alamat internal yang benar atau URL http/https yang telah diverifikasi.

### 6.2 Berita dan edukasi

Menu: **Konten → Berita & Edukasi**

1. Pastikan kategori yang dibutuhkan tersedia di **Konten → Kategori**. Kategori harus sesuai dengan jenis artikel.
2. Buat artikel dan pilih tipe **Berita** atau **Edukasi**.
3. Isi judul, ringkasan, isi lengkap, dan kategori.
4. Bila menambahkan gambar sampul, gunakan JPG, PNG, atau WebP dengan ukuran maksimal 4 MB dan isi teks alternatif yang menjelaskan gambar.
5. Lampiran opsional menerima PDF, DOC/DOCX, atau XLSX hingga 20 MB.
6. Pilih **Draf** atau **Terbit**, atur waktu publikasi bila diperlukan, lalu simpan dan pratinjau.

### 6.3 Advisori keamanan

Menu: **Operasional Keamanan → Advisori Keamanan**

1. Buat advisori baru.
2. Isi judul, slug, tingkat keparahan, ringkasan ancaman, sistem terdampak, serta langkah mitigasi.
3. Gunakan nomor atau referensi kerentanan hanya jika sudah diverifikasi dari sumber yang berwenang.
4. Tinjau kembali rekomendasi teknis sebelum diterbitkan.
5. Simpan sebagai draf untuk peninjauan atau terbitkan setelah mendapat persetujuan yang berlaku.

### 6.4 Dokumen dan RFC-2350

Menu: **Operasional Keamanan → Dokumen & RFC-2350**

1. Isi judul, kategori, versi, bahasa, tanggal berlaku, dan urutan tampilan jika diperlukan.
2. Unggah PDF, DOC/DOCX, atau XLSX dengan ukuran maksimal 20 MB.
3. Pastikan dokumen telah disahkan dan tidak berisi informasi yang tidak boleh dipublikasikan.
4. Pilih status publikasi dan simpan.

### 6.5 Katalog layanan

Menu: **Operasional Keamanan → Katalog Layanan**

Isi kelompok layanan, nama, slug, deskripsi, sasaran pemohon, mekanisme permohonan, jam layanan, target waktu respons, urutan tampilan, dan status. Jangan mengisi target SLA atau jam layanan berdasarkan perkiraan; gunakan informasi yang telah disetujui.

### 6.6 Agen Siber OPD

Menu: **Operasional Keamanan → Agen Siber OPD**

Isi nama, OPD, jabatan, kontak kedinasan, urutan, dan status aktif. Foto bersifat opsional. Pastikan orang dan kontak masih bertugas serta telah menyetujui publikasi informasi tersebut.

### 6.7 Agenda

Menu: **Konten → Agenda**

Isi nama kegiatan, slug, lokasi, waktu mulai, waktu selesai, dan deskripsi. Pastikan waktu selesai tidak lebih awal dari waktu mulai. Pilih status publikasi lalu simpan.

### 6.8 Tautan portal layanan

Menu: **Navigasi & Sistem → Portal Layanan**

Isi nama portal, deskripsi singkat, ikon, URL, dan urutan. Aktifkan hanya tautan yang telah diperiksa. Tautan eksternal harus menggunakan http:// atau https:// dan mengarah ke layanan resmi yang benar.

## 7. Menu Navigasi dan Pengaturan Situs

### 7.1 Mengatur menu

Menu: **Navigasi & Sistem → Menu Navigasi**

1. Pilih lokasi **Header Navigasi Atas** atau **Footer Bawah**.
2. Isi label yang ringkas dan mudah dipahami.
3. Pilih halaman CMS atau masukkan tautan kustom yang telah diverifikasi.
4. Atur urutan dan status aktif.
5. Jika menggunakan submenu, tetapkan menu induk. Struktur dibatasi sampai satu tingkat submenu.
6. Aktifkan opsi tab baru hanya bila memang diperlukan, kemudian simpan dan periksa menu di halaman publik.

### 7.2 Mengatur identitas, kontak, dan pelaporan

Menu: **Navigasi & Sistem → Pengaturan Situs**

Pengaturan tersedia dalam tab berikut:

- **Identitas:** nama situs, slogan, judul dan subjudul hero, serta teks footer.
- **Kontak & Jam Kerja:** alamat, telepon kantor, hotline, email keamanan, dan jam layanan.
- **Keamanan & PGP:** fingerprint PGP, URL kebijakan keamanan, dan tanggal kedaluwarsa security.txt.
- **Saluran Pelaporan (CTA):** tujuan tombol **Lapor Insiden**, kartu kanal pelaporan, daftar informasi yang perlu disiapkan, dan peringatan keamanan.
- **Banner Darurat:** sakelar aktif, tingkat keparahan, dan isi pengumuman.

Ubah pengaturan hanya berdasarkan informasi yang sudah disahkan. Periksa kembali tombol **Lapor Insiden**, tautan kontak, dan banner di situs publik setelah menyimpan.

Email keamanan yang valid dapat mengaktifkan endpoint /.well-known/security.txt. Pastikan isi dan tanggalnya benar sebelum informasi tersebut dipublikasikan.

## 8. Mengelola Pengguna dan Role

Menu: **Navigasi & Sistem → Pengguna & Peran**. Pengelolaan pengguna dibatasi untuk superadmin.

1. Buat akun hanya untuk staf yang memang memerlukan akses admin.
2. Gunakan nama dan email kedinasan yang benar.
3. Tetapkan kata sandi kuat melalui proses aman dan sampaikan kepada pemilik akun secara terpisah.
4. Pilih role sesuai tugas dan hak akses minimum yang diperlukan.
5. Simpan dan pastikan pengguna dapat mengakses hanya menu yang dibutuhkan.
6. Saat staf tidak lagi bertugas, cabut aksesnya sesuai prosedur organisasi.

Role **user** adalah role akun biasa, bukan role pengunjung website. Akun dengan role tersebut tidak mendapat akses ke panel. Pengunjung publik tetap dapat membaca website sebagai guest tanpa akun. Jangan menugaskan role superadmin kepada akun rutin yang hanya mengelola konten.

Konfigurasi aplikasi saat ini mengenal role **superadmin**, **koordinator**, **analis**, **editor**, dan **user** (serta nama kompatibilitas **super-admin**). Hak akses tiap resource diberlakukan oleh aplikasi. Jika pembagian tugas organisasi berubah, minta administrator meninjau policy dan pengujian akses sebelum mengubah role.

## 9. Panduan Keamanan dan Konten

- Jangan pernah menerbitkan kata sandi, token, kode OTP, data pribadi, atau detail insiden yang belum disetujui.
- Jangan memakai informasi contoh, placeholder, atau URL tebakan sebagai informasi resmi.
- Periksa kontak, alamat, jam kerja, nomor hotline, dan tautan setiap kali sebelum publikasi.
- Gunakan berkas yang diizinkan panel. SVG tidak diterima sebagai gambar.
- Tambahkan teks alternatif pada gambar yang menyampaikan informasi.
- Hindari menempelkan HTML atau kode ke editor konten. Konten teks kaya dibersihkan oleh aplikasi.
- Pratinjau halaman pada desktop dan ponsel sebelum diterbitkan.
- Untuk kesalahan akses, perubahan role, atau masalah publikasi, hubungi superadmin; jangan mencoba melewati pembatasan akses.

## 10. Pemecahan Masalah

| Kendala | Langkah awal |
|---|---|
| Tidak dapat masuk panel | Pastikan alamat /panel-csirt benar dan akun masih aktif. Minta superadmin memeriksa role; pengunjung publik dan role user tidak dapat masuk panel. |
| Menu admin tidak terlihat | Navigasi panel bergantung pada role. Hubungi superadmin untuk memastikan akses sesuai tugas. |
| Konten belum terlihat di website | Periksa status publikasi, waktu terbit, dan apakah perubahan sudah disimpan. Pastikan halaman induk/menu menunjuk ke konten yang benar. |
| Gambar atau dokumen ditolak | Periksa jenis berkas dan ukuran maksimum yang dijelaskan pada bagian terkait. |
| Tombol pelaporan menuju tempat yang salah | Minta pengelola yang berwenang memeriksa tab **Saluran Pelaporan (CTA)** dan menguji targetnya. |
| Kontak masih berupa [ISI: ...] | Data resmi belum dimasukkan. Konfirmasikan kepada pemilik sebelum mengubahnya; jangan mengganti dengan tebakan. |

Jika masalah tetap terjadi, catat halaman/resource, tindakan terakhir, waktu kejadian, dan pesan kesalahan yang terlihat. Jangan menyertakan kata sandi atau rahasia saat meminta bantuan.

## 11. Catatan Operasional

- Jalur panel admin adalah /panel-csirt.
- Situs publik tidak menyediakan pendaftaran akun, formulir laporan, atau sistem tiket.
- Publikasi hanya dilakukan setelah informasi resmi ditinjau dan disetujui.
- Perubahan besar pada role, struktur menu, tujuan kanal pelaporan, atau konten RFC-2350 perlu ditinjau oleh pemilik fungsi terkait.
- Nama dan URL domain produksi harus mengikuti keputusan resmi pengelola domain pemerintah daerah.

## 12. Riwayat Dokumen

| Versi | Tanggal | Keterangan |
|---|---|---|
| 1.0 | 26 Oktober 2026 | Panduan awal berdasarkan fitur aplikasi dan struktur panel yang tersedia. |
