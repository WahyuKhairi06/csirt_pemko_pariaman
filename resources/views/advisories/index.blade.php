@extends('layouts.app')

@section('title', 'Advisori Keamanan Siber')
@section('description', 'Peringatan dini, rekomendasi teknis, dan advisori keamanan informasi resmi dari CSIRT Kota Pariaman.')

@section('content')
<div class="bg-surface/50 border-b border-line py-8">
    <x-container>
        <nav aria-label="Remah roti">
            <ol class="flex flex-wrap items-center gap-x-2 text-sm text-muted">
                <li>
                    <a href="{{ route('home') }}" class="rounded-sm text-brand-700 underline underline-offset-4 hover:text-brand-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700">
                        Beranda
                    </a>
                </li>
                <li aria-hidden="true" class="text-muted/60">/</li>
                <li aria-current="page" class="font-medium text-ink">Advisori</li>
            </ol>
        </nav>
        <h1 class="mt-4 font-heading text-(length:--text-h1) font-bold tracking-tight text-ink">
            Advisori Keamanan Siber
        </h1>
        <p class="mt-3 max-w-[720px] text-lg text-muted">
            Peringatan dini, analisis kerentanan, dan instruksi penanganan teknis untuk melindungi sistem elektronik instansi pemerintah daerah.
        </p>
    </x-container>
</div>

<x-container class="py-12">
    {{-- Filter Tingkat Keparahan (via GET links) --}}
    <div class="mb-8">
        <h2 class="text-sm font-semibold uppercase tracking-wider text-muted">Saring Tingkat Keparahan</h2>
        <div class="mt-3 flex flex-wrap gap-2">
            <a href="{{ route('advisories.index') }}"
               class="rounded-full px-4 py-1.5 text-xs font-semibold transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700 {{ is_null($severity) ? 'bg-brand-700 text-white' : 'bg-surface text-ink border border-line hover:bg-brand-50' }}">
                Semua Tingkat
            </a>
            @foreach (\App\Enums\Severity::cases() as $sev)
                <a href="{{ route('advisories.index', ['tingkat' => $sev->value]) }}"
                   class="rounded-full px-4 py-1.5 text-xs font-semibold transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700 {{ $severity === $sev ? 'bg-brand-700 text-white' : 'bg-surface text-ink border border-line hover:bg-brand-50' }}">
                    {{ $sev->label() }}
                </a>
            @endforeach
        </div>
    </div>

    @if ($advisories->isNotEmpty())
        <div class="space-y-4">
            @foreach ($advisories as $advisory)
                <article class="flex flex-col justify-between gap-4 rounded-xl border border-line bg-white p-6 shadow-sm transition hover:shadow-md md:flex-row md:items-center">
                    <div class="max-w-[760px] space-y-2">
                        <div class="flex flex-wrap items-center gap-3">
                            <x-badge-severity :severity="$advisory->severity" />
                            <time datetime="{{ ($advisory->published_at ?? $advisory->created_at)->toDateString() }}" class="text-xs text-muted">
                                {{ ($advisory->published_at ?? $advisory->created_at)->translatedFormat('j F Y') }}
                            </time>
                        </div>

                        <h3 class="font-heading text-xl font-bold text-ink">
                            <a href="{{ route('advisories.show', $advisory->slug) }}" class="hover:text-brand-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700">
                                {{ $advisory->title }}
                            </a>
                        </h3>

                        <p class="text-sm leading-relaxed text-muted line-clamp-2">
                            {{ $advisory->summary }}
                        </p>
                    </div>

                    <div class="shrink-0 pt-2 md:pt-0">
                        <a href="{{ route('advisories.show', $advisory->slug) }}"
                           class="inline-flex min-h-[44px] items-center gap-1.5 text-sm font-semibold text-brand-700 hover:text-brand-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700">
                            <span>Baca Selengkapnya</span>
                            <x-icon name="arrow-right" class="size-4" />
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $advisories->links() }}
        </div>
    @else
        <div class="rounded-xl border border-line bg-surface p-8 text-center">
            <x-icon name="shield" class="mx-auto size-8 text-brand-700" />
            <h2 class="mt-3 font-heading text-lg font-semibold text-ink">Tidak Ada Advisori</h2>
            <p class="mt-1 text-sm text-muted">Belum ada advisori keamanan yang sesuai dengan kriteria yang dipilih.</p>
            @if ($severity)
                <div class="mt-4">
                    <a href="{{ route('advisories.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700 underline underline-offset-4 hover:text-brand-900">
                        Tampilkan semua advisori
                    </a>
                </div>
            @endif
        </div>
    @endif
</x-container>
@endsection
