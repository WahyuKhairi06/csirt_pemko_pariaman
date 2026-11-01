# Persyaratan Produk

## P0 — wajib untuk rilis awal

### Navigasi dan tata letak

- Tampilkan identitas situs dan tautan Beranda, Profil, Informasi, Informasi Layanan, RFC-2350, Pengaduan, dan Hubungi Kami.
- Menu dropdown dapat dibuka/ditutup dengan klik/tap dan keyboard, menampilkan status fokus, serta tertutup dengan Escape.
- Pada layar sempit, sediakan menu ringkas yang dapat dibuka, ditutup, dan digunakan dengan keyboard.
- Tautan jangkar menuju bagian yang tepat dan tidak tertutup header tetap.

### Beranda

- Hero berisi judul, ringkasan, dan ajakan tindakan yang disediakan atau disetujui pemilik. Jika belum tersedia, gunakan placeholder bertanda jelas selama pengembangan.
- Berikan akses cepat menuju layanan, RFC-2350, kanal pengaduan, dan kontak.
- Sajikan tujuh kartu portal layanan yang dijelaskan di `docs/01-reference-audit.md`, setelah nama, ringkasan, dan tujuan tautannya diverifikasi.
- Kartu layanan memiliki judul, ringkasan yang dapat dibaca, tautan deskriptif, dan alternatif teks gambar.

### Halaman informasi

- Sediakan tempat untuk Profil, Informasi Layanan, RFC-2350, dan Hubungi Kami.
- Jangan mengarang kebijakan, prosedur penanganan, SLA, klasifikasi, alamat email, kontak insiden, atau isi RFC-2350.
- RFC-2350 dapat dibaca sebagai halaman HTML dan/atau diunduh dalam berkas resmi yang disetujui.
- Kanal pengaduan eksternal diberi penanda bahwa pengunjung berpindah ke situs lain.

### Footer

- Tampilkan informasi kontak, tautan kelompok informasi, tautan sosial, dan hak cipta hanya setelah diverifikasi.
- Nomor telepon menggunakan tautan `tel:` bila nomor telah dipastikan.
- Tautan eksternal membuka tujuan yang benar dan aman; gunakan indikator eksternal.

## P1 — dianjurkan

- Breadcrumb pada halaman dalam.
- Status aktif untuk menu/halaman saat ini.
- Halaman tidak ditemukan yang menyediakan jalan kembali ke Beranda.
- Metadata judul/deskripsi unik dan pratinjau tautan yang wajar.
- Carousel portal layanan dengan tombol sebelumnya/berikutnya dan indikator posisi; grid statis dapat digunakan jika lebih mudah diakses.

## P2 — perlu persetujuan dan desain tambahan

- CMS atau panel admin.
- Berita, agenda, foto, video, dan infografis dinamis.
- Pencarian situs.
- Formulir kontak atau pelaporan insiden.
- Analitik, notifikasi, atau integrasi layanan eksternal.

## Nonfungsional

- Layout responsif dan tidak bergeser/overflow pada lebar 320 px hingga layar desktop.
- Semantik HTML, kontras teks yang memadai, alt text, fokus keyboard, dan reduced motion.
- Validasi masukan bila kelak ada formulir, penanganan error yang aman, dan tidak menampilkan rahasia dalam log.
- Konten final dapat dikelola tanpa mengubah komponen layout bila arsitektur yang dipilih mendukungnya.
