{{-- Blok: Tiga langkah melapor (DESIGN.md 8.1 #4, 7.5). Data: heading (opsional), items[] (opsional) --}}
@php
    $heading = $data['heading'] ?? 'Alur Pelaporan Insiden Siber';
    $items = $data['items'] ?? [
        [
            'number' => '1',
            'title' => 'Siapkan Informasi',
            'desc' => 'Catat alamat sistem/website yang terdampak, perkiraan waktu kejadian, dan simpan tangkapan layar bukti.',
        ],
        [
            'number' => '2',
            'title' => 'Hubungi Kanal Resmi',
            'desc' => 'Sampaikan laporan melalui kanal email, WhatsApp, atau telepon darurat CSIRT Kota Pariaman.',
        ],
        [
            'number' => '3',
            'title' => 'Penanganan & Pemulihan',
            'desc' => 'Tim teknis CSIRT memverifikasi laporan, menilai dampak ancaman, dan mendampingi langkah mitigasi.',
        ],
    ];
@endphp
<section class="bg-white py-16 border-b border-line/60" aria-labelledby="langkah-melapor-judul">
    <x-container>
        <div class="text-center max-w-[640px] mx-auto">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-700">
                <x-icon name="shield" class="size-3.5" />
                Pedoman Tanggap Darurat
            </span>
            <h2 id="langkah-melapor-judul" class="mt-3 font-heading text-(length:--text-h2) font-bold tracking-tight text-ink">
                {{ $heading }}
            </h2>
            <p class="mt-2 text-muted text-sm sm:text-base">
                Ikuti langkah mudah ini saat mendeteksi indikasi peretasan, kebocoran data, atau gangguan sistem elektronik.
            </p>
        </div>

        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($items as $item)
                <article class="relative flex flex-col justify-between rounded-xl border border-line bg-surface/50 p-6 shadow-sm transition hover:bg-white hover:shadow-md">
                    <div>
                        <div class="flex size-10 items-center justify-center rounded-full bg-brand-700 font-heading text-lg font-bold text-white shadow-sm">
                            {{ $item['number'] ?? $loop->iteration }}
                        </div>
                        <h3 class="mt-4 font-heading text-lg font-bold text-ink">
                            {{ $item['title'] }}
                        </h3>
                        <p class="mt-2 text-sm leading-relaxed text-muted">
                            {{ $item['desc'] ?? $item['description'] ?? '' }}
                        </p>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-10 text-center">
            <a href="{{ url('/saluran-pelaporan') }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-brand-700 underline underline-offset-4 hover:text-brand-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700">
                <span>Pelajari rincian saluran pelaporan resmi</span>
                <x-icon name="arrow-right" class="size-4" />
            </a>
        </div>
    </x-container>
</section>
