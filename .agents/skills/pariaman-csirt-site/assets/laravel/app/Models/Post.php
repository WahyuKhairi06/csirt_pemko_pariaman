<?php

namespace App\Models;

use App\Enums\PostType;
use App\Enums\PublishStatus;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use Publishable;

    protected $fillable = [
        'type', 'category_id', 'title', 'slug', 'excerpt', 'body', 'cover', 'cover_alt',
        'video_url', 'download', 'status', 'published_at', 'author_id',
    ];

    protected function casts(): array
    {
        return [
            'type' => PostType::class,
            'status' => PublishStatus::class,
            'published_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
