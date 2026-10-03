<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Challenge extends Model
{
    protected $guarded = [];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot(['status', 'completed_at'])->withTimestamps();
    }

    public function checkpoints(): HasMany
    {
        return $this->hasMany(ChallengeCheckpoint::class)->orderBy('position');
    }
}