@extends('layouts.app')

@section('title', 'Agenda & Kegiatan Keamanan Siber')
@section('description', 'Agenda kegiatan, sosialisasi, dan bimbingan teknis kesiapsiagaan insiden siber Pemerintah Kota Pariaman.')

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
                <li aria-current="page" class="font-medium text-ink">Agenda</li>
            </ol>
        </nav>
        <h1 class="mt-4 font-heading text-(length:--text-h1) font-bold tracking-tight text-ink">
            Agenda & Kegiatan Keamanan Siber
        </h1>
        <p class="mt-3 max-w-[720px] text-lg text-muted">
            Jadwal kegiatan sosialisasi, workshop, bimbingan teknis, dan simulasi penanganan insiden siber yang diselenggarakan oleh CSIRT Kota Pariaman.
        </p>
    </x-container>
</div>

<x-container class="py-12">
    {{-- Agenda Mendatang --}}
    <section aria-labelledby="agenda-mendatang-judul">
        <div class="border-b border-line pb-4">
            <h2 id="agenda-mendatang-judul" class="font-heading text-(length:--text-h2) font-bold text-ink">
                Agenda Mendatang
            </h2>
        </div>

        @if ($upcoming->isNotEmpty())
            <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($upcoming as $event)
                    <article class="flex flex-col justify-between rounded-xl border border-line bg-white p-6 shadow-sm transition hover:shadow-md">
                        <div>
                            <div class="flex items-center gap-2 text-xs font-semibold text-brand-700">
                                <x-icon name="calendar" class="size-4" />
                                <span>{{ $event->starts_at->translatedFormat('l, j F Y') }}</span>
                            </div>

                            <h3 class="mt-3 font-heading text-xl font-bold text-ink">
                                {{ $event->title }}
                            </h3>

                            @if ($event->description)
                                <p class="mt-2 text-sm text-muted leading-relaxed">
                                    {{ $event->description }}
                                </p>
                            @endif

                            <div class="mt-6 space-y-2 border-t border-line/70 pt-4 text-xs">
                                <div class="flex items-center gap-2 text-ink">
                                    <x-icon name="clock" class="size-4 shrink-0 text-muted" />
                                    <span>
                                        {{ $event->starts_at->format('H:i') }}
                                        @if ($event->ends_at)
                                            — {{ $event->ends_at->format('H:i') }} WIB
                                        @else
                                            WIB
                                        @endif
                                    </span>
                                </div>
                                @if ($event->location)
                                    <div class="flex items-center gap-2 text-ink">
                                        <x-icon name="map-pin" class="size-4 shrink-0 text-muted" />
                                        <span>{{ $event->location }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="mt-6 rounded-xl border border-line bg-surface p-8 text-center">
                <x-icon name="calendar" class="mx-auto size-8 text-muted" />
                <p class="mt-2 text-sm text-muted">Belum ada agenda mendatang yang dijadwalkan saat ini.</p>
            </div>
        @endif
    </section>

    {{-- Kegiatan Sebelumnya --}}
    @if ($past->isNotEmpty())
        <section aria-labelledby="kegiatan-sebelumnya-judul" class="mt-16">
            <div class="border-b border-line pb-4">
                <h2 id="kegiatan-sebelumnya-judul" class="font-heading text-(length:--text-h2) font-bold text-ink">
                    Kegiatan Sebelumnya
                </h2>
            </div>

            <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($past as $event)
                    <article class="flex flex-col justify-between rounded-xl border border-line bg-white/70 p-6 shadow-sm">
                        <div>
                            <div class="text-xs font-medium text-muted">
                                {{ $event->starts_at->translatedFormat('j F Y') }}
                            </div>
                            <h3 class="mt-2 font-heading text-lg font-bold text-ink">
                                {{ $event->title }}
                            </h3>
                            @if ($event->location)
                                <p class="mt-2 text-xs text-muted flex items-center gap-1.5">
                                    <x-icon name="map-pin" class="size-3.5" />
                                    <span>{{ $event->location }}</span>
                                </p>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif
</x-container>
@endsection
