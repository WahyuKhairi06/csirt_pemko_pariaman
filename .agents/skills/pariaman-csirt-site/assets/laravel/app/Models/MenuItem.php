<?php

namespace App\Models;

use App\Enums\MenuLocation;
use App\Enums\ReportChannelType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class MenuItem extends Model
{
    protected $fillable = [
        'location', 'parent_id', 'label', 'type', 'page_id', 'url', 'new_tab', 'sort', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'location' => MenuLocation::class,
            'new_tab' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saved(fn () => static::flushCache());
        static::deleted(fn () => static::flushCache());
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort');
    }

    public static function flushCache(): void
    {
        foreach (MenuLocation::cases() as $location) {
            Cache::forget(self::cacheKey($location));
        }
    }

    private static function cacheKey(MenuLocation $location): string
    {
        return 'site.menu.'.$location->value;
    }

    /**
     * Pohon menu siap render untuk satu lokasi, berupa array biasa (aman disimpan di cache):
     * [['label' => ..., 'url' => ..., 'new_tab' => bool, 'children' => [...]], ...]
     * Hanya satu tingkat submenu (PRD.md FR-43).
     */
    public static function tree(MenuLocation $location): array
    {
        return Cache::rememberForever(self::cacheKey($location), function () use ($location) {
            $items = static::query()
                ->with('page:id,slug,status,published_at')
                ->where('location', $location->value)
                ->where('is_active', true)
                ->orderBy('sort')
                ->get();

            $resolve = function (MenuItem $item): ?array {
                $url = $item->resolveUrl();

                return $url === null ? null : [
                    'label' => $item->label,
                    'url' => $url,
                    'new_tab' => $item->new_tab,
                    'children' => [],
                ];
            };

            $tree = [];
            foreach ($items->whereNull('parent_id') as $root) {
                $node = $resolve($root);
                if ($node === null) {
                    continue;
                }
                foreach ($items->where('parent_id', $root->id) as $child) {
                    if (($childNode = $resolve($child)) !== null) {
                        $node['children'][] = $childNode;
                    }
                }
                $tree[] = $node;
            }

            return $tree;
        });
    }

    /** URL tujuan, atau null bila butir tidak valid (halaman belum terbit, URL berbahaya). */
    public function resolveUrl(): ?string
    {
        if ($this->type === 'page') {
            return ($this->page && $this->page->isPublished())
                ? ($this->page->is_home ? '/' : '/'.$this->page->slug)
                : null;
        }

        $url = trim((string) $this->url);
        if ($url === '') {
            return null;
        }
        // Jalur internal (/berita) atau http(s) saja. Tolak javascript:, data:, dan sejenisnya.
        if (str_starts_with($url, '/') && ! str_starts_with($url, '//')) {
            return $url;
        }

        return ReportChannelType::isHttpUrl($url) ? $url : null;
    }
}
