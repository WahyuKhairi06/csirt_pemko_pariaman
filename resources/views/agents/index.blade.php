@extends('layouts.app')

@section('title', 'Agen Siber OPD')
@section('description', 'Daftar narahubung dan agen siber resmi di setiap Organisasi Perangkat Daerah (OPD) Pemerintah Kota Pariaman.')

@section('content')
<div class="bg-surface/50 border-b border-line py-8">
    <x-container>
        <nav aria-label="Remah roti">
            <ol class="flex flex-wrap items-center gap-x-2 text-sm text-muted">
                <li>
                    <a href="{{ route('home') }}" class="rounded-sm text-brand-700 underline underline-offset-4 hover:text-brand-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700">
                        Beranda
                    </a>
                </li>
                <li aria-hidden="true" class="text-muted/60">/</li>
                <li aria-current="page" class="font-medium text-ink">Agen Siber</li>
            </ol>
        </nav>
        <h1 class="mt-4 font-heading text-(length:--text-h1) font-bold tracking-tight text-ink">
            Daftar Agen Siber OPD
        </h1>
        <p class="mt-3 max-w-[720px] text-lg text-muted">
            Petugas penghubung <em>(focal point)</em> keamanan informasi di lingkungan Organisasi Perangkat Daerah Pemerintah Kota Pariaman yang berperan mengoordinasikan mitigasi risiko dan pelaporan insiden siber.
        </p>
    </x-container>
</div>

<x-container class="py-12">
    @if ($opds->isNotEmpty())
        <div class="mb-8">
            <h2 class="text-sm font-semibold uppercase tracking-wider text-muted">Saring Berdasarkan OPD</h2>
            <div class="mt-3 flex flex-wrap gap-2">
                <a href="{{ route('agents.index') }}"
                   class="rounded-full px-4 py-1.5 text-xs font-semibold transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700 {{ $opd === '' ? 'bg-brand-700 text-white' : 'bg-surface text-ink border border-line hover:bg-brand-50' }}">
                    Semua OPD
                </a>
                @foreach ($opds as $item)
                    <a href="{{ route('agents.index', ['opd' => $item]) }}"
                       class="rounded-full px-4 py-1.5 text-xs font-semibold transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700 {{ $opd === $item ? 'bg-brand-700 text-white' : 'bg-surface text-ink border border-line hover:bg-brand-50' }}">
                        {{ $item }}
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    @if ($agents->isNotEmpty())
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($agents as $agent)
                <article class="flex flex-col justify-between rounded-xl border border-line bg-white p-6 shadow-sm transition hover:shadow-md">
                    <div>
                        <div class="flex items-center gap-3">
                            <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-brand-50 text-brand-700">
                                <x-icon name="user" class="size-6" />
                            </div>
                            <div>
                                <h3 class="font-heading text-lg font-bold text-ink">
                                    {{ $agent->name }}
                                </h3>
                                @if ($agent->position)
                                    <p class="text-xs text-muted">{{ $agent->position }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="mt-4 space-y-2 border-t border-line/70 pt-4 text-xs">
                            <div class="flex items-start gap-2 text-ink">
                                <x-icon name="shield" class="mt-0.5 size-4 shrink-0 text-brand-700" />
                                <div>
                                    <span class="font-semibold text-muted">Instansi / OPD:</span>
                                    <p class="font-medium">{{ $agent->opd }}</p>
                                </div>
                            </div>

                            @if ($agent->contact)
                                <div class="flex items-start gap-2 text-ink">
                                    <x-icon name="mail" class="mt-0.5 size-4 shrink-0 text-brand-700" />
                                    <div>
                                        <span class="font-semibold text-muted">Kontak Resmi:</span>
                                        <p class="font-mono text-xs">{{ $agent->contact }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <div class="rounded-xl border border-line bg-surface p-8 text-center">
            <x-icon name="info" class="mx-auto size-8 text-brand-700" />
            <h2 class="mt-3 font-heading text-lg font-semibold text-ink">Tidak Ada Agen Siber Ditemukan</h2>
            <p class="mt-1 text-sm text-muted">Belum ada data agen siber terdaftar untuk kriteria penyaringan yang dipilih.</p>
            @if ($opd !== '')
                <div class="mt-4">
                    <a href="{{ route('agents.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700 underline underline-offset-4 hover:text-brand-900">
                        Tampilkan semua OPD
                    </a>
                </div>
            @endif
        </div>
    @endif
</x-container>
@endsection
