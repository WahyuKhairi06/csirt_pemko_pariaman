@extends('layouts.app')

@section('title', $type->label())
@section('description', 'Publikasi dan artikel ' . strtolower($type->label()) . ' resmi dari CSIRT Pemerintah Kota Pariaman.')

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
                <li aria-current="page" class="font-medium text-ink">{{ $type->label() }}</li>
            </ol>
        </nav>
        <h1 class="mt-4 font-heading text-(length:--text-h1) font-bold tracking-tight text-ink">
            {{ $type->label() }}
        </h1>
        <p class="mt-3 max-w-[720px] text-lg text-muted">
            @if ($type === \App\Enums\PostType::News)
                Informasi terkini mengenai kegiatan, pengumuman, dan perkembangan penanganan keamanan siber di lingkungan Pemerintah Kota Pariaman.
            @else
                Materi panduan, literasi digital, dan tips pencegahan insiden siber bagi aparatur sipil negara dan masyarakat.
            @endif
        </p>
    </x-container>
</div>

<x-container class="py-12">
    @if ($posts->isNotEmpty())
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($posts as $post)
                <article class="flex flex-col justify-between overflow-hidden rounded-xl border border-line bg-white shadow-sm transition hover:shadow-md">
                    <div>
                        {{-- Cover Image / Graphic --}}
                        <div class="relative aspect-video w-full overflow-hidden bg-brand-900/5">
                            @if ($post->cover)
                                <img src="{{ Storage::disk('public')->url($post->cover) }}"
                                     alt="{{ $post->cover_alt ?? $post->title }}"
                                     class="size-full object-cover transition hover:scale-105"
                                     loading="lazy">
                            @else
                                <div class="flex size-full items-center justify-center bg-surface text-brand-700">
                                    <x-icon name="shield" class="size-12 opacity-40" />
                                </div>
                            @endif
                        </div>

                        <div class="p-6">
                            <div class="flex flex-wrap items-center gap-2 text-xs">
                                @if ($post->category)
                                    <span class="rounded-md bg-brand-50 px-2 py-0.5 font-semibold text-brand-700">
                                        {{ $post->category->name }}
                                    </span>
                                @endif
                                <time datetime="{{ ($post->published_at ?? $post->created_at)->toDateString() }}" class="text-muted">
                                    {{ ($post->published_at ?? $post->created_at)->translatedFormat('j F Y') }}
                                </time>
                            </div>

                            <h3 class="mt-3 font-heading text-lg font-bold text-ink">
                                <a href="{{ route('posts.show', [$type->path(), $post->slug]) }}"
                                   class="hover:text-brand-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700">
                                    {{ $post->title }}
                                </a>
                            </h3>

                            @if ($post->excerpt)
                                <p class="mt-2 text-sm leading-relaxed text-muted line-clamp-2">
                                    {{ $post->excerpt }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="border-t border-line/70 px-6 py-4">
                        <a href="{{ route('posts.show', [$type->path(), $post->slug]) }}"
                           class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-700 hover:text-brand-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700">
                            <span>Baca Selengkapnya</span>
                            <x-icon name="arrow-right" class="size-3.5" />
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    @else
        <div class="rounded-xl border border-line bg-surface p-8 text-center">
            <x-icon name="info" class="mx-auto size-8 text-brand-700" />
            <h2 class="mt-3 font-heading text-lg font-semibold text-ink">Belum Ada Artikel Dipublikasikan</h2>
            <p class="mt-1 text-sm text-muted">Artikel {{ strtolower($type->label()) }} akan segera hadir.</p>
        </div>
    @endif
</x-container>
@endsection
