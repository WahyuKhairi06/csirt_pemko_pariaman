{{-- Halaman 404 (FR-52): pesan ramah, jalan kembali ke beranda, dan pintasan ke tujuan Lapor Insiden. --}}
@extends('layouts.app')

@section('title', 'Halaman tidak ditemukan')

@section('content')
    <x-container class="py-16 lg:py-24">
        <p class="text-sm font-semibold uppercase tracking-wide text-brand-700">Kesalahan 404</p>
        <h1 class="mt-2 font-heading text-(length:--text-h1) font-bold leading-tight text-ink">Halaman ini tidak ditemukan</h1>
        <p class="mt-4 max-w-[60ch] text-lg text-muted">Mungkin alamatnya sudah berubah atau halaman belum diterbitkan. Silakan kembali ke beranda.</p>
        <div class="mt-8 flex flex-wrap gap-3">
            <x-button href="/">Kembali ke beranda</x-button>
            <x-button :href="$reportUrl" variant="outline">{{ $site['report.cta_label'] ?? 'Pengaduan' }}</x-button>
        </div>
    </x-container>
@endsection
