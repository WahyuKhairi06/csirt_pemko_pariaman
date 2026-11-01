{{-- Tombol/tautan bergaya tombol (DESIGN.md 7.1). Dengan href menjadi <a>, tanpa href menjadi <button type="button">.
     Varian: primary, gold (hanya di atas latar navy), light (di atas latar biru/navy), outline, outline-light (di atas navy).
     Ukuran: md (44px), lg (52px). Target sentuh minimal 44px. --}}
@props(['href' => null, 'variant' => 'primary', 'size' => 'md'])
@php
    $variants = [
        'primary' => 'bg-brand-700 text-white hover:bg-brand-900',
        'gold' => 'bg-accent-400 text-navy-900 hover:bg-accent-100',
        'light' => 'bg-white text-brand-900 hover:bg-accent-100',
        'outline' => 'border-2 border-brand-700 bg-white text-brand-700 hover:bg-surface',
        'outline-light' => 'border-2 border-white text-white hover:bg-white/10',
    ];
    $sizes = ['md' => 'min-h-11 px-5', 'lg' => 'min-h-13 px-6 text-lg'];
    $classes = 'inline-flex items-center justify-center gap-2 rounded-md font-semibold transition-colors duration-150 motion-reduce:transition-none '
        .($variants[$variant] ?? $variants['primary']).' '.($sizes[$size] ?? $sizes['md']);
@endphp
@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>{{ $slot }}</a>
@else
    <button type="button" {{ $attributes->class($classes) }}>{{ $slot }}</button>
@endif
