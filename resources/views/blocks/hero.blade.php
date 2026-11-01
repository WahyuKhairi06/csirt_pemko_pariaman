{{-- Blok: hero (DESIGN.md bagian 8.1). Data: title, subtitle (bila kosong memakai Pengaturan hero.*),
     image, image_alt (bila kosong memakai Pengaturan hero.image*), primary_label, secondary_label, secondary_url.
     Gambar sampul tampil penuh (full-bleed background) menutup area biru navy dengan teks & tombol rata tengah di depan. --}}
@php
    $title = ! empty($data['title']) ? $data['title'] : ($site['hero.title'] ?? '');
    $subtitle = ! empty($data['subtitle']) ? $data['subtitle'] : ($site['hero.subtitle'] ?? '');
    $heroImage = ! empty($data['image']) ? $data['image'] : ($site['hero.image'] ?? null);
    $heroImageAlt = ! empty($data['image_alt']) ? $data['image_alt'] : ($site['hero.image_alt'] ?? ($title ?: 'Foto Sampul CSIRT Kota Pariaman'));
    $primaryLabel = $site['report.cta_label'] ?? (($data['primary_label'] ?? 'Pengaduan') === 'Lapor Insiden' ? 'Pengaduan' : ($data['primary_label'] ?? 'Pengaduan'));
    $ctaExternal = preg_match('#^https?://#i', (string) $reportUrl) === 1;
    $ctaNewTab = ! empty($site['report.cta_new_tab']) || $ctaExternal;
    $secondaryUrl = (string) ($data['secondary_url'] ?? '');
    $secondaryUrl = (str_starts_with($secondaryUrl, '/') && ! str_starts_with($secondaryUrl, '//')) ? $secondaryUrl : '';
@endphp
<section class="on-navy relative flex min-h-[420px] items-center justify-center overflow-hidden bg-navy-900 text-white md:min-h-[500px]">
    @if ($heroImage)
        <img src="{{ Storage::disk('public')->url($heroImage) }}"
             alt="{{ $heroImageAlt }}"
             class="absolute inset-0 size-full object-cover object-center">
        <div class="absolute inset-0 bg-navy-900/70" aria-hidden="true"></div>
    @endif

    <x-container class="relative z-10 w-full py-16 text-center md:py-24">
        <div class="mx-auto max-w-3xl">
            <h1 class="font-heading text-(length:--text-display) font-extrabold leading-[1.15] drop-shadow-sm">{{ $title }}</h1>
            <p class="mx-auto mt-4 max-w-[60ch] text-lg text-white/90 drop-shadow-xs">{{ $subtitle }}</p>
            <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                <x-button :href="$reportUrl"
                          variant="gold"
                          size="lg"
                          :target="$ctaNewTab ? '_blank' : null"
                          :rel="$ctaNewTab ? 'noopener noreferrer' : null">
                    <x-icon name="shield" class="size-5" />
                    {{ $primaryLabel }}
                    @if ($ctaExternal)
                        <x-icon name="external" class="size-4 shrink-0" />
                    @endif
                </x-button>
                @if ($secondaryUrl !== '' && ! empty($data['secondary_label']))
                    <x-button :href="$secondaryUrl" variant="outline-light" size="lg">
                        {{ $data['secondary_label'] }}
                    </x-button>
                @endif
            </div>
        </div>
    </x-container>
</section>
