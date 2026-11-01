{{-- Blok: kartu kanal pelaporan (DESIGN.md bagian 7.4). Data dari Pengaturan (report.channels, report.checklist,
     report.warning, contact.hours): diatur admin, bukan di kode. Kanal dengan nilai placeholder atau tidak valid disembunyikan. --}}
@php
    $channels = \App\Support\Settings::reportChannels();
    $checklist = (array) \App\Support\Settings::get('report.checklist', []);
    $warning = (string) \App\Support\Settings::get('report.warning', '');
    $hours = (string) \App\Support\Settings::get('contact.hours', '');
@endphp
<section class="mx-auto max-w-[1200px] px-4 py-8">
    @if (count($channels) > 0)
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($channels as $channel)
                <article class="rounded-lg border border-line bg-white p-6 shadow-sm">
                    <h3 class="font-heading text-lg font-semibold text-ink">{{ $channel['label'] }}</h3>
                    <p class="mt-2 break-all font-mono text-sm text-ink">{{ $channel['value'] }}</p>
                    @if ($channel['hours'])
                        <p class="mt-1 text-sm text-muted">{{ $channel['hours'] }}</p>
                    @endif
                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="{{ $channel['href'] }}"
                           @if ($channel['type'] === \App\Enums\ReportChannelType::Url) target="_blank" rel="noopener" @endif
                           class="inline-flex min-h-[44px] items-center rounded-md bg-brand-700 px-5 font-semibold text-white hover:bg-brand-900">
                            {{ $channel['type']->actionLabel() }}
                        </a>
                        <button type="button" data-copy="{{ $channel['value'] }}" aria-live="polite"
                                class="inline-flex min-h-[44px] items-center rounded-md border-[1.5px] border-brand-700 px-5 font-semibold text-brand-700">
                            Salin
                        </button>
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <p class="rounded-md bg-info-bg p-4 text-info">Kanal pelaporan belum diatur. Admin dapat mengisinya di Pengaturan Situs.</p>
    @endif

    @if ($hours !== '')
        <p class="mt-6 text-ink"><strong>Jam layanan:</strong> {{ $hours }}</p>
    @endif

    @if (count($checklist) > 0)
        <div class="mt-8 max-w-[720px]">
            <h2 class="font-heading text-2xl font-bold text-ink">Siapkan informasi ini</h2>
            <ul class="mt-3 list-disc space-y-1 pl-6 text-ink">
                @foreach ($checklist as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($warning !== '')
        <p role="note" class="mt-8 max-w-[720px] rounded-md bg-warning-bg p-4 font-medium text-warning">{{ $warning }}</p>
    @endif
</section>
