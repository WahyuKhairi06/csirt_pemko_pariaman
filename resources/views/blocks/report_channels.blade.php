{{-- Blok: kartu kanal pelaporan (DESIGN.md bagian 7.4, 7.5, 8.3). Data dari Pengaturan (report.channels, report.checklist,
     report.warning, contact.hours): diatur admin, bukan di kode. Kanal dengan nilai placeholder atau tidak valid disembunyikan. --}}
@php
    $channels = \App\Support\Settings::reportChannels();
    $checklist = (array) \App\Support\Settings::get('report.checklist', []);
    $warning = (string) \App\Support\Settings::get('report.warning', '');
    $hours = (string) \App\Support\Settings::get('contact.hours', '');

    $channelIcons = [
        \App\Enums\ReportChannelType::Email->value => 'mail',
        \App\Enums\ReportChannelType::Whatsapp->value => 'whatsapp',
        \App\Enums\ReportChannelType::Phone->value => 'phone',
        \App\Enums\ReportChannelType::Url->value => 'external',
    ];
@endphp
<section class="py-8" aria-labelledby="kanal-pelaporan-judul">
    <x-container class="!px-0 sm:!px-0 lg:!px-0">
        <h2 id="kanal-pelaporan-judul" class="sr-only">Kanal Pelaporan Resmi</h2>

        @if (count($channels) > 0)
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($channels as $channel)
                    @php
                        $icon = $channelIcons[$channel['type']->value] ?? 'shield';
                    @endphp
                    <article class="flex flex-col justify-between rounded-xl border border-line bg-white p-6 shadow-sm transition hover:shadow-md">
                        <div>
                            <div class="flex size-11 items-center justify-center rounded-lg bg-brand-50 text-brand-700">
                                <x-icon :name="$icon" class="size-5" />
                            </div>

                            <h3 class="mt-4 font-heading text-xl font-bold text-ink">
                                {{ $channel['label'] }}
                            </h3>

                            <p class="mt-2 break-all font-mono text-sm font-medium text-ink bg-surface/80 rounded-md p-2 border border-line/60">
                                {{ $channel['value'] }}
                            </p>

                            @if ($channel['hours'])
                                <p class="mt-2 text-xs text-muted">
                                    {{ $channel['hours'] }}
                                </p>
                            @endif
                        </div>

                        <div class="mt-6 flex flex-wrap gap-2 pt-2">
                            <a href="{{ $channel['href'] }}"
                               @if ($channel['type'] === \App\Enums\ReportChannelType::Url) target="_blank" rel="noopener" @endif
                               class="inline-flex min-h-[44px] flex-1 items-center justify-center rounded-lg bg-brand-700 px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700">
                                {{ $channel['type']->actionLabel() }}
                            </a>
                            <button type="button"
                                    data-copy="{{ $channel['value'] }}"
                                    class="inline-flex min-h-[44px] items-center justify-center rounded-lg border border-brand-700 px-4 text-sm font-semibold text-brand-700 transition hover:bg-brand-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700">
                                Salin
                            </button>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="rounded-xl border border-line bg-surface p-6 text-sm text-ink">
                <div class="flex items-center gap-2 font-semibold text-brand-700">
                    <x-icon name="info" class="size-5" />
                    <span>Kanal Pelaporan Belum Dikonfigurasi</span>
                </div>
                <p class="mt-1 text-muted">Pengelola situs dapat melengkapi nomor telepon, email, dan kanal WhatsApp di panel admin Pengaturan Situs.</p>
            </div>
        @endif

        @if ($hours !== '')
            <div class="mt-6 rounded-lg bg-surface/80 p-4 text-sm text-ink border border-line/60">
                <strong>Jam operasional tim CSIRT:</strong> {{ \App\Support\Settings::publicValue($hours) }}
            </div>
        @endif

        {{-- Checklist Informasi --}}
        @if (count($checklist) > 0)
            <div class="mt-10 max-w-[720px] rounded-xl border border-line bg-white p-6 shadow-sm">
                <h3 class="font-heading text-lg font-bold text-ink">
                    Siapkan Informasi Ini Sebelum Melapor:
                </h3>
                <ul class="mt-3 space-y-2 text-sm text-ink">
                    @foreach ($checklist as $item)
                        <li class="flex items-start gap-2.5">
                            <x-icon name="check" class="mt-0.5 size-4 shrink-0 text-brand-700" />
                            <span>{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Security Warning --}}
        @if ($warning !== '')
            <div role="note" class="mt-6 max-w-[720px] flex items-start gap-3 rounded-xl border-l-4 border-warning bg-warning-bg p-4 text-sm font-medium text-warning">
                <x-icon name="alert" class="mt-0.5 size-5 shrink-0" />
                <span>{{ $warning }}</span>
            </div>
        @endif

        {{-- 5-Step Incident Handling Flow (DESIGN.md 7.5) --}}
        <div class="mt-14 max-w-[760px] border-t border-line pt-10">
            <h3 class="font-heading text-xl font-bold text-ink">
                Apa yang Terjadi Setelah Anda Melapor
            </h3>
            <p class="mt-1 text-sm text-muted">
                Proses penanganan insiden siber yang dilakukan oleh tim CSIRT Pemerintah Kota Pariaman:
            </p>

            <ol class="mt-6 grid gap-4 sm:grid-cols-2 md:grid-cols-5">
                <li class="rounded-lg border border-line bg-surface/50 p-4">
                    <div class="flex size-7 items-center justify-center rounded-full bg-brand-700 text-xs font-bold text-white">1</div>
                    <h4 class="mt-2 font-heading text-sm font-bold text-ink">Laporan Diterima</h4>
                    <p class="mt-1 text-xs text-muted leading-relaxed">Pencatatan dan konfirmasi awal laporan.</p>
                </li>
                <li class="rounded-lg border border-line bg-surface/50 p-4">
                    <div class="flex size-7 items-center justify-center rounded-full bg-brand-700 text-xs font-bold text-white">2</div>
                    <h4 class="mt-2 font-heading text-sm font-bold text-ink">Triase</h4>
                    <p class="mt-1 text-xs text-muted leading-relaxed">Penilaian urgensi, dampak, dan tingkat keparahan.</p>
                </li>
                <li class="rounded-lg border border-line bg-surface/50 p-4">
                    <div class="flex size-7 items-center justify-center rounded-full bg-brand-700 text-xs font-bold text-white">3</div>
                    <h4 class="mt-2 font-heading text-sm font-bold text-ink">Penanganan</h4>
                    <p class="mt-1 text-xs text-muted leading-relaxed">Analisis teknis, penahanan, dan isolasi ancaman.</p>
                </li>
                <li class="rounded-lg border border-line bg-surface/50 p-4">
                    <div class="flex size-7 items-center justify-center rounded-full bg-brand-700 text-xs font-bold text-white">4</div>
                    <h4 class="mt-2 font-heading text-sm font-bold text-ink">Pemulihan</h4>
                    <p class="mt-1 text-xs text-muted leading-relaxed">Pendampingan pengembalian operasional sistem.</p>
                </li>
                <li class="rounded-lg border border-line bg-surface/50 p-4">
                    <div class="flex size-7 items-center justify-center rounded-full bg-brand-700 text-xs font-bold text-white">5</div>
                    <h4 class="mt-2 font-heading text-sm font-bold text-ink">Penutupan</h4>
                    <p class="mt-1 text-xs text-muted leading-relaxed">Penyusunan laporan akhir dan rekomendasi pencegahan.</p>
                </li>
            </ol>

            <div class="mt-6 text-xs text-muted">
                Peneliti keamanan dan pelapor kerentanan terkoordinasi: silakan akses <a href="{{ url('/kontak') }}" class="font-semibold text-brand-700 underline underline-offset-4 hover:text-brand-900">Kontak Keamanan & Kunci PGP</a> atau berkas <a href="{{ route('security.txt') }}" class="font-semibold text-brand-700 underline underline-offset-4 hover:text-brand-900">security.txt</a>.
            </div>
        </div>
    </x-container>
</section>
