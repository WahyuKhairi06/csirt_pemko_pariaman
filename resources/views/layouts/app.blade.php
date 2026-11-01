{{-- Layout publik. Data ($site, $menuHeader, $menuFooter, $reportUrl, $emergency) dari App\View\Composers\SiteComposer. --}}
@php
    $siteName = $site['site.name'] ?? config('app.name');
    $emergencyIcons = ['info' => 'info', 'warning' => 'alert', 'danger' => 'alert'];
    $emergencyStyles = [
        'info' => 'bg-info-bg text-info border-info',
        'warning' => 'bg-warning-bg text-warning border-warning',
        'danger' => 'bg-danger-bg text-danger border-danger',
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@hasSection('title')@yield('title') — @endif{{ $siteName }}</title>
    <link rel="icon" type="image/png" href="{{ ! empty($site['site.logo']) ? Storage::disk('public')->url($site['site.logo']) : '/images/logo-pemko-pariaman.png' }}">
    @if (View::hasSection('description') && trim($__env->yieldContent('description')) !== '')
        <meta name="description" content="@yield('description')">
    @elseif (! empty($site['site.tagline']))
        <meta name="description" content="{{ $site['site.tagline'] }}">
    @endif
    @if (! empty($preview))
        <meta name="robots" content="noindex, nofollow">
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-dvh flex-col bg-white font-body text-ink antialiased">
    <a href="#konten-utama"
       class="sr-only rounded-md bg-white px-4 py-3 font-semibold text-brand-900 shadow-lg focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-50">
        Lewati ke konten utama
    </a>


    @if (! empty($emergency))
        <div role="region" aria-label="Pemberitahuan penting"
             class="border-l-4 px-4 py-3 {{ $emergencyStyles[$emergency['level']] ?? $emergencyStyles['warning'] }}">
            <x-container class="flex items-start gap-3 !px-0 sm:!px-0 lg:!px-0">
                <x-icon :name="$emergencyIcons[$emergency['level']] ?? 'alert'" class="mt-0.5 size-5 shrink-0" />
                <p class="font-medium">{{ $emergency['text'] }}</p>
            </x-container>
        </div>
    @endif

    <x-site-header :site="$site" :menu="$menuHeader" :report-url="$reportUrl" />

    <main id="konten-utama" tabindex="-1" class="flex-1 focus:outline-none">
        @yield('content')
    </main>

    <x-site-footer :site="$site" :menu="$menuFooter" />
    <x-feedback-modal />
</body>
</html>
