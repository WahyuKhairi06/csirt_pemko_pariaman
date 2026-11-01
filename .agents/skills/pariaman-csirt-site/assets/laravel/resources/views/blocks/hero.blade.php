{{-- Blok: hero (DESIGN.md bagian 8.1). Data: title, subtitle (bila kosong memakai Pengaturan hero.*),
     primary_label, secondary_label, secondary_url. Tombol utama selalu menuju tujuan Lapor Insiden dari Pengaturan ($reportUrl). --}}
@php
    $title = $data['title'] ?? ($site['hero.title'] ?? '');
    $subtitle = $data['subtitle'] ?? ($site['hero.subtitle'] ?? '');
    $secondaryUrl = (string) ($data['secondary_url'] ?? '');
    $secondaryUrl = (str_starts_with($secondaryUrl, '/') && ! str_starts_with($secondaryUrl, '//')) ? $secondaryUrl : '';
@endphp
<section class="on-navy bg-navy-900 text-white">
    <div class="mx-auto grid max-w-[1200px] gap-8 px-4 py-16 md:grid-cols-2 md:py-24">
        <div>
            <h1 class="font-heading text-4xl font-extrabold leading-tight md:text-5xl">{{ $title }}</h1>
            <p class="mt-4 max-w-[60ch] text-lg text-on-navy-muted">{{ $subtitle }}</p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ $reportUrl }}"
                   class="inline-flex min-h-[52px] items-center rounded-md bg-accent-400 px-6 font-semibold text-navy-900">
                    {{ $data['primary_label'] ?? 'Lapor Insiden' }}
                </a>
                @if ($secondaryUrl !== '' && ! empty($data['secondary_label']))
                    <a href="{{ $secondaryUrl }}"
                       class="inline-flex min-h-[52px] items-center rounded-md border-2 border-white px-6 font-semibold text-white">
                        {{ $data['secondary_label'] }}
                    </a>
                @endif
            </div>
        </div>
        {{-- Kolom kanan: ilustrasi perisai/jaringan (aset statis dari tim desain) --}}
    </div>
</section>
