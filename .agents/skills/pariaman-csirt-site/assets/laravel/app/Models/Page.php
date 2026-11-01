<?php

namespace App\Models;

use App\Enums\PublishStatus;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    use Publishable;

    /** Slug yang dipakai rute tetap; halaman dengan slug ini tidak boleh dibuat (validasi di admin). */
    public const RESERVED_SLUGS = [
        'berita', 'edukasi', 'advisori', 'agenda', 'galeri', 'dokumen', 'layanan', 'agen-siber',
        'pratinjau', 'panel-csirt', 'admin', 'login', 'logout', 'up', 'storage', 'livewire', 'filament',
    ];

    protected $fillable = [
        'parent_id', 'title', 'slug', 'template', 'blocks', 'status', 'published_at',
        'is_home', 'seo_title', 'seo_description', 'seo_image', 'author_id',
    ];

    protected function casts(): array
    {
        return [
            'blocks' => 'array',
            'status' => PublishStatus::class,
            'published_at' => 'datetime',
            'is_home' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        // Slug atau judul berubah: tautan menu bisa ikut berubah, jadi buang cache menu.
        static::saved(fn () => MenuItem::flushCache());
        static::deleted(fn () => MenuItem::flushCache());

        // Hanya satu beranda.
        static::saving(function (Page $page) {
            if ($page->is_home) {
                static::query()->where('id', '!=', $page->id ?? 0)->update(['is_home' => false]);
            }
        });
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
