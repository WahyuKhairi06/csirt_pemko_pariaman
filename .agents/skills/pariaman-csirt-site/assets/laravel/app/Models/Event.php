<?php

namespace App\Models;

use App\Enums\PublishStatus;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use Publishable;

    protected $fillable = [
        'title', 'slug', 'starts_at', 'ends_at', 'location', 'description', 'status', 'published_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => PublishStatus::class,
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'published_at' => 'datetime',
        ];
    }
}
