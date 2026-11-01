@extends('layouts.app')

@section('title', 'Dokumen Resmi & RFC-2350')
@section('description', 'Pusat unduhan dokumen resmi, standar RFC-2350, regulasi, dan prosedur operasional standar penanganan insiden CSIRT Kota Pariaman.')

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
                <li aria-current="page" class="font-medium text-ink">Dokumen</li>
            </ol>
        </nav>
        <h1 class="mt-4 font-heading text-(length:--text-h1) font-bold tracking-tight text-ink">
            Dokumen Resmi & RFC-2350
        </h1>
        <p class="mt-3 max-w-[720px] text-lg text-muted">
            Pusat publikasi dokumen resmi, profil dan mandat CSIRT berbasis standar IETF RFC-2350, regulasi keamanan informasi, serta panduan teknis operasional.
        </p>
    </x-container>
</div>

<x-container class="py-12">
    @if ($groups->isNotEmpty())
        <div class="space-y-16">
            @foreach ($groups as $catKey => $documents)
                @php
                    $catEnum = \App\Enums\DocumentCategory::tryFrom($catKey);
                    $catTitle = $catEnum ? $catEnum->label() : ucfirst($catKey);
                @endphp
                <section aria-labelledby="kat-{{ $catKey }}">
                    <div class="border-b border-line pb-4">
                        <div class="flex items-center gap-2">
                            <x-icon name="file-text" class="size-6 text-brand-700" />
                            <h2 id="kat-{{ $catKey }}" class="font-heading text-(length:--text-h2) font-bold text-ink">
                                {{ $catTitle }}
                            </h2>
                        </div>
                        @if ($catKey === 'rfc2350')
                            <p class="mt-2 text-sm text-muted">
                                Dokumen RFC-2350 merinci profil resmi, mandat, kebijakan pelaporan, kontak komunikasi terenkripsi, dan jenis layanan yang disediakan oleh tim tanggap insiden CSIRT Kota Pariaman sesuai standar global.
                            </p>
                        @endif
                    </div>

                    <div class="mt-6 grid gap-4">
                        @foreach ($documents as $doc)
                            <article class="flex flex-col justify-between gap-4 rounded-xl border border-line bg-white p-6 shadow-sm transition hover:shadow-md sm:flex-row sm:items-center">
                                <div class="space-y-2">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="inline-flex items-center rounded-md bg-surface px-2.5 py-1 text-xs font-semibold text-ink border border-line/70">
                                            {{ $catTitle }}
                                        </span>
                                        @if ($doc->version)
                                            <span class="inline-flex items-center rounded-md bg-brand-50 px-2 py-0.5 text-xs font-mono font-medium text-brand-700">
                                                Versi {{ $doc->version }}
                                            </span>
                                        @endif
                                        <span class="inline-flex items-center rounded-md bg-surface px-2 py-0.5 text-xs font-semibold uppercase text-muted border border-line/50">
                                            {{ $doc->language }}
                                        </span>
                                    </div>

                                    <h3 class="font-heading text-lg font-bold text-ink">
                                        {{ $doc->title }}
                                    </h3>

                                    @if ($doc->effective_date)
                                        <p class="text-xs text-muted">
                                            Tanggal berlaku: {{ $doc->effective_date->translatedFormat('j F Y') }}
                                        </p>
                                    @endif
                                </div>

                                <div class="shrink-0 pt-2 sm:pt-0">
                                    <a href="{{ $doc->url() }}"
                                       target="_blank"
                                       rel="noopener"
                                       class="inline-flex min-h-[44px] items-center gap-2 rounded-lg bg-brand-700 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700">
                                        <x-icon name="download" class="size-4" />
                                        <span>Unduh Berkas</span>
                                        <span class="sr-only">({{ $doc->title }})</span>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endforeach
        </div>
    @else
        <div class="rounded-xl border border-line bg-surface p-8 text-center">
            <x-icon name="file-text" class="mx-auto size-8 text-brand-700" />
            <h2 class="mt-3 font-heading text-lg font-semibold text-ink">Dokumen Sedang Dipersiapkan</h2>
            <p class="mt-1 text-sm text-muted">Dokumen resmi dan RFC-2350 sedang dalam proses verifikasi akhir oleh tim CSIRT Kota Pariaman.</p>
        </div>
    @endif
</x-container>
@endsection
