{{-- Blok: Kontak Darurat & Kontak Keamanan (DESIGN.md 8.1 #9, 8.5). Data dari Pengaturan Situs. --}}
@php
    $address = \App\Support\Settings::publicValue('contact.address');
    $phone = \App\Support\Settings::publicValue('contact.phone');
    $emergencyPhone = \App\Support\Settings::publicValue('contact.emergency_phone');
    $hours = \App\Support\Settings::publicValue('contact.hours');
    $emailSecurity = \App\Support\Settings::publicValue('contact.email_security');
    $pgpFingerprint = \App\Support\Settings::publicValue('pgp.fingerprint');
@endphp

<section class="bg-surface/70 py-16" aria-labelledby="kontak-csirt-judul">
    <x-container>
        <div class="border-b border-line pb-4">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-700">
                <x-icon name="phone" class="size-3.5" />
                Hubungi Kami
            </span>
            <h2 id="kontak-csirt-judul" class="mt-3 font-heading text-(length:--text-h2) font-bold tracking-tight text-ink">
                Kontak Resmi CSIRT Kota Pariaman
            </h2>
            <p class="mt-1 text-sm text-muted">
                Saluran komunikasi resmi untuk koordinasi pengamanan sistem informasi dan penanganan kedaruratan siber.
            </p>
        </div>

        <div class="mt-8 grid gap-8 md:grid-cols-2">
            {{-- Kolom Kiri: Layanan Umum & Kantor --}}
            <div class="rounded-xl border border-line bg-white p-6 shadow-sm">
                <h3 class="font-heading text-lg font-bold text-ink">
                    Layanan Penanganan Insiden & Kantor
                </h3>
                <p class="mt-1 text-xs text-muted">Sekretariat Diskominfo Pemerintah Kota Pariaman</p>

                <dl class="mt-6 space-y-4 text-sm">
                    @if ($address)
                        <div class="flex items-start gap-3">
                            <x-icon name="map-pin" class="mt-1 size-5 shrink-0 text-brand-700" />
                            <div>
                                <dt class="text-xs font-semibold text-muted">Alamat Kantor:</dt>
                                <dd class="mt-0.5 text-ink font-medium">{{ $address }}</dd>
                            </div>
                        </div>
                    @endif

                    @if ($emergencyPhone)
                        <div class="flex items-start gap-3">
                            <x-icon name="alert" class="mt-1 size-5 shrink-0 text-danger" />
                            <div>
                                <dt class="text-xs font-semibold text-muted">Telepon Darurat (24/7):</dt>
                                <dd class="mt-0.5 font-mono text-base font-bold text-danger">
                                    @if ($href = \App\Support\Settings::telHref($emergencyPhone))
                                        <a href="{{ $href }}" class="underline hover:text-danger/80">
                                            {{ $emergencyPhone }}
                                        </a>
                                    @else
                                        <span>{{ $emergencyPhone }}</span>
                                    @endif
                                </dd>
                            </div>
                        </div>
                    @endif

                    @if ($phone)
                        <div class="flex items-start gap-3">
                            <x-icon name="phone" class="mt-1 size-5 shrink-0 text-brand-700" />
                            <div>
                                <dt class="text-xs font-semibold text-muted">Telepon Kantor:</dt>
                                <dd class="mt-0.5 font-mono text-ink">
                                    @if ($href = \App\Support\Settings::telHref($phone))
                                        <a href="{{ $href }}" class="underline hover:text-brand-900">
                                            {{ $phone }}
                                        </a>
                                    @else
                                        <span>{{ $phone }}</span>
                                    @endif
                                </dd>
                            </div>
                        </div>
                    @endif

                    @if ($hours)
                        <div class="flex items-start gap-3">
                            <x-icon name="clock" class="mt-1 size-5 shrink-0 text-brand-700" />
                            <div>
                                <dt class="text-xs font-semibold text-muted">Jam Pelayanan:</dt>
                                <dd class="mt-0.5 text-ink">{{ $hours }}</dd>
                            </div>
                        </div>
                    @endif
                </dl>
            </div>

            {{-- Kolom Kanan: Kontak Keamanan & PGP (RFC 9116 / Vulnerability Disclosure) --}}
            <div class="rounded-xl border border-line bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <h3 class="font-heading text-lg font-bold text-ink">
                        Kontak Keamanan Siber & PGP
                    </h3>
                    <span class="rounded bg-brand-50 px-2 py-0.5 text-[11px] font-mono font-semibold text-brand-700">RFC 9116</span>
                </div>
                <p class="mt-1 text-xs text-muted">Saluran terenkripsi bagi peneliti keamanan informasi</p>

                <dl class="mt-6 space-y-4 text-sm">
                    @if ($emailSecurity)
                        <div class="flex items-start gap-3">
                            <x-icon name="mail" class="mt-1 size-5 shrink-0 text-brand-700" />
                            <div>
                                <dt class="text-xs font-semibold text-muted">Email Keamanan:</dt>
                                <dd class="mt-0.5 font-mono text-ink">
                                    @if ($href = \App\Support\Settings::mailHref($emailSecurity))
                                        <a href="{{ $href }}" class="underline hover:text-brand-900">
                                            {{ $emailSecurity }}
                                        </a>
                                    @else
                                        <span>{{ $emailSecurity }}</span>
                                    @endif
                                </dd>
                            </div>
                        </div>
                    @endif

                    @if ($pgpFingerprint)
                        <div class="flex items-start gap-3">
                            <x-icon name="key" class="mt-1 size-5 shrink-0 text-brand-700" />
                            <div class="w-full">
                                <div class="flex items-center justify-between">
                                    <dt class="text-xs font-semibold text-muted">PGP Key Fingerprint:</dt>
                                    @if (! \App\Support\Settings::isPlaceholder($pgpFingerprint))
                                        <button type="button"
                                                data-copy="{{ $pgpFingerprint }}"
                                                class="text-xs font-semibold text-brand-700 hover:text-brand-900 focus-visible:outline-2 focus-visible:outline-brand-700">
                                            Salin
                                        </button>
                                    @endif
                                </div>
                                <dd class="mt-1.5 rounded-lg border border-line bg-surface p-2.5 font-mono text-xs text-ink break-all">
                                    {{ $pgpFingerprint }}
                                </dd>
                            </div>
                        </div>
                    @endif

                    <div class="border-t border-line/70 pt-4">
                        <a href="{{ route('security.txt') }}"
                           class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-700 hover:text-brand-900 underline underline-offset-4 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700">
                            <x-icon name="file-text" class="size-3.5" />
                            <span>Lihat /.well-known/security.txt (RFC 9116)</span>
                        </a>
                    </div>
                </dl>
            </div>
        </div>
    </x-container>
</section>
