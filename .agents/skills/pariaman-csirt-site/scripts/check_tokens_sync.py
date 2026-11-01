#!/usr/bin/env python3
"""Pastikan pemetaan Tailwind v4 (theme.css) selaras dengan tokens.css.

Pemakaian:
    python3 scripts/check_tokens_sync.py assets/tokens.css assets/theme.css

Memeriksa: (1) setiap --color-X di theme.css merujuk var(--Y) yang ada di tokens.css,
(2) nilai font dan radius di theme.css identik dengan tokens.css.
Kode keluar: 0 selaras, 1 tidak selaras, 2 berkas tidak terbaca.
"""
import re
import sys

# --color-<nama-theme> memakai nama token yang berbeda hanya untuk 'line' dan 'line-input'.
ALIAS = {"line": "border", "line-input": "border-input"}


def read(path):
    try:
        with open(path, encoding="utf-8") as f:
            return f.read()
    except OSError as err:
        print(f"Tidak bisa membaca {path}: {err}")
        sys.exit(2)


def declarations(css):
    return {k: v.strip() for k, v in re.findall(r"--([a-z0-9-]+)\s*:\s*([^;]+);", css)}


def main(argv):
    if len(argv) != 3:
        print(__doc__)
        return 2
    tokens = declarations(read(argv[1]))
    theme = declarations(read(argv[2]))
    problems = []

    for name, value in theme.items():
        if name.startswith("color-"):
            ref = re.fullmatch(r"var\(--([a-z0-9-]+)\)", value)
            if not ref:
                problems.append(f"--{name}: nilai bukan var(--token): {value}")
                continue
            target = ref.group(1)
            expected = ALIAS.get(name[len("color-"):], name[len("color-"):])
            if target not in tokens:
                problems.append(f"--{name}: token --{target} tidak ada di tokens.css")
            elif target != expected:
                problems.append(f"--{name}: merujuk --{target}, seharusnya --{expected}")
        elif name.startswith(("font-", "radius-")):
            if name not in tokens:
                problems.append(f"--{name}: tidak ada padanannya di tokens.css")
            elif tokens[name] != value:
                problems.append(f"--{name}: theme='{value}' tetapi tokens='{tokens[name]}'")

    mapped = {
        ALIAS.get(n[len("color-"):], n[len("color-"):]) for n in theme if n.startswith("color-")
    }
    expected_colors = {
        "navy-900", "brand-700", "brand-900", "accent-100", "accent-400", "ink", "muted", "surface",
        "border", "border-input", "on-navy-muted", "success", "success-bg", "warning", "warning-bg",
        "danger", "danger-bg", "info", "info-bg",
    }
    for missing in sorted(expected_colors - mapped):
        problems.append(f"token --{missing} belum dipetakan di theme.css")

    if problems:
        print("Tidak selaras:")
        for p in problems:
            print("  - " + p)
        return 1
    print(f"Selaras: {len(mapped)} warna, font, dan radius cocok dengan tokens.css.")
    return 0


if __name__ == "__main__":
    sys.exit(main(sys.argv))
