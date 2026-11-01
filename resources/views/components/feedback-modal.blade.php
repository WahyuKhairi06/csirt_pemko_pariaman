@props(['isFilament' => false])
@php
    $flashStatus = null;
    $flashTitle = null;
    $flashMessage = null;

    if (session()->has('success')) {
        $flashStatus = 'success';
        $flashTitle = 'Berhasil!';
        $flashMessage = (string) session('success');
    } elseif (session()->has('status')) {
        $flashStatus = 'success';
        $flashTitle = 'Berhasil!';
        $flashMessage = (string) session('status');
    } elseif (session()->has('message')) {
        $flashStatus = 'success';
        $flashTitle = 'Informasi';
        $flashMessage = (string) session('message');
    } elseif (session()->has('error')) {
        $flashStatus = 'danger';
        $flashTitle = 'Terjadi Kesalahan';
        $flashMessage = (string) session('error');
    } elseif (session()->has('warning')) {
        $flashStatus = 'warning';
        $flashTitle = 'Perhatian';
        $flashMessage = (string) session('warning');
    }
@endphp

@if ($isFilament)
    <style>{!! file_get_contents(resource_path('css/feedback.css')) !!}</style>
    @vite(['resources/js/app.js'])
@endif

<div
    id="csirt-feedback-modal"
    class="csirt-fb-overlay"
    role="status"
    aria-live="polite"
    aria-atomic="true"
    aria-hidden="true"
    @if ($flashStatus) data-feedback-status="{{ $flashStatus }}" @endif
    @if ($flashTitle) data-feedback-title="{{ $flashTitle }}" @endif
    @if ($flashMessage) data-feedback-message="{{ $flashMessage }}" @endif
>
    <div class="csirt-fb-card" data-status="success">
        <div class="csirt-fb-icon-wrap" aria-hidden="true">
            {{-- Animasi Ceklis (Success) --}}
            <svg class="csirt-fb-svg csirt-fb-svg--success" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle class="csirt-fb-circle" cx="28" cy="28" r="25" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" />
                <path class="csirt-fb-mark" d="M17.5 28.5L24.5 35.5L39 20.5" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
            </svg>

            {{-- Animasi Silang (Danger / Error) --}}
            <svg class="csirt-fb-svg csirt-fb-svg--danger" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle class="csirt-fb-circle" cx="28" cy="28" r="25" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" />
                <path class="csirt-fb-mark" d="M20 20L36 36M36 20L20 36" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
            </svg>

            {{-- Animasi Peringatan (Warning) --}}
            <svg class="csirt-fb-svg csirt-fb-svg--warning" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle class="csirt-fb-circle" cx="28" cy="28" r="25" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" />
                <path class="csirt-fb-mark" d="M28 17V30M28 38H28.02" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
            </svg>

            {{-- Animasi Informasi (Info) --}}
            <svg class="csirt-fb-svg csirt-fb-svg--info" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle class="csirt-fb-circle" cx="28" cy="28" r="25" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" />
                <path class="csirt-fb-mark" d="M28 25V38M28 18H28.02" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>

        <h3 class="csirt-fb-title" data-csirt-fb-title>Berhasil Disimpan!</h3>
        <p class="csirt-fb-message" data-csirt-fb-message>Perubahan data Anda telah berhasil disimpan ke dalam sistem.</p>

        <button type="button" class="csirt-fb-btn" data-csirt-fb-close>
            OK, Mengerti
        </button>

        <div class="csirt-fb-progress-track" aria-hidden="true">
            <div class="csirt-fb-progress-bar"></div>
        </div>
    </div>
</div>

