{{-- Blok: Portal Layanan Terverifikasi (DESIGN.md 8.1 #7, CMS-SPEC.md 4). Data: heading --}}
@php
    $heading = $data['heading'] ?? 'Portal Layanan Pemerintah Kota Pariaman';
    $links = \App\Models\PortalLink::active()->get();
@endphp

@if ($links->isNotEmpty())
    <section class="bg-white py-16 border-b border-line/60" aria-labelledby="portal-layanan-judul">
        <x-container>
            <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-end">
                <div>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-700">
                        <x-icon name="globe" class="size-3.5" />
                        Integrasi Layanan Daerah
                    </span>
                    <h2 id="portal-layanan-judul" class="mt-3 font-heading text-(length:--text-h2) font-bold tracking-tight text-ink">
                        {{ $heading }}
                    </h2>
                    <p class="mt-1 text-sm text-muted">
                        Tautan terverifikasi menuju portal administrasi, layanan publik, dan keterbukaan informasi Kota Pariaman.
                    </p>
                </div>
            </div>

            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($links as $link)
                    <a href="{{ $link->url }}"
                       target="_blank"
                       rel="noopener"
                       class="group flex flex-col justify-between rounded-xl border border-line bg-surface/50 p-6 shadow-sm transition hover:border-brand-300 hover:bg-white hover:shadow-md focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700">
                        <div>
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex size-10 items-center justify-center rounded-lg bg-brand-50 text-brand-700 group-hover:bg-brand-700 group-hover:text-white transition">
                                    <x-icon name="globe" class="size-5" />
                                </div>
                                <x-icon name="external" class="size-4 text-muted group-hover:text-brand-700 transition" />
                            </div>

                            <h3 class="mt-4 font-heading text-base font-bold text-ink group-hover:text-brand-700 transition">
                                {{ $link->title }}
                            </h3>

                            @if ($link->description)
                                <p class="mt-2 text-xs leading-relaxed text-muted">
                                    {{ $link->description }}
                                </p>
                            @endif
                        </div>

                        <div class="mt-4 flex items-center gap-1 text-xs font-semibold text-brand-700">
                            <span>Kunjungi Layanan</span>
                            <span class="sr-only">(buka di tab baru)</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </x-container>
    </section>
@endif
