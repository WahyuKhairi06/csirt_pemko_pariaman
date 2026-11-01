{{-- Blok: teks kaya (data: content). HTML dibersihkan dulu; lihat App\Support\Html. --}}
<section class="mx-auto max-w-[1200px] px-4 py-8">
    <div class="max-w-[720px] space-y-4 text-base leading-relaxed text-ink">
        {!! \App\Support\Html::clean($data['content'] ?? '') !!}
    </div>
</section>
