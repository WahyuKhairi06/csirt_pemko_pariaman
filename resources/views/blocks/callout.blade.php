{{-- Blok: Callout / Kotak Pemberitahuan (CMS-SPEC.md 4). Data: level (info/warning/danger), text --}}
@php
    $level = $data['level'] ?? 'info';
    $styles = [
        'info' => 'bg-info-bg text-info border-info',
        'warning' => 'bg-warning-bg text-warning border-warning',
        'danger' => 'bg-danger-bg text-danger border-danger',
    ];
    $iconName = $level === 'info' ? 'info' : 'alert';
@endphp
<div class="my-6">
    <x-container class="!px-0 sm:!px-0 lg:!px-0">
        <div role="note" class="flex items-start gap-3 rounded-xl border-l-4 p-4 {{ $styles[$level] ?? $styles['info'] }}">
            <x-icon :name="$iconName" class="mt-0.5 size-5 shrink-0" />
            <div class="text-sm font-medium leading-relaxed">
                {{ $data['text'] ?? '' }}
            </div>
        </div>
    </x-container>
</div>
