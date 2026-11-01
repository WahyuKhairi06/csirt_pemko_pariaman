<?php

namespace App\Http\Controllers;

use App\Enums\ReportChannelType;
use App\Support\Settings;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * /.well-known/security.txt (RFC 9116), dibentuk dari Pengaturan Situs (FR-06) agar selalu cocok dengan
 * halaman Kontak Keamanan. 404 selama email keamanan belum diisi atau masih placeholder [ISI].
 */
class SecurityTxtController extends Controller
{
    public function __invoke(): Response
    {
        $email = trim((string) Settings::get('contact.email_security', ''));
        abort_unless(filter_var($email, FILTER_VALIDATE_EMAIL) !== false, 404);

        // RFC 9116 mewajibkan Expires. Bila admin belum mengisi, pakai 6 bulan ke depan.
        $expires = Settings::get('security.expires');
        $expiresAt = $expires ? Carbon::parse((string) $expires) : now()->addMonths(6);

        $lines = [
            'Contact: mailto:'.$email,
            'Expires: '.$expiresAt->copy()->utc()->format('Y-m-d\TH:i:s\Z'),
            'Preferred-Languages: id, en',
            'Canonical: '.url('/.well-known/security.txt'),
        ];

        $policy = trim((string) Settings::get('security.policy_url', ''));
        if ($policy !== '' && ReportChannelType::isHttpUrl($policy)) {
            $lines[] = 'Policy: '.$policy;
        }

        $key = trim((string) Settings::get('pgp.key_file', ''));
        if ($key !== '') {
            $lines[] = 'Encryption: '.Storage::disk('public')->url($key);
        }

        return response(implode("\n", $lines)."\n", 200, ['Content-Type' => 'text/plain; charset=utf-8']);
    }
}
