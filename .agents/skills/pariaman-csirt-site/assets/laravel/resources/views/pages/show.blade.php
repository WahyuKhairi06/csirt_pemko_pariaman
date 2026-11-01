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
        <header class="mx-auto max-w-[1200px] px-4 pb-4 pt-12">
            <h1 class="font-heading text-3xl font-bold text-ink">{{ $page->title }}</h1>
        </header>
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
