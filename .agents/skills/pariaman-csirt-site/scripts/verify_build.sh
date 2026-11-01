#!/usr/bin/env bash
# Pemeriksaan sebelum menyatakan pekerjaan selesai. Jalankan dari AKAR proyek Laravel:
#   bash <jalur-skill>/scripts/verify_build.sh
# Kode keluar: 0 = semua lolos, 1 = ada yang gagal, 2 = bukan proyek Laravel.
set -u

SKILL_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
fail=0

step() { printf '\n== %s ==\n' "$1"; }
run()  { "$@" || { echo "GAGAL: $*"; fail=1; }; }

if [ ! -f artisan ]; then
  echo "Berkas artisan tidak ditemukan. Jalankan dari akar proyek Laravel."
  exit 2
fi

step "Gaya kode (Pint)"
if [ -x vendor/bin/pint ]; then run vendor/bin/pint --test; else echo "dilewati: pint belum terpasang"; fi

step "Uji otomatis"
run php artisan test

step "Audit dependensi Composer"
run composer audit

step "Build aset"
if [ -f package.json ]; then run npm run build; else echo "dilewati: tidak ada package.json"; fi

step "Kontras token desain"
if [ -f resources/css/tokens.css ]; then
  run python3 "$SKILL_DIR/scripts/check_contrast.py" resources/css/tokens.css
  if [ -f resources/css/theme.css ]; then
    run python3 "$SKILL_DIR/scripts/check_tokens_sync.py" resources/css/tokens.css resources/css/theme.css
  fi
else
  echo "dilewati: resources/css/tokens.css belum ada (salin dari assets/tokens.css)"
fi

step "Pengaturan produksi (peringatan)"
if grep -qE '^APP_DEBUG=true' .env.example 2>/dev/null; then
  echo "PERINGATAN: .env.example berisi APP_DEBUG=true. Pastikan produksi memakai APP_DEBUG=false."
fi
if [ -f public/.well-known/security.txt ]; then
  echo "PERINGATAN: public/.well-known/security.txt statis ditemukan. Berkas ini menimpa rute dinamis dan tidak ikut Pengaturan. Hapus."
fi

step "Situs publik tanpa input (PRD v0.2) (peringatan)"
# View publik tidak boleh berisi <form>, kecuali formulir pencarian method GET.
forms=$(grep -rnE --include='*.blade.php' '<form' resources/views 2>/dev/null | grep -viE 'method="?get"?|role="search"')
if [ -n "$forms" ]; then
  echo "$forms"
  echo "PERINGATAN: ada <form> di resources/views. Situs publik hanya membaca; pastikan sesuai PRD."
fi
writes=$(grep -nE 'Route::(post|put|patch|delete|any|match)' routes/web.php 2>/dev/null)
if [ -n "$writes" ]; then
  echo "$writes"
  echo "PERINGATAN: rute tulis di routes/web.php. Situs publik tidak boleh menerima input."
fi

step "Placeholder [ISI] (peringatan)"
# Nilai resmi hidup di Pengaturan (basis data), bukan di view atau kode.
hard=$(grep -rn --include='*.php' --include='*.blade.php' '\[ISI' resources/views app 2>/dev/null | grep -v 'app/Models\|database/' | head -20)
if [ -n "$hard" ]; then
  echo "$hard"
  echo "PERINGATAN: placeholder [ISI] tertanam di kode. Pindahkan ke Pengaturan Situs."
fi
echo "Catatan: placeholder [ISI: ...] dari SiteSeeder harus diganti lewat panel admin sebelum rilis."

printf '\n'
if [ "$fail" -ne 0 ]; then
  echo "Ada pemeriksaan yang gagal. Perbaiki sebelum melapor selesai."
  exit 1
fi
echo "Semua pemeriksaan wajib lolos."
