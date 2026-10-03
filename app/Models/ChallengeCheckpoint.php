<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ChallengeCheckpoint extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return ['tags' => 'array'];
    }

    public function challenge(): BelongsTo
    {
        return $this->belongsTo(Challenge::class);
    }

    public function verifiedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'challenge_checkpoint_user')->withPivot('verified_at');
    }
}
