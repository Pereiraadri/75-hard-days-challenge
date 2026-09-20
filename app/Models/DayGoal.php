<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[Fillable([
    'day_id',
    'goal_id',
    'completed',
])]
class DayGoal extends Pivot
{
    use HasFactory, HasUuids;

    protected function casts(): array
    {
        return [
            'completed' => 'boolean',
        ];
    }

    public function day(): BelongsTo
    {
        return $this->belongsTo(Day::class);
    }

    public function goal(): BelongsTo
    {
        return $this->belongsTo(Goal::class);
    }
}
