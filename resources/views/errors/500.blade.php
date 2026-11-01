{{-- Halaman 500 (FR-52). Sengaja mandiri (tanpa layout/basis data) agar tetap tampil saat sumber galatnya basis data. --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Terjadi gangguan — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css'])
</head>
<body class="flex min-h-dvh items-center bg-surface font-body text-ink antialiased">
    <main class="mx-auto w-full max-w-(--container) px-4 py-16 sm:px-6 lg:px-10">
        <p class="text-sm font-semibold uppercase tracking-wide text-brand-700">Kesalahan 500</p>
        <h1 class="mt-2 font-heading text-(length:--text-h1) font-bold leading-tight">Terjadi gangguan pada situs</h1>
        <p class="mt-4 max-w-[60ch] text-lg text-muted">Kami sedang memperbaikinya. Silakan coba lagi beberapa saat lagi.</p>
        <a href="/" class="mt-8 inline-flex min-h-11 items-center rounded-md bg-brand-700 px-5 font-semibold text-white hover:bg-brand-900">Kembali ke beranda</a>
    </main>
</body>
</html>
