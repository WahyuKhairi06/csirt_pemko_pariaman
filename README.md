# Rebuild Portal CSIRT Sumatera Barat

Paket spesifikasi untuk membangun ulang portal bergaya CSIRT Sumatera Barat dari nol. Dokumen ini menggunakan situs publik `https://csirt.sumbarprov.go.id/` sebagai referensi tampilan dan struktur informasi.

## Cara menggunakan

1. Buka folder ini sebagai workspace/proyek Antigravity.
2. Minta agen membaca `AGENTS.md` dan seluruh dokumen dalam `docs/` sebelum membuat rencana atau kode.
3. Minta agen merangkum asumsi dan rencana implementasi terlebih dahulu. Jangan mulai coding sebelum rencana dan informasi yang belum terverifikasi ditandai.
4. Bangun implementasi baru di folder proyek ini; jangan mengambil atau mengubah kode dari proyek induk.
5. Jalankan pemeriksaan dan skenario uji dalam `docs/07-testing-strategy.md` dan `docs/08-acceptance-checklist.md`.

## Dokumen

- `AGENTS.md`: instruksi kerja tetap bagi agen Antigravity.
- `docs/01-reference-audit.md`: temuan dari situs referensi dan keterbatasan pengamatan.
- `docs/02-product-brief.md`: tujuan, pengguna, dan ruang lingkup.
- `docs/03-requirements.md`: fitur dan kriteria penerimaan.
- `docs/04-information-architecture.md`: peta halaman dan alur pengguna.
- `docs/05-design-system.md`: arahan visual dan responsif.
- `docs/06-technical-architecture.md`: arahan implementasi dari proyek kosong.
- `docs/07-security-accessibility.md`: privasi, keamanan, dan aksesibilitas.
- `docs/08-testing-strategy.md`: strategi pengujian.
- `docs/09-acceptance-checklist.md`: daftar pemeriksaan sebelum selesai.
- `.agents/rules/`: aturan tambahan yang otomatis berlaku berdasarkan jenis pekerjaan.

## Status

Dokumen awal untuk perencanaan dan implementasi. Nama layanan, alamat, nomor telepon, tautan, logo, isi RFC-2350, isi hero, dan konten resmi lainnya wajib diverifikasi oleh pemilik proyek sebelum dipublikasikan.
