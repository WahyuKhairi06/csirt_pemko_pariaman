# Strategi Pengujian

## Lapisan pengujian

1. **Pemeriksaan statis:** formatter, linter, dan pemeriksaan tipe bila tersedia.
2. **Unit/komponen:** navigasi dropdown, menu ponsel, carousel (jika ada), serta fungsi pembentuk tautan/konten.
3. **Integrasi:** render halaman, navigasi internal, tautan jangkar, data kartu layanan, dan halaman RFC.
4. **End-to-end:** alur pengunjung utama dari beranda ke layanan, dokumen, pengaduan, dan kontak.
5. **Visual/responsif:** desktop dan ponsel pada lebar 320, 768, dan 1280 px; periksa overflow, menu, dan konsistensi layout.
6. **Aksesibilitas:** keyboard-only, fokus, nama/role kontrol, label, alt text, kontras, zoom 200%, reduced motion, dan pemeriksaan otomatis sebagai bantuan.
7. **Keamanan:** pastikan tidak ada rahasia, formulir yang tak diminta, URL tebakan, error sensitif, atau konten placeholder yang menyerupai informasi resmi.

## Alur kritis

- Dari beranda, keyboard dapat mencapai seluruh menu dan membuka/menutup submenu.
- Pengunjung berpindah ke Informasi Layanan dan kembali ke Beranda.
- Pengunjung membuka RFC-2350 dan dapat membaca/menemukan unduhan yang disetujui.
- Pengunjung memahami bahwa Pengaduan menuju domain eksternal sebelum berpindah.
- Pengunjung mengakses kontak melalui jangkar, tautan telepon, dan tautan peta bila telah diverifikasi.
- Pengunjung memilih satu kartu Portal Layanan dan mencapai URL tujuan yang benar.
- Menu ponsel dapat dibuka, memilih halaman, dan ditutup tanpa halaman bergeser horizontal.

## Kriteria pelaporan

- Catat perintah pengujian, lingkungan, hasil, dan kegagalan yang diketahui.
- Perbaiki kegagalan yang relevan sebelum menyatakan selesai.
- Jika pengujian tidak tersedia atau tidak dapat dijalankan, sebutkan keterbatasannya secara eksplisit.
- Jangan menyebut audit otomatis sebagai bukti aksesibilitas penuh; sertakan pemeriksaan manual.
