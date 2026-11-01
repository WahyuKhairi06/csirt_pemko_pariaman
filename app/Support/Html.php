<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;

/**
 * Pembersih HTML untuk teks kaya yang ditulis admin (PRD.md bagian 9.1).
 * Admin tepercaya, tetapi akun admin bisa dibobol; teks kaya tidak boleh menjadi jalan menyisipkan skrip ke pengunjung.
 *
 * Memakai daftar putih (whitelist) tag dan atribut berbasis DOMDocument bawaan PHP (atau HTMLPurifier bila tersedia)
 * agar format ala pengolah kata (judul H2/H3, paragraf, daftar poin/nomor, tebal, miring, garis bawah, kutipan, tabel, tautan)
 * tetap tampil rapi sekaligus 100% bebas dari skrip berbahaya (XSS).
 */
final class Html
{
    private const ALLOWED = 'p,br,strong,b,em,i,u,ul,ol,li,a[href|title|target],h2,h3,h4,blockquote,'
        .'table,thead,tbody,tr,th,td,img[src|alt|width|height],figure,figcaption,hr,code,pre';

    /** @var list<string> */
    private const ALLOWED_TAGS = [
        'p', 'br', 'strong', 'b', 'em', 'i', 'u', 's', 'ul', 'ol', 'li',
        'a', 'h2', 'h3', 'h4', 'blockquote', 'table', 'thead', 'tbody',
        'tr', 'th', 'td', 'figure', 'figcaption', 'hr', 'code', 'pre',
    ];

    /** @var list<string> */
    private const DROP_WITH_CONTENT = [
        'script', 'style', 'iframe', 'object', 'embed', 'svg', 'math',
        'form', 'input', 'button', 'textarea', 'select', 'head', 'meta', 'link',
    ];

    private static ?object $purifier = null;

    public static function clean(?string $html): string
    {
        $html = (string) $html;
        if (trim($html) === '') {
            return '';
        }

        if (class_exists(\HTMLPurifier::class)) {
            return self::purifier()->purify($html);
        }

        return self::sanitizeDom($html);
    }

    private static function sanitizeDom(string $html): string
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $wrapped = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body><div>'.$html.'</div></body></html>';

        $prev = libxml_use_internal_errors(true);
        $dom->loadHTML($wrapped, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NONET);
        libxml_clear_errors();
        libxml_use_internal_errors($prev);

        $containers = $dom->getElementsByTagName('div');
        if ($containers->length === 0) {
            return '';
        }

        /** @var DOMElement $root */
        $root = $containers->item(0);
        self::cleanNode($root);

        $output = '';
        foreach ($root->childNodes as $child) {
            $output .= $dom->saveHTML($child);
        }

        return trim($output);
    }

    private static function cleanNode(DOMNode $node): void
    {
        $children = iterator_to_array($node->childNodes);

        foreach ($children as $child) {
            if ($child instanceof DOMElement) {
                $tag = strtolower($child->tagName);

                if (in_array($tag, self::DROP_WITH_CONTENT, true)) {
                    $node->removeChild($child);

                    continue;
                }

                if (! in_array($tag, self::ALLOWED_TAGS, true)) {
                    self::cleanNode($child);
                    while ($child->firstChild) {
                        $node->insertBefore($child->firstChild, $child);
                    }
                    $node->removeChild($child);

                    continue;
                }

                self::cleanAttributes($child, $tag);
                self::cleanNode($child);
            } elseif ($child->nodeType === XML_COMMENT_NODE) {
                $node->removeChild($child);
            }
        }
    }

    private static function cleanAttributes(DOMElement $element, string $tag): void
    {
        $attributes = [];
        foreach ($element->attributes as $attr) {
            $attributes[] = $attr->name;
        }

        foreach ($attributes as $attrName) {
            $lower = strtolower($attrName);

            if ($tag === 'a' && in_array($lower, ['href', 'title', 'target'], true)) {
                if ($lower === 'href') {
                    $href = trim($element->getAttribute($attrName));
                    if (! self::isSafeHref($href)) {
                        $element->removeAttribute($attrName);
                    }
                } elseif ($lower === 'target') {
                    if ($element->getAttribute($attrName) !== '_blank') {
                        $element->removeAttribute($attrName);
                    } else {
                        $element->setAttribute('rel', 'noopener noreferrer');
                    }
                }

                continue;
            }

            if ($tag === 'p' && $lower === 'class' && $element->getAttribute($attrName) === 'lead') {
                continue;
            }

            $element->removeAttribute($attrName);
        }
    }

    private static function isSafeHref(string $href): bool
    {
        if ($href === '') {
            return false;
        }

        if (str_starts_with($href, '/') && ! str_starts_with($href, '//')) {
            return true;
        }

        if (preg_match('/^(https?:\/\/|mailto:|tel:)/i', $href) === 1) {
            return true;
        }

        return false;
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

        return self::purifier;
    }
}
