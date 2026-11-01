<?php

namespace App\Support;

/**
 * Pembersih HTML untuk teks kaya yang ditulis admin (PRD.md bagian 9.1).
 * Admin tepercaya, tetapi akun admin bisa dibobol; teks kaya tidak boleh menjadi jalan menyisipkan skrip ke pengunjung.
 *
 * Aman secara bawaan: tanpa paket ezyang/htmlpurifier, HTML ditampilkan sebagai TEKS BIASA (semua tag dibuang).
 * Pasang paketnya agar format (paragraf, daftar, tautan, tabel) tampil:  composer require ezyang/htmlpurifier
 * Pakai di Blade:  {!! \App\Support\Html::clean($post->body) !!}
 */
final class Html
{
    private const ALLOWED = 'p,br,strong,b,em,i,u,ul,ol,li,a[href|title|target],h2,h3,h4,blockquote,'
        .'table,thead,tbody,tr,th,td,img[src|alt|width|height],figure,figcaption,hr,code,pre';

    private static ?object $purifier = null;

    public static function clean(?string $html): string
    {
        $html = (string) $html;
        if (trim($html) === '') {
            return '';
        }

        if (! class_exists(\HTMLPurifier::class)) {
            return nl2br(e(strip_tags($html)));
        }

        return self::purifier()->purify($html);
    }

    private static function purifier(): object
    {
        if (self::$purifier === null) {
            $config = \HTMLPurifier_Config::createDefault();

            $cache = storage_path('app/purifier');
            if (! is_dir($cache)) {
                @mkdir($cache, 0775, true);
            }
            $config->set('Cache.SerializerPath', $cache);
            $config->set('HTML.Allowed', self::ALLOWED);
            $config->set('URI.AllowedSchemes', ['http' => true, 'https' => true, 'mailto' => true, 'tel' => true]);
            $config->set('Attr.AllowedFrameTargets', ['_blank']);

            self::$purifier = new \HTMLPurifier($config);
        }

        return self::$purifier;
    }
}
