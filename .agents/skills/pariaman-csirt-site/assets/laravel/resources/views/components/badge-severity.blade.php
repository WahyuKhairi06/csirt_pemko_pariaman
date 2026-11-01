{{-- Badge keparahan advisori (DESIGN.md bagian 7.3): selalu ikon + teks + warna. --}}
@props(['severity'])
@php
    $classes = match ($severity) {
        \App\Enums\Severity::Low => 'bg-info-bg text-info',
        \App\Enums\Severity::Medium => 'bg-warning-bg text-warning',
        \App\Enums\Severity::High => 'bg-danger-bg text-danger',
        \App\Enums\Severity::Critical => 'bg-danger text-white',
    };
@endphp
<span class="inline-flex h-7 items-center gap-1.5 rounded-full px-3 text-xs font-semibold {{ $classes }}">
    <svg aria-hidden="true" viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
        @if ($severity === \App\Enums\Severity::Low)
            <circle cx="12" cy="12" r="9" /><path d="M12 11v5M12 8h.01" />
        @elseif ($severity === \App\Enums\Severity::Medium)
            <path d="M12 3 2 20h20L12 3z" /><path d="M12 10v4M12 17h.01" />
        @elseif ($severity === \App\Enums\Severity::High)
            <path d="M12 3 2 20h20L12 3z" /><path d="M10 10v4M14 10v4M12 17h.01" />
        @else
            <path d="M8 3h8l5 5v8l-5 5H8l-5-5V8l5-5z" /><path d="M12 8v5M12 16h.01" />
        @endif
    </svg>
    {{ $severity->label() }}
</span>
