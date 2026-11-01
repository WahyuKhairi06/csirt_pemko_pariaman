<?php

namespace App\Models;

use App\Enums\PostType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['type', 'name', 'slug'];

    protected function casts(): array
    {
        return ['type' => PostType::class];
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
