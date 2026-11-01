<?php

use App\Rules\SafeUrl;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

uses(TestCase::class);

it('accepts valid relative paths when allowRelative is true', function (string $url) {
    $validator = Validator::make(['url' => $url], [
        'url' => [new SafeUrl(allowRelative: true)],
    ]);

    expect($validator->passes())->toBeTrue();
})->with([
    '/berita',
    '/layanan',
    '/kontak?ref=portal#alamat',
    '/halaman/tentang-kami-csirt',
]);

it('accepts valid absolute http and https URLs', function (string $url) {
    $validator = Validator::make(['url' => $url], [
        'url' => [new SafeUrl(allowRelative: true)],
    ]);

    expect($validator->passes())->toBeTrue();
})->with([
    'https://pariamankota.go.id',
    'https://csirt.sumbarprov.go.id/portal',
    'http://subdomain.example.org/path?a=1',
]);

it('rejects dangerous schemes like javascript:, data:, and vbscript:', function (string $dangerousUrl) {
    $validator = Validator::make(['url' => $dangerousUrl], [
        'url' => [new SafeUrl(allowRelative: true)],
    ]);

    expect($validator->fails())->toBeTrue();
})->with([
    'javascript:alert(1)',
    'JAVASCRIPT:alert(1)',
    'javascript:/*--></title></style></textarea></script></xmp><svg/onload=\'+/"/+/onmouseover=1/+/[*/[]/+alert(1)//\'>',
    'data:text/html,<script>alert(1)</script>',
    'DATA:text/html;base64,PHNjcmlwdD5hbGVydCgxKTwvc2NyaXB0Pg==',
    'vbscript:msgbox("xss")',
    'file:///etc/passwd',
    'blob:https://example.com/uuid',
]);

it('rejects protocol-relative URLs', function () {
    $validator = Validator::make(['url' => '//attacker.com/evil'], [
        'url' => [new SafeUrl(allowRelative: true)],
    ]);

    expect($validator->fails())->toBeTrue();
});

it('rejects relative paths when allowRelative is false', function () {
    $validator = Validator::make(['url' => '/berita'], [
        'url' => [new SafeUrl(allowRelative: false)],
    ]);

    expect($validator->fails())->toBeTrue();
});

it('rejects URLs containing control characters or newlines', function () {
    $validator = Validator::make(['url' => "https://example.com\n/test"], [
        'url' => [new SafeUrl(allowRelative: true)],
    ]);

    expect($validator->fails())->toBeTrue();
});
