@extends('layouts.app')

@section('title', $post->title)
@section('description', $post->excerpt)

@php
    $embedUrl = null;
    if ($post->video_url) {
        // Parse YouTube video ID and build privacy-enhanced nocookie embed URL
        if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/', $post->video_url, $matches)) {
            $embedUrl = 'https://www.youtube-nocookie.com/embed/' . $matches[1];
        }
    }
@endphp

@section('content')
@if (! empty($preview))
    <div role="status" class="border-l-4 border-accent-400 bg-accent-100 px-4 py-2 text-sm text-ink">
        Pratinjau: artikel ini belum tayang untuk publik.
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
                    <a href="{{ route('posts.index', $type->path()) }}" class="rounded-sm text-brand-700 underline underline-offset-4 hover:text-brand-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700">
                        {{ $type->label() }}
                    </a>
                </li>
                <li aria-hidden="true" class="text-muted/60">/</li>
                <li aria-current="page" class="font-medium text-ink line-clamp-1 max-w-[300px]">
                    {{ $post->title }}
                </li>
            </ol>
        </nav>

        <div class="mt-4 flex flex-wrap items-center gap-3 text-xs">
            @if ($post->category)
                <span class="rounded-md bg-brand-50 px-2.5 py-1 font-semibold text-brand-700">
                    {{ $post->category->name }}
                </span>
            @endif
            <time datetime="{{ ($post->published_at ?? $post->created_at)->toDateString() }}" class="text-muted">
                Diterbitkan pada {{ ($post->published_at ?? $post->created_at)->translatedFormat('j F Y') }}
            </time>
        </div>

        <h1 class="mt-3 font-heading text-(length:--text-h1) font-bold tracking-tight text-ink">
            {{ $post->title }}
        </h1>
    </x-container>
</div>

<x-container class="py-12">
    <article class="mx-auto max-w-[720px] space-y-8">
        {{-- Cover Image --}}
        @if ($post->cover)
            <figure class="overflow-hidden rounded-xl border border-line bg-surface shadow-sm">
                <img src="{{ Storage::disk('public')->url($post->cover) }}"
                     alt="{{ $post->cover_alt ?? $post->title }}"
                     class="w-full object-cover">
                @if ($post->cover_alt && $post->cover_alt !== $post->title)
                    <figcaption class="p-3 text-center text-xs text-muted">
                        {{ $post->cover_alt }}
                    </figcaption>
                @endif
            </figure>
        @endif

        {{-- Video Embed --}}
        @if ($embedUrl)
            <div class="relative aspect-video w-full overflow-hidden rounded-xl border border-line bg-navy-900 shadow-sm">
                <iframe src="{{ $embedUrl }}"
                        title="Video Edukasi: {{ $post->title }}"
                        class="size-full border-0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                        loading="lazy">
                </iframe>
            </div>
        @endif

        {{-- Rich Text Body --}}
        <div class="prose prose-slate max-w-none text-ink leading-relaxed">
            {!! \App\Support\Html::clean($post->body) !!}
        </div>

        {{-- Unduhan / Lampiran --}}
        @if ($post->download)
            <div class="rounded-xl border border-line bg-surface p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-3">
                    <x-icon name="file-text" class="size-6 text-brand-700" />
                    <div>
                        <h2 class="text-sm font-bold text-ink">Materi Lampiran</h2>
                        <p class="text-xs text-muted">Berkas unduhan resmi pendukung artikel.</p>
                    </div>
                </div>
                <a href="{{ Storage::disk('public')->url($post->download) }}"
                   target="_blank"
                   rel="noopener"
                   class="inline-flex min-h-[44px] items-center gap-2 rounded-lg bg-brand-700 px-4 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-brand-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700">
                    <x-icon name="download" class="size-4" />
                    <span>Unduh Lampiran</span>
                </a>
            </div>
        @endif

        <div class="border-t border-line pt-6">
            <a href="{{ route('posts.index', $type->path()) }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-brand-700 hover:text-brand-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700">
                <x-icon name="arrow-right" class="size-4 rotate-180" />
                <span>Kembali ke daftar {{ strtolower($type->label()) }}</span>
            </a>
        </div>
    </article>
</x-container>
@endsection
