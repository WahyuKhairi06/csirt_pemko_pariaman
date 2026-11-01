# Keamanan, Privasi, dan Aksesibilitas

## Keamanan dan privasi

- Rilis awal hanya menampilkan informasi publik dan tautan keluar; jangan menyimpan laporan insiden atau data pribadi.
- Jangan menambahkan form kontak/pengaduan, unggah berkas, login, atau analitik tanpa kebutuhan dan persetujuan yang jelas.
- Jangan menaruh API key, kata sandi, token, atau data pribadi di kode, Markdown publik, repositori, maupun log.
- Jika fitur dinamis disetujui kelak, dokumentasikan data yang dikumpulkan, tujuan, retensi, kontrol akses, validasi, rate limit, logging, dan mekanisme penghapusan sebelum implementasi.
- Validasi input di server untuk semua input yang kelak diterima; escape output dan gunakan proteksi CSRF sesuai framework.
- Gunakan HTTPS dan header keamanan pada lingkungan produksi.
- Perlakukan URL eksternal sebagai konten yang harus diverifikasi; jangan menebak URL.

## Identitas dan kepercayaan publik

- Tandai prototipe selama pengembangan jika ada kemungkinan disalahartikan sebagai portal resmi.
- Gunakan lambang/brand resmi hanya setelah pemilik memastikan hak dan kewenangan penggunaan.
- Jangan menyatakan layanan aktif, SLA, status sertifikasi, atau mandat organisasi tanpa sumber resmi.

## Aksesibilitas

- Target WCAG 2.2 AA untuk halaman dan komponen utama.
- Gunakan landmark HTML, heading bertingkat, tombol untuk aksi, dan tautan untuk navigasi.
- Semua kontrol dapat dicapai dengan Tab/Shift+Tab dan menampilkan fokus yang jelas.
- Dropdown bisa dibuka/ditutup dengan keyboard dan diumumkan statusnya oleh teknologi bantu.
- Gambar bermakna memiliki teks alternatif; gambar dekoratif memakai alt kosong.
- Kontras teks dan kontrol memadai; jangan menyampaikan status melalui warna saja.
- Formulir jika kelak dibuat harus memiliki label, instruksi, validasi yang dibacakan, dan pesan error yang jelas.
- Hormati pengaturan reduced motion dan jangan melakukan autoplay media.
- Uji zoom 200%, reflow, urutan fokus, serta pembaca layar pada alur utama.
