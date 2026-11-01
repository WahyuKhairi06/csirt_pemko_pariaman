{{-- Footer: tiga kolom (identitas + kontak | Informasi | Media sosial), mengikuti komposisi hasil audit Tahap 2.
     Semua nilai dari Pengaturan Situs. Placeholder "[ISI: ...]" tidak pernah menjadi tautan dan disembunyikan di produksi. --}}
@props(['site' => [], 'menu' => []])
@php
    use App\Enums\ReportChannelType;
    use App\Support\Settings;

    $siteName = $site['site.name'] ?? config('app.name');
    $logoUrl = ! empty($site['site.logo']) ? Storage::disk('public')->url($site['site.logo']) : '/images/logo-pemko-pariaman.png';
    $phone = Settings::publicValue('contact.phone');
    $emergency = Settings::publicValue('contact.emergency_phone');
    $email = Settings::publicValue('contact.email_security');
    $address = Settings::publicValue('contact.address');
    $hours = Settings::publicValue('contact.hours');
    $copyright = Settings::publicValue('footer.text');

    $socials = collect(['facebook' => 'Facebook', 'instagram' => 'Instagram', 'youtube' => 'YouTube', 'x' => 'X'])
        ->map(fn ($label, $key) => ['label' => $label, 'url' => (string) ($site['social.'.$key] ?? '')])
        ->filter(fn ($s) => ReportChannelType::isHttpUrl($s['url']))
        ->map(fn ($s) => ['label' => $s['label'], 'url' => $s['url'], 'new_tab' => true]);

    $contactLine = 'flex flex-wrap gap-x-2';
    $link = 'rounded-sm underline decoration-white/40 underline-offset-4 hover:decoration-white';
@endphp
<footer class="on-navy border-t-[3px] border-accent-400 bg-navy-900 text-white">
    <x-container class="grid gap-10 py-12 md:grid-cols-2 lg:grid-cols-3 lg:py-16">
        <section aria-labelledby="footer-kontak">
            <p class="flex items-center gap-3 font-heading text-xl font-bold">
                <img src="{{ $logoUrl }}"
                     alt="Lambang Pemerintah Kota Pariaman"
                     class="h-10 w-auto shrink-0 object-contain">
                {{ $siteName }}
            </p>
            <h2 id="footer-kontak" class="sr-only">Kontak</h2>
            <address class="mt-5 space-y-2 text-on-navy-muted not-italic">
                @if ($phone)
                    <p class="{{ $contactLine }}"><strong class="font-semibold text-white">Telepon:</strong>
                        @if ($href = Settings::telHref($phone)) <a href="{{ $href }}" class="{{ $link }}">{{ $phone }}</a> @else <span>{{ $phone }}</span> @endif
                    </p>
                @endif
                @if ($emergency)
                    <p class="{{ $contactLine }}"><strong class="font-semibold text-white">Darurat:</strong>
                        @if ($href = Settings::telHref($emergency)) <a href="{{ $href }}" class="{{ $link }}">{{ $emergency }}</a> @else <span>{{ $emergency }}</span> @endif
                    </p>
                @endif
                @if ($email)
                    <p class="{{ $contactLine }}"><strong class="font-semibold text-white">Email keamanan:</strong>
                        @if ($href = Settings::mailHref($email)) <a href="{{ $href }}" class="{{ $link }}">{{ $email }}</a> @else <span>{{ $email }}</span> @endif
                    </p>
                @endif
                @if ($hours)
                    <p class="{{ $contactLine }}"><strong class="font-semibold text-white">Jam layanan:</strong> <span>{{ $hours }}</span></p>
                @endif
                @if ($address)
                    <p>{{ $address }}</p>
                @endif
            </address>
        </section>

        @if ($menu)
            <nav aria-labelledby="footer-informasi">
                <h2 id="footer-informasi" class="font-heading text-lg font-bold uppercase tracking-wide">Informasi</h2>
                <ul class="mt-4 space-y-1">
                    @foreach ($menu as $item)
                        <li>
                            <x-nav-link :item="$item" class="inline-flex min-h-11 items-center gap-1 rounded-sm uppercase text-on-navy-muted hover:text-white hover:underline aria-[current=page]:text-white" />
                        </li>
                    @endforeach
                </ul>
            </nav>
        @endif

        @if ($socials->isNotEmpty())
            <nav aria-labelledby="footer-sosial">
                <h2 id="footer-sosial" class="font-heading text-lg font-bold uppercase tracking-wide">Media sosial</h2>
                <ul class="mt-4 space-y-1">
                    @foreach ($socials as $item)
                        <li>
                            <x-nav-link :item="$item" class="inline-flex min-h-11 items-center gap-1 rounded-sm text-on-navy-muted hover:text-white hover:underline" />
                        </li>
                    @endforeach
                </ul>
            </nav>
        @endif
    </x-container>

    @if ($copyright)
        <div class="border-t border-white/15">
            <x-container class="py-5 text-center text-sm text-on-navy-muted">{{ $copyright }}</x-container>
        </div>
    @endif
</footer>
