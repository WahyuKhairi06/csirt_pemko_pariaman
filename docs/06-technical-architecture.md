# Arahan Arsitektur Teknis

## Prinsip awal

- Proyek ini dimulai dari direktori aplikasi kosong; dokumentasi ini berada di dalam folder spesifikasi.
- Jangan mengimpor kode, database, kredensial, atau aset dari aplikasi induk.
- Sebelum scaffolding, agen harus menyebutkan pilihan stack dan alasannya. Jika pemilik belum menentukan stack dan proyek dijalankan di ekosistem ini, Laravel + Blade + Tailwind adalah kandidat awal; jangan mengasumsikan database/CMS diperlukan.
- Pilih implementasi paling sederhana yang memenuhi kebutuhan. Untuk situs informasi statis, hindari backend/database tanpa kebutuhan konten dinamis yang disetujui.

## Struktur logis

- Layout utama: header, konten, footer.
- Komponen: navigasi/dropdown, hero, kartu layanan, breadcrumbs, tombol, carousel (opsional).
- Konten: simpan dalam sumber terstruktur yang mudah diperbarui (mis. konfigurasi/array atau berkas konten) bila belum memerlukan CMS.
- Halaman: beranda, profil, informasi layanan, RFC-2350, dan halaman turunan lain hanya jika materi tersedia.
- Aset: folder khusus dengan nama deskriptif, format modern, ukuran responsif, dan catatan lisensi/sumber.

## Stack dan kualitas

- Gunakan versi stabil yang didukung dan dokumentasikan versi runtime/dependensi dalam README aplikasi.
- Hindari dependensi besar untuk interaksi sederhana.
- Pisahkan URL/konten yang mudah berubah dari markup.
- Tambahkan linting/formatting serta pemeriksaan otomatis yang sesuai dengan stack terpilih.
- Kunci dependensi dan sediakan `.env.example` tanpa rahasia.

## Konten dan tautan

- Kontak, URL layanan, akun sosial, teks legal, logo, dan dokumen resmi diperlakukan sebagai data yang perlu review pemilik.
- Tambahkan sumber dan status verifikasi dalam catatan konten internal; jangan tampilkan status draft kepada publik.
- Tautan eksternal sebaiknya disimpan terpusat untuk memudahkan audit.

## Rilis

- Pisahkan konfigurasi lokal, staging, dan produksi.
- Gunakan HTTPS, header keamanan, backup bila data dinamis ditambahkan, dan prosedur rollback.
- Jangan deploy atau menghubungkan domain resmi sebelum otorisasi, materi, kontak, dan persetujuan rilis diverifikasi.
