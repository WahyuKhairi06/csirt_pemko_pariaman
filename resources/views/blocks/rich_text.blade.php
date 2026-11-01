{{-- Blok: teks kaya (data: content). HTML dibersihkan dulu; lihat App\Support\Html. --}}
<section class="mx-auto max-w-[1200px] px-4 py-8">
    <div class="rich-content prose max-w-[820px] rounded-xl border border-line bg-white p-6 text-base leading-relaxed text-ink shadow-xs sm:p-8">
        {!! \App\Support\Html::clean($data['content'] ?? '') !!}
    </div>
</section>
