<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class SafeUrl implements ValidationRule
{
    public function __construct(public bool $allowRelative = true) {}

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === null || $value === '') {
            return;
        }

        if (! is_string($value)) {
            $fail('Kolom :attribute harus berupa teks URL.');

            return;
        }

        $url = trim($value);

        // Cegah karakter kontrol dan newline
        if (preg_match('/[\x00-\x1F\x7F]/', $url) === 1) {
            $fail('Kolom :attribute mengandung karakter yang tidak diizinkan.');

            return;
        }

        // Cegah skema berbahaya (javascript:, data:, vbscript:, file:, dll.)
        $lower = strtolower($url);
        $dangerousSchemes = ['javascript:', 'data:', 'vbscript:', 'file:', 'about:', 'blob:'];
        foreach ($dangerousSchemes as $scheme) {
            if (str_starts_with($lower, $scheme) || str_contains($lower, ' '.$scheme)) {
                $fail('Kolom :attribute tidak boleh menggunakan skema berbahaya ('.$scheme.').');

                return;
            }
        }

        // Jalur internal relatif (misal: /berita, /layanan)
        if ($this->allowRelative && str_starts_with($url, '/')) {
            if (str_starts_with($url, '//')) {
                $fail('Kolom :attribute tidak boleh berupa tautan protokol-relatif (//).');

                return;
            }

            return;
        }

        // URL absolut http / https
        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));
        $host = parse_url($url, PHP_URL_HOST);

        if (! in_array($scheme, ['http', 'https'], true) || ! $host || filter_var($url, FILTER_VALIDATE_URL) === false) {
            $expected = $this->allowRelative ? 'jalur internal (/...) atau tautan web (http/https)' : 'tautan web yang valid (http:// atau https://)';
            $fail('Kolom :attribute harus berupa '.$expected.'.');
        }
    }
}
