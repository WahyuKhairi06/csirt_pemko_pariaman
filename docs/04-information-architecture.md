# Arsitektur Informasi dan Alur

## Peta situs yang disarankan

```text
Beranda
├── Profil
│   ├── Tentang CSIRT (isi perlu persetujuan)
│   └── Struktur/mandat (jika materi resmi tersedia)
├── Informasi
│   ├── Berita (opsional)
│   ├── Agenda (opsional)
│   └── Publikasi lain (opsional)
├── Informasi Layanan
├── RFC-2350
├── Pengaduan → kanal eksternal resmi
└── Hubungi Kami
```

Item submenu Profil dan Informasi di atas adalah usulan susunan konten, bukan hasil verifikasi isi submenu referensi. Hilangkan atau ubah sesuai materi resmi yang diberikan pemilik.

## Beranda

Urutan komponen:

1. Header dengan identitas dan navigasi.
2. Hero informasi CSIRT dengan isi yang disetujui.
3. Akses cepat: Informasi Layanan, RFC-2350, Pengaduan, Kontak.
4. Portal layanan daerah: kartu layanan yang tertaut ke kanal resmi.
5. Footer dengan kontak, tautan informasi, media sosial, dan hak cipta.

## Alur pengunjung

### Mencari kanal pengaduan

Beranda → pilih `Pengaduan` → lihat penjelasan bahwa situs eksternal akan dibuka → lanjut ke kanal resmi terverifikasi.

### Membaca RFC-2350

Beranda/navigasi → `RFC-2350` → baca dokumen dalam format aksesibel → opsional unduh dokumen resmi.

### Menemukan kontak

Beranda → `Hubungi Kami` → bagian kontak → pilih tautan telepon/alamat bila sudah diverifikasi.

### Menemukan layanan daerah

Beranda → bagian `Portal Layanan` → pilih kartu layanan → diarahkan ke situs layanan yang telah diverifikasi.

## Aturan tautan

- Jangan menggunakan `href="#"` untuk tautan yang tampak aktif.
- Tautan jangkar lokal harus mengarah ke ID unik yang benar.
- Tautan eksternal harus memiliki label tujuan yang jelas; jika membuka tab baru, beri tahu pengguna dan gunakan atribut keamanan yang tepat.
- Tautan yang belum diverifikasi harus berupa teks nonaktif/placeholder di lingkungan pengembangan, bukan URL tebakan.
