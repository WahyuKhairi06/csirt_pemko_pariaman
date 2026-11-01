@extends('layouts.app')

@section('title', $advisory->title)
@section('description', $advisory->summary)

@section('content')
@if (! empty($preview))
    <div role="status" class="border-l-4 border-accent-400 bg-accent-100 px-4 py-2 text-sm text-ink">
        Pratinjau: advisori ini belum tayang untuk publik.
    </div>
@endif

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
                <li>
                    <a href="{{ route('advisories.index') }}" class="rounded-sm text-brand-700 underline underline-offset-4 hover:text-brand-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700">
                        Advisori
                    </a>
                </li>
                <li aria-hidden="true" class="text-muted/60">/</li>
                <li aria-current="page" class="font-medium text-ink line-clamp-1 max-w-[300px]">
                    {{ $advisory->title }}
                </li>
            </ol>
        </nav>

        <div class="mt-4 flex flex-wrap items-center gap-3">
            <x-badge-severity :severity="$advisory->severity" />
            <time datetime="{{ ($advisory->published_at ?? $advisory->created_at)->toDateString() }}" class="text-xs text-muted">
                Diterbitkan pada {{ ($advisory->published_at ?? $advisory->created_at)->translatedFormat('j F Y') }}
            </time>
        </div>

        <h1 class="mt-3 font-heading text-(length:--text-h1) font-bold tracking-tight text-ink">
            {{ $advisory->title }}
        </h1>
    </x-container>
</div>

<x-container class="py-12">
    <div class="mx-auto max-w-[760px] space-y-10">
        {{-- Ringkasan --}}
        <section aria-labelledby="ringkasan-judul" class="rounded-xl border border-line bg-white p-6 shadow-sm">
            <h2 id="ringkasan-judul" class="font-heading text-lg font-bold text-ink">
                Ringkasan Eksekutif
            </h2>
            <p class="mt-3 leading-relaxed text-muted">
                {{ $advisory->summary }}
            </p>
        </section>

        {{-- Sistem Terdampak --}}
        @if ($advisory->affected_systems)
            <section aria-labelledby="sistem-terdampak-judul" class="rounded-xl border-l-4 border-warning bg-warning-bg/40 p-6">
                <div class="flex items-start gap-3">
                    <x-icon name="alert" class="mt-0.5 size-5 shrink-0 text-warning" />
                    <div>
                        <h2 id="sistem-terdampak-judul" class="font-heading text-lg font-bold text-ink">
                            Sistem & Lingkungan Terdampak
                        </h2>
                        <div class="mt-2 text-sm leading-relaxed text-ink/90 whitespace-pre-line">
                            {{ $advisory->affected_systems }}
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Langkah Mitigasi --}}
        <section aria-labelledby="mitigasi-judul" class="rounded-xl border border-line bg-white p-6 shadow-sm">
            <h2 id="mitigasi-judul" class="font-heading text-xl font-bold text-ink">
                Langkah Mitigasi & Rekomendasi Tindakan
            </h2>
            <div class="prose prose-slate mt-4 max-w-none text-ink leading-relaxed">
                {!! \App\Support\Html::clean($advisory->mitigation) !!}
            </div>
        </section>

        {{-- Callout Pengaduan --}}
        <div class="rounded-xl border border-brand-200 bg-brand-50/60 p-6 text-brand-950 sm:flex sm:items-center sm:justify-between sm:gap-6">
            <div>
                <h3 class="font-heading text-base font-bold text-brand-900">
                    Sistem Anda Mengalami Gejala Terdampak?
                </h3>
                <p class="mt-1 text-sm text-brand-800">
                    Segera sampaikan pengaduan atau anomali ke tim CSIRT Kota Pariaman untuk pendampingan teknis.
                </p>
            </div>
            <div class="mt-4 shrink-0 sm:mt-0">
                <x-button :href="$reportUrl" variant="primary">
                    {{ $site['report.cta_label'] ?? 'Pengaduan' }}
                </x-button>
            </div>
        </div>

        <div>
            <a href="{{ route('advisories.index') }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-brand-700 hover:text-brand-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700">
                <x-icon name="arrow-right" class="size-4 rotate-180" />
                <span>Kembali ke daftar advisori</span>
            </a>
        </div>
    </div>
</x-container>
@endsection
