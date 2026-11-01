<?php

namespace App\Models;

use App\Enums\DocumentCategory;
use App\Enums\PublishStatus;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use Publishable;

    protected $fillable = [
        'title', 'category', 'file', 'version', 'language', 'effective_date',
        'sort', 'status', 'published_at',
    ];

    protected function casts(): array
    {
        return [
            'category' => DocumentCategory::class,
            'status' => PublishStatus::class,
            'effective_date' => 'date',
            'published_at' => 'datetime',
        ];
    }

    /** URL unduhan dari disk publik. Hanya berkas yang diunggah admin yang ada di sini. */
    public function url(): string
    {
        return Storage::disk('public')->url($this->file);
    }
}
