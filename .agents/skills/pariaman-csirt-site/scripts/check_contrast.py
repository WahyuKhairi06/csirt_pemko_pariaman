#!/usr/bin/env python3
"""Cek kontras pasangan warna penting di tokens.css (WCAG 2.x).

Pemakaian:
    python3 scripts/check_contrast.py assets/tokens.css

Keluar dengan kode 0 jika semua pasangan lolos, kode 1 jika ada yang gagal,
kode 2 jika token tidak ditemukan atau berkas tidak bisa dibaca.
"""
import re
import sys

# (token teks/ikon/batas, token latar, ambang minimum, keterangan)
PAIRS = [
    ("ink", "white", 4.5, "teks utama di atas putih"),
    ("ink", "surface", 4.5, "teks utama di atas surface"),
    ("ink", "accent-100", 4.5, "teks utama di atas sorotan lembut"),
    ("muted", "white", 4.5, "teks sekunder di atas putih"),
    ("muted", "surface", 4.5, "teks sekunder di atas surface"),
    ("white", "brand-700", 4.5, "tombol primer"),
    ("white", "brand-900", 4.5, "tombol primer saat hover"),
    ("brand-700", "white", 4.5, "tautan di atas putih"),
    ("brand-700", "surface", 4.5, "tautan di atas surface"),
    ("brand-900", "white", 4.5, "tautan dikunjungi / aktif"),
    ("white", "navy-900", 4.5, "teks di atas navy"),
    ("accent-400", "navy-900", 4.5, "emas di atas navy"),
    ("navy-900", "accent-400", 4.5, "teks tombol emas"),
    ("on-navy-muted", "navy-900", 4.5, "teks sekunder di atas navy"),
    ("white", "danger", 4.5, "tombol bahaya / badge kritis"),
    ("white", "success", 4.5, "teks putih di atas sukses"),
    ("success", "success-bg", 4.5, "status sukses"),
    ("warning", "warning-bg", 4.5, "status peringatan"),
    ("danger", "danger-bg", 4.5, "status bahaya"),
    ("info", "info-bg", 4.5, "status info"),
    ("border-input", "white", 3.0, "batas kolom input (komponen UI)"),
    ("brand-700", "white", 3.0, "cincin fokus di atas terang"),
    ("accent-400", "navy-900", 3.0, "cincin fokus di atas navy"),
]


def parse_tokens(css):
    """Ambil semua custom property bernilai hex 6 digit, tanpa awalan '--'."""
    tokens = {}
    for name, value in re.findall(r"--([a-z0-9-]+)\s*:\s*(#[0-9a-fA-F]{6})\b", css):
        tokens[name] = value.upper()
    return tokens


def luminance(hex_color):
    h = hex_color.lstrip("#")
    channels = [int(h[i:i + 2], 16) / 255 for i in (0, 2, 4)]

    def lin(c):
        return c / 12.92 if c <= 0.03928 else ((c + 0.055) / 1.055) ** 2.4

    r, g, b = (lin(c) for c in channels)
    return 0.2126 * r + 0.7152 * g + 0.0722 * b


def ratio(fg, bg):
    hi, lo = sorted((luminance(fg), luminance(bg)), reverse=True)
    return (hi + 0.05) / (lo + 0.05)


def main(argv):
    if len(argv) != 2:
        print(__doc__)
        return 2
    try:
        with open(argv[1], encoding="utf-8") as f:
            tokens = parse_tokens(f.read())
    except OSError as err:
        print(f"Tidak bisa membaca {argv[1]}: {err}")
        return 2

    missing = sorted({t for fg, bg, _, _ in PAIRS for t in (fg, bg) if t not in tokens})
    if missing:
        print("Token tidak ditemukan di berkas: " + ", ".join(missing))
        return 2

    failed = 0
    print(f"{'Rasio':>6}  {'Min':>4}  Hasil  Pasangan")
    for fg, bg, minimum, note in PAIRS:
        r = ratio(tokens[fg], tokens[bg])
        ok = r >= minimum
        failed += 0 if ok else 1
        print(f"{r:6.2f}  {minimum:4.1f}  {'LOLOS' if ok else 'GAGAL'}  {fg} di atas {bg} — {note}")

    print()
    if failed:
        print(f"{failed} pasangan gagal. Perbaiki token sebelum dipakai.")
        return 1
    print(f"Semua {len(PAIRS)} pasangan lolos.")
    return 0


if __name__ == "__main__":
    sys.exit(main(sys.argv))
