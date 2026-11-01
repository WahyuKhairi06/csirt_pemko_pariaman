{{-- Blok: Daftar Dokumen per Kategori (CMS-SPEC.md 4). Data: heading, category --}}
@php
    $heading = $data['heading'] ?? 'Daftar Dokumen';
    $cat = $data['category'] ?? null;
    $documents = \App\Models\Document::published()
        ->when($cat, fn ($q) => $q->where('category', $cat))
        ->orderBy('sort')
        ->orderBy('title')
        ->get();
@endphp

@if ($documents->isNotEmpty())
    <section class="py-8" aria-labelledby="doc-list-heading">
        <h2 id="doc-list-heading" class="font-heading text-xl font-bold text-ink">
            {{ $heading }}
        </h2>

        <div class="mt-4 grid gap-3">
            @foreach ($documents as $doc)
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 rounded-lg border border-line bg-white p-4 shadow-sm">
                    <div class="space-y-1">
                        <h3 class="font-heading text-base font-semibold text-ink">
                            {{ $doc->title }}
                        </h3>
                        @if ($doc->version || $doc->effective_date)
                            <div class="flex flex-wrap items-center gap-2 text-xs text-muted">
                                @if ($doc->version)
                                    <span>Versi {{ $doc->version }}</span>
                                    <span>•</span>
                                @endif
                                @if ($doc->effective_date)
                                    <span>Berlaku: {{ $doc->effective_date->translatedFormat('j F Y') }}</span>
                                @endif
                            </div>
                        @endif
                    </div>
                    <a href="{{ $doc->url() }}"
                       target="_blank"
                       rel="noopener"
                       class="inline-flex min-h-[40px] items-center gap-1.5 rounded-md bg-brand-700 px-4 py-2 text-xs font-semibold text-white hover:bg-brand-900 focus-visible:outline-2 focus-visible:outline-brand-700 shrink-0">
                        <x-icon name="download" class="size-3.5" />
                        <span>Unduh Dokumen</span>
                    </a>
                </div>
            @endforeach
        </div>
    </section>
@endif
