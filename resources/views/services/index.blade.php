@extends('layouts.app')

@section('title', 'Katalog Layanan Keamanan Siber')
@section('description', 'Katalog layanan resmi penanganan dan pencegahan insiden keamanan siber untuk Organisasi Perangkat Daerah di lingkungan Pemerintah Kota Pariaman.')

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
                <li aria-current="page" class="font-medium text-ink">Layanan</li>
            </ol>
        </nav>
        <h1 class="mt-4 font-heading text-(length:--text-h1) font-bold tracking-tight text-ink">
            Katalog Layanan Keamanan Siber
        </h1>
        <p class="mt-3 max-w-[720px] text-lg text-muted">
            Layanan resmi tanggap insiden dan pengamanan siber yang diselenggarakan oleh CSIRT Kota Pariaman bagi seluruh Organisasi Perangkat Daerah (OPD), unit kerja, dan pemangku kepentingan.
        </p>
    </x-container>
</div>

<x-container class="py-12">
    @if ($groups->isNotEmpty())
        <div class="space-y-16">
            @foreach ($groups as $groupKey => $services)
                @php
                    $groupEnum = \App\Enums\ServiceGroup::tryFrom($groupKey);
                    $groupTitle = $groupEnum ? $groupEnum->label() : ucfirst($groupKey);
                @endphp
                <section aria-labelledby="grup-{{ $groupKey }}">
                    <div class="border-b border-line pb-4">
                        <h2 id="grup-{{ $groupKey }}" class="font-heading text-(length:--text-h2) font-bold text-ink">
                            {{ $groupTitle }}
                        </h2>
                    </div>

                    <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($services as $service)
                            <article class="flex flex-col justify-between rounded-xl border border-line bg-white p-6 shadow-sm transition hover:shadow-md">
                                <div>
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 px-2.5 py-1 text-xs font-semibold text-brand-700">
                                            <x-icon name="shield" class="size-3.5" />
                                            {{ $groupTitle }}
                                        </span>
                                    </div>

                                    <h3 class="mt-4 font-heading text-xl font-bold text-ink">
                                        {{ $service->name }}
                                    </h3>

                                    <p class="mt-2 text-sm leading-relaxed text-muted">
                                        {{ $service->description }}
                                    </p>

                                    @if ($service->who_can_request || $service->how_to_request || $service->response_target || $service->hours)
                                        <dl class="mt-6 space-y-3 border-t border-line/70 pt-4 text-xs">
                                            @if ($service->who_can_request)
                                                <div class="flex items-start gap-2 text-ink">
                                                    <x-icon name="user" class="mt-0.5 size-4 shrink-0 text-brand-700" />
                                                    <div>
                                                        <dt class="font-semibold text-muted">Pemohon:</dt>
                                                        <dd>{{ $service->who_can_request }}</dd>
                                                    </div>
                                                </div>
                                            @endif

                                            @if ($service->how_to_request)
                                                <div class="flex items-start gap-2 text-ink">
                                                    <x-icon name="file-text" class="mt-0.5 size-4 shrink-0 text-brand-700" />
                                                    <div>
                                                        <dt class="font-semibold text-muted">Prosedur:</dt>
                                                        <dd>{{ $service->how_to_request }}</dd>
                                                    </div>
                                                </div>
                                            @endif

                                            @if ($service->response_target)
                                                <div class="flex items-start gap-2 text-ink">
                                                    <x-icon name="clock" class="mt-0.5 size-4 shrink-0 text-brand-700" />
                                                    <div>
                                                        <dt class="font-semibold text-muted">Target Respons:</dt>
                                                        <dd>{{ $service->response_target }}</dd>
                                                    </div>
                                                </div>
                                            @endif

                                            @if ($service->hours)
                                                <div class="flex items-start gap-2 text-ink">
                                                    <x-icon name="calendar" class="mt-0.5 size-4 shrink-0 text-brand-700" />
                                                    <div>
                                                        <dt class="font-semibold text-muted">Jam Layanan:</dt>
                                                        <dd>{{ $service->hours }}</dd>
                                                    </div>
                                                </div>
                                            @endif
                                        </dl>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endforeach
        </div>
    @else
        <div class="rounded-xl border border-line bg-surface p-8 text-center">
            <x-icon name="info" class="mx-auto size-8 text-brand-700" />
            <h2 class="mt-3 font-heading text-lg font-semibold text-ink">Katalog Layanan Sedang Dipersiapkan</h2>
            <p class="mt-1 text-sm text-muted">Daftar rincian layanan sedang diverifikasi oleh tim pengelola CSIRT Kota Pariaman.</p>
        </div>
    @endif

    {{-- Callout Bantuan Darurat --}}
    <section aria-labelledby="bantuan-darurat-judul" class="mt-16 rounded-2xl bg-navy-900 p-8 text-white sm:p-10">
        <div class="flex flex-col items-start justify-between gap-6 md:flex-row md:items-center">
            <div class="max-w-[640px]">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-accent-400">
                    <x-icon name="alert" class="size-3.5" />
                    Respons Cepat Insiden
                </span>
                <h2 id="bantuan-darurat-judul" class="mt-3 font-heading text-2xl font-bold tracking-tight text-white sm:text-3xl">
                    Perangkat Daerah Mengalami Insiden Siber?
                </h2>
                <p class="mt-2 text-sm text-on-navy-muted sm:text-base">
                    Segera laporkan insiden melalui saluran pelaporan resmi. Tim CSIRT Kota Pariaman akan segera melakukan triase dan pendampingan mitigasi.
                </p>
            </div>
            <div class="shrink-0">
                <x-button :href="$reportUrl" variant="gold" class="w-full sm:w-auto">
                    Laporkan Insiden Sekarang
                </x-button>
            </div>
        </div>
    </section>
</x-container>
@endsection
