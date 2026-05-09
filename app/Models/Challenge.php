<?php

namespace App\Models;

use App\ChallengeStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'start_date',
    'status'
])]
class Challenge extends Model
{
    use HasUuids;

    protected function casts(): array
    {
        return [
            'status' => ChallengeStatus::class,
            'start_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
