{{-- Kontainer konten: lebar maksimum dan margin sisi mengikuti DESIGN.md bagian 6.1 (token --container). --}}
<div {{ $attributes->class('mx-auto w-full max-w-(--container) px-4 sm:px-6 lg:px-10') }}>
    {{ $slot }}
</div>
