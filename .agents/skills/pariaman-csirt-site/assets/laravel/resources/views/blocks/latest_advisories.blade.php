{{-- Blok: advisori terbaru. Data: heading, count (1-6, bawaan 3). Kueri di view hanya untuk contoh;
     bila ramai, pindahkan ke komponen Blade berkelas atau View Composer. --}}
@php
    $count = max(1, min(6, (int) ($data['count'] ?? 3)));
    $advisories = \App\Models\Advisory::published()
        ->orderByRaw('COALESCE(published_at, created_at) DESC')
        ->limit($count)
        ->get();
@endphp
@if ($advisories->isNotEmpty())
    <section class="bg-surface py-12">
        <div class="mx-auto max-w-[1200px] px-4">
            <h2 class="font-heading text-2xl font-bold text-ink">{{ $data['heading'] ?? 'Advisori terbaru' }}</h2>
            <div class="mt-6 grid gap-4 md:grid-cols-3">
                @foreach ($advisories as $advisory)
                    <article class="rounded-lg border border-line bg-white p-6 shadow-sm">
                        <x-badge-severity :severity="$advisory->severity" />
                        <h3 class="mt-3 font-heading text-lg font-semibold text-ink">
                            <a href="{{ route('advisories.show', $advisory->slug) }}" class="text-brand-700 hover:text-brand-900">
                                {{ $advisory->title }}
                            </a>
                        </h3>
                        <p class="mt-2 line-clamp-2 text-sm text-muted">{{ $advisory->summary }}</p>
                        <p class="mt-3 text-sm text-muted">
                            {{ ($advisory->published_at ?? $advisory->created_at)->translatedFormat('j F Y') }}
                        </p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif
