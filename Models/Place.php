<?php

namespace App\Models;

use App\Enums\PlaceCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Place extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'category' => PlaceCategory::class,
            'rating' => 'decimal:1',
            'is_featured' => 'boolean',
            'is_top_pick' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function trips(): BelongsToMany
    {
        return $this->belongsToMany(Trip::class)->withPivot('position');
    }

    public function scopeSearch(Builder $q, ?string $term): Builder
    {
        return $term
            ? $q->where(fn ($w) => $w->where('name', 'like', "%{$term}%")
                ->orWhere('district', 'like', "%{$term}%")
                ->orWhere('address', 'like', "%{$term}%"))
            : $q;
    }

    public function scopeCategory(Builder $q, ?string $category): Builder
    {
        return $category && PlaceCategory::tryFrom($category)
            ? $q->where('category', $category)
            : $q;
    }
}
