<?php

namespace App\Models\Concerns;

use App\Enums\PublishStatus;
use Illuminate\Database\Eloquent\Builder;

/**
 * Logika terbit ala WordPress (PRD.md FR-46). Tidak butuh cron: konten "terjadwal" hanya
 * berstatus Published dengan published_at di masa depan, dan otomatis lolos filter saat waktunya tiba.
 * Model pemakai wajib punya kolom status (cast PublishStatus) dan published_at (cast datetime).
 */
trait Publishable
{
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', PublishStatus::Published->value)
            ->where(function (Builder $q) {
                $q->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }

    public function isPublished(): bool
    {
        return $this->status === PublishStatus::Published
            && ($this->published_at === null || $this->published_at->lte(now()));
    }

    /** Label untuk daftar admin: Draf, Terjadwal, atau Terbit. */
    public function publicationLabel(): string
    {
        if ($this->status !== PublishStatus::Published) {
            return PublishStatus::Draft->label();
        }

        return $this->published_at !== null && $this->published_at->isFuture() ? 'Terjadwal' : 'Terbit';
    }
}
