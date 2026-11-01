# Design System dan Arahan Visual

## Prinsip

- Kesan layanan publik yang tenang, jelas, terpercaya, dan mudah dipindai.
- Pertahankan pola umum situs referensi—bar navigasi, area hero, portal layanan, footer—tanpa menyalin aset atau kode sumber.
- Hindari visual yang menyesatkan pengunjung seolah situs prototipe adalah portal resmi.
- Utamakan keterbacaan dan navigasi daripada dekorasi.

## Warna dan identitas

- Mulai dari palet biru sebagai warna utama, warna netral terang untuk latar, dan warna aksen untuk tindakan.
- Gunakan token CSS untuk warna, tipografi, radius, bayangan, jarak, dan lebar konten.
- Nilai warna akhir harus ditinjau terhadap kontras WCAG 2.2 AA.
- Jangan membuat ulang lambang/identitas pemerintah. Gunakan logo resmi hanya jika pemilik menyediakan aset dan izin.

## Tipografi dan layout

- Font sans-serif yang mudah dibaca; ukuran isi ideal minimal 16 px pada layar ponsel.
- Lebar konten dibatasi agar paragraf panjang nyaman dibaca.
- Gunakan skala jarak konsisten dan heading berurutan.
- Pada desktop, navigasi horizontal dapat digunakan. Pada ponsel, ubah ke menu ringkas yang jelas.

## Komponen

- Header dan navigasi dengan dropdown yang terkontrol.
- Hero dengan judul, ringkasan, dan CTA.
- Kartu layanan dengan gambar/ikon berlisensi, judul, ringkasan, dan tautan.
- Kontrol carousel (jika digunakan) dengan tombol jelas, indikator, dukungan keyboard, dan tanpa autoplay secara default.
- Footer dengan kolom informasi dan kontak.
- Breadcrumb dan halaman dokumen untuk halaman dalam.

## Responsif

- Desain mobile-first dengan breakpoints mengikuti kebutuhan konten, bukan perangkat tertentu.
- Pastikan menu, kartu, teks panjang, dan dokumen berfungsi pada 320 px, 768 px, dan 1280 px.
- Gambar memakai rasio konsisten dan tidak menyebabkan layout shift.
- Jangan bergantung pada hover sebagai satu-satunya cara membuka menu atau membaca informasi.

## Gerak dan status

- Hormati `prefers-reduced-motion`.
- Tampilkan status loading hanya selama proses nyata dan sediakan tampilan error/fallback.
- Jangan biarkan area hero kosong atau bertuliskan `Loading...` secara permanen.
