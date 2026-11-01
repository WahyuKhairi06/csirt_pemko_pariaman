{{-- Tautan menu dari pohon menu ($item = ['label','url','new_tab']). Menandai halaman aktif (aria-current),
     memberi penanda dan teks pembaca layar untuk tautan eksternal / tab baru, serta rel aman. --}}
@props(['item'])
@php
    $url = (string) $item['url'];
    $external = preg_match('#^https?://#i', $url) === 1;
    $newTab = ! empty($item['new_tab']);
    $path = trim((string) parse_url($url, PHP_URL_PATH), '/');
    $current = ! $external && request()->is($path === '' ? '/' : $path);
@endphp
<a href="{{ $url }}"
   @if ($current) aria-current="page" @endif
   @if ($newTab) target="_blank" @endif
   @if ($external || $newTab) rel="noopener noreferrer" @endif
   {{ $attributes }}>
    {{ $slot->isEmpty() ? $item['label'] : $slot }}
    @if ($newTab || $external)
        <x-icon name="external" class="size-4 shrink-0" />
        <span class="sr-only">{{ $newTab ? '(membuka tab baru)' : '(situs eksternal)' }}</span>
    @endif
</a>
