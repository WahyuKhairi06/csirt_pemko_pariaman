{{-- Blok: Berita & Edukasi Terbaru (DESIGN.md 8.1 #8, CMS-SPEC.md 4). Data: heading, type (opsional), count --}}
@php
    $heading = $data['heading'] ?? 'Berita & Edukasi Keamanan';
    $count = max(1, min(6, (int) ($data['count'] ?? 3)));
    $type = ! empty($data['type']) ? \App\Enums\PostType::tryFrom($data['type']) : null;

    $posts = \App\Models\Post::published()
        ->when($type, fn ($q) => $q->where('type', $type->value))
        ->with('category')
        ->orderByRaw('COALESCE(published_at, created_at) DESC')
        ->limit($count)
        ->get();
@endphp

@if ($posts->isNotEmpty())
    <section class="bg-surface/50 py-16 border-b border-line/60" aria-labelledby="berita-terbaru-judul">
        <x-container>
            <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-end">
                <div>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-700">
                        <x-icon name="file-text" class="size-3.5" />
                        Informasi Terkini
                    </span>
                    <h2 id="berita-terbaru-judul" class="mt-3 font-heading text-(length:--text-h2) font-bold tracking-tight text-ink">
                        {{ $heading }}
                    </h2>
                    <p class="mt-1 text-sm text-muted">
                        Kabar terbaru, literasi keamanan informasi, dan panduan pencegahan insiden siber.
                    </p>
                </div>
                <a href="{{ route('posts.index', 'berita') }}"
                   class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700 hover:text-brand-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700">
                    <span>Lihat Semua Berita</span>
                    <x-icon name="arrow-right" class="size-4" />
                </a>
            </div>

            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($posts as $post)
                    <article class="flex flex-col justify-between overflow-hidden rounded-xl border border-line bg-white shadow-sm transition hover:shadow-md">
                        <div>
                            <div class="relative aspect-video w-full overflow-hidden bg-brand-900/5">
                                @if ($post->cover)
                                    <img src="{{ Storage::disk('public')->url($post->cover) }}"
                                         alt="{{ $post->cover_alt ?? $post->title }}"
                                         class="size-full object-cover"
                                         loading="lazy">
                                @else
                                    <div class="flex size-full items-center justify-center bg-surface text-brand-700">
                                        <x-icon name="shield" class="size-10 opacity-30" />
                                    </div>
                                @endif
                            </div>

                            <div class="p-6">
                                <div class="flex items-center gap-2 text-xs">
                                    <span class="rounded-md bg-brand-50 px-2 py-0.5 font-semibold text-brand-700">
                                        {{ $post->type->label() }}
                                    </span>
                                    <time datetime="{{ ($post->published_at ?? $post->created_at)->toDateString() }}" class="text-muted">
                                        {{ ($post->published_at ?? $post->created_at)->translatedFormat('j F Y') }}
                                    </time>
                                </div>

                                <h3 class="mt-3 font-heading text-lg font-bold text-ink">
                                    <a href="{{ route('posts.show', [$post->type->path(), $post->slug]) }}"
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

                        <div class="border-t border-line/60 px-6 py-4">
                            <a href="{{ route('posts.show', [$post->type->path(), $post->slug]) }}"
                               class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-700 hover:text-brand-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700">
                                <span>Baca Selengkapnya</span>
                                <x-icon name="arrow-right" class="size-3.5" />
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </x-container>
    </section>
@endif
