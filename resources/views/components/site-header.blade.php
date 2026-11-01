{{-- Header situs: identitas, navigasi desktop dengan dropdown, menu ponsel, dan tombol Pengaduan.
     Data menu dari panel admin (MenuItem::tree). Dropdown dan menu ponsel memakai pola disclosure (resources/js/nav.js):
     tombol dengan aria-expanded + panel; bisa dengan klik/sentuh dan keyboard, ditutup dengan Escape. --}}
@props(['site' => [], 'menu' => [], 'reportUrl' => '/'])
@php
    $siteName = $site['site.name'] ?? config('app.name');
    $logoUrl = ! empty($site['site.logo']) ? Storage::disk('public')->url($site['site.logo']) : '/images/logo-pemko-pariaman.png';
    $ctaLabel = $site['report.cta_label'] ?? 'Pengaduan';
    $ctaExternal = preg_match('#^https?://#i', (string) $reportUrl) === 1;
    $ctaNewTab = ! empty($site['report.cta_new_tab']) || $ctaExternal;
    $desktopLink = 'inline-flex min-h-11 items-center rounded-md px-2.5 text-[0.9375rem] font-semibold underline-offset-8 decoration-accent-400 decoration-[3px] hover:bg-white/15 aria-[current=page]:underline';
    $mobileLink = 'flex min-h-14 w-full items-center gap-2 px-4 text-left font-medium text-ink hover:bg-surface aria-[current=page]:font-bold aria-[current=page]:text-brand-900';
@endphp
<header class="on-brand sticky top-0 z-40 bg-linear-to-r from-brand-700 to-brand-900 text-white shadow-md">
    <x-container class="flex h-16 items-center gap-3 lg:h-24">
        {{-- Tombol menu (ponsel) --}}
        <button type="button"
                class="group inline-flex size-11 shrink-0 items-center justify-center rounded-md bg-white text-brand-900 lg:hidden"
                aria-label="Menu utama"
                aria-controls="menu-ponsel"
                aria-expanded="false"
                data-nav-toggle
                data-nav-autoclose
                data-nav-group="mobile">
            <x-icon name="menu" class="size-6 group-aria-expanded:hidden" />
            <x-icon name="x" class="hidden size-6 group-aria-expanded:block" />
        </button>

        {{-- Identitas & Logo Pemerintah Kota Pariaman --}}
        <a href="/" class="flex min-w-0 items-center gap-3 rounded-md py-1">
            <img src="{{ $logoUrl }}"
                 alt="Lambang Pemerintah Kota Pariaman"
                 class="h-10 w-auto shrink-0 object-contain drop-shadow-xs lg:h-12">
            <span class="font-heading text-base font-bold leading-tight lg:text-xl">{{ $siteName }}</span>
        </a>

        {{-- Navigasi desktop --}}
        <nav aria-label="Navigasi utama" class="hidden lg:ml-auto lg:block" data-nav-root>
            <ul class="flex items-center gap-1">
                @foreach ($menu as $item)
                    @php
                        $childActive = collect($item['children'] ?? [])->contains(function ($c) {
                            $p = trim((string) parse_url((string) ($c['url'] ?? ''), PHP_URL_PATH), '/');
                            return $p !== '' && request()->is($p);
                        });
                    @endphp
                    <li class="relative">
                        @if ($item['children'])
                            <button type="button"
                                    class="group {{ $desktopLink }} {{ $childActive ? 'underline' : '' }} gap-1 aria-expanded:bg-white/15"
                                    aria-controls="submenu-{{ $loop->index }}"
                                    aria-expanded="false"
                                    data-nav-toggle
                                    data-nav-autoclose
                                    data-nav-group="desktop">
                                {{ $item['label'] }}
                                <x-icon name="chevron-down" class="size-4 transition-transform duration-150 group-aria-expanded:rotate-180 motion-reduce:transition-none" />
                            </button>
                            <ul id="submenu-{{ $loop->index }}" hidden
                                class="on-light absolute left-0 top-full z-50 mt-2 min-w-60 rounded-lg border border-line bg-white p-2 text-ink shadow-lg">
                                @foreach ($item['children'] as $child)
                                    <li>
                                        <x-nav-link :item="$child" class="flex min-h-11 items-center gap-2 rounded-md px-3 hover:bg-surface aria-[current=page]:font-bold aria-[current=page]:text-brand-900" />
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <x-nav-link :item="$item" class="{{ $desktopLink }} gap-1" />
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>

        {{-- Modul Pengaduan di Navbar: mengarah langsung ke link URL yang diisikan di Panel Admin --}}
        <x-button :href="$reportUrl"
                  variant="light"
                  class="ml-auto shrink-0 lg:ml-4"
                  :target="$ctaNewTab ? '_blank' : null"
                  :rel="$ctaNewTab ? 'noopener noreferrer' : null">
            <x-icon name="shield" class="size-5" />
            <span>{{ $ctaLabel }}</span>
            @if ($ctaExternal)
                <x-icon name="external" class="size-4 shrink-0" />
            @endif
        </x-button>
    </x-container>

    {{-- Menu ponsel --}}
    <div id="menu-ponsel" hidden
         class="on-light absolute inset-x-0 top-full max-h-[calc(100dvh-4rem)] overflow-y-auto border-t border-line bg-white text-ink shadow-lg lg:hidden">
        <nav aria-label="Navigasi utama">
            <ul class="divide-y divide-line">
                @foreach ($menu as $item)
                    <li>
                        @if ($item['children'])
                            <button type="button"
                                    class="group {{ $mobileLink }} justify-between"
                                    aria-controls="submenu-ponsel-{{ $loop->index }}"
                                    aria-expanded="false"
                                    data-nav-toggle
                                    data-nav-group="mobile-sub">
                                {{ $item['label'] }}
                                <x-icon name="chevron-down" class="size-5 transition-transform duration-150 group-aria-expanded:rotate-180 motion-reduce:transition-none" />
                            </button>
                            <ul id="submenu-ponsel-{{ $loop->index }}" hidden class="bg-surface">
                                @foreach ($item['children'] as $child)
                                    <li><x-nav-link :item="$child" class="{{ $mobileLink }} pl-8" /></li>
                                @endforeach
                            </ul>
                        @else
                            <x-nav-link :item="$item" class="{{ $mobileLink }}" />
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</header>
