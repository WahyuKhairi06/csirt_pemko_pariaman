{{-- Menampilkan halaman berblok dari panel admin (FR-01, FR-02, FR-42).
     Tiap blok = satu berkas di resources/views/blocks/<jenis>.blade.php. Jenis blok yang tidak dikenal diabaikan. --}}
@extends('layouts.app')

@section('title', $page->seo_title ?: $page->title)
@section('description', $page->seo_description)

@section('content')
    @if (! empty($preview))
        <div role="status" class="border-l-4 border-accent-400 bg-accent-100 px-4 py-2 text-sm text-ink">
            Pratinjau: halaman ini belum tayang untuk publik.
        </div>
    @endif

    @if ($page->template !== 'home')
        <x-container class="pb-4 pt-8">
            <nav aria-label="Remah roti">
                <ol class="flex flex-wrap items-center gap-x-2 text-sm text-muted">
                    <li><a href="/" class="rounded-sm text-brand-700 underline underline-offset-4 hover:text-brand-900">Beranda</a></li>
                    @if ($page->parent && $page->parent->isPublished())
                        <li aria-hidden="true">/</li>
                        <li><a href="/{{ $page->parent->slug }}" class="rounded-sm text-brand-700 underline underline-offset-4 hover:text-brand-900">{{ $page->parent->title }}</a></li>
                    @endif
                    <li aria-hidden="true">/</li>
                    <li aria-current="page">{{ $page->title }}</li>
                </ol>
            </nav>
            <h1 class="mt-4 font-heading text-(length:--text-h1) font-bold leading-tight text-ink">{{ $page->title }}</h1>
        </x-container>
    @endif

    @foreach (($page->blocks ?? []) as $block)
        @php
            // Nama view hanya huruf kecil dan garis bawah: data blok tidak boleh menunjuk ke view lain.
            $type = preg_replace('/[^a-z_]/', '', (string) ($block['type'] ?? ''));
        @endphp
        @if ($type !== '')
            @includeIf('blocks.'.$type, ['data' => (array) ($block['data'] ?? [])])
        @endif
    @endforeach
@endsection
