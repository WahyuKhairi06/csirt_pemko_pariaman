<?php

namespace App\Models;

use App\Enums\PublishStatus;
use App\Enums\Severity;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Advisory extends Model
{
    use Publishable;

    protected $fillable = [
        'title', 'slug', 'severity', 'summary', 'affected_systems', 'mitigation',
        'status', 'published_at', 'author_id',
    ];

    protected function casts(): array
    {
        return [
            'severity' => Severity::class,
            'status' => PublishStatus::class,
            'published_at' => 'datetime',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
