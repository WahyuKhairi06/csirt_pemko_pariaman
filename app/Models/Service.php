<?php

namespace App\Models;

use App\Enums\PublishStatus;
use App\Enums\ServiceGroup;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use Publishable;

    protected $fillable = [
        'group', 'name', 'slug', 'description', 'who_can_request', 'how_to_request',
        'hours', 'response_target', 'sort', 'status', 'published_at',
    ];

    protected function casts(): array
    {
        return [
            'group' => ServiceGroup::class,
            'status' => PublishStatus::class,
            'published_at' => 'datetime',
        ];
    }
}
