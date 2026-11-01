{{-- Blok: Kartu Layanan (DESIGN.md 8.1 #5, CMS-SPEC.md 4). Data: heading (opsional), count (1-6) --}}
@php
    $heading = $data['heading'] ?? 'Layanan Keamanan Siber';
    $count = max(1, min(6, (int) ($data['count'] ?? 3)));
    $services = \App\Models\Service::published()
        ->orderBy('sort')
        ->orderBy('name')
        ->limit($count)
        ->get();
@endphp

@if ($services->isNotEmpty())
    <section class="bg-surface/60 py-16 border-b border-line/60" aria-labelledby="layanan-kami-judul">
        <x-container>
            <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-end">
                <div>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-700">
                        <x-icon name="shield" class="size-3.5" />
                        Katalog Layanan
                    </span>
                    <h2 id="layanan-kami-judul" class="mt-3 font-heading text-(length:--text-h2) font-bold tracking-tight text-ink">
                        {{ $heading }}
                    </h2>
                    <p class="mt-1 text-sm text-muted">
                        Dukungan teknis responsif dan preventif bagi instansi pemerintah di Kota Pariaman.
                    </p>
                </div>
                <a href="{{ route('services.index') }}"
                   class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700 hover:text-brand-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700">
                    <span>Lihat Semua Layanan</span>
                    <x-icon name="arrow-right" class="size-4" />
                </a>
            </div>

            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($services as $service)
                    <article class="flex flex-col justify-between rounded-xl border border-line bg-white p-6 shadow-sm transition hover:shadow-md">
                        <div>
                            <span class="inline-flex items-center gap-1 rounded-md bg-surface px-2.5 py-1 text-xs font-semibold text-brand-700">
                                {{ $service->group->label() }}
                            </span>
                            <h3 class="mt-3 font-heading text-lg font-bold text-ink">
                                {{ $service->name }}
                            </h3>
                            <p class="mt-2 text-sm leading-relaxed text-muted line-clamp-3">
                                {{ $service->description }}
                            </p>
                        </div>
                        <div class="mt-6 border-t border-line/60 pt-4 text-xs text-muted">
                            <span class="font-medium text-ink">Target Respons:</span> {{ $service->response_target ?? 'Sesuai SLA' }}
                        </div>
                    </article>
                @endforeach
            </div>
        </x-container>
    </section>
@endif
