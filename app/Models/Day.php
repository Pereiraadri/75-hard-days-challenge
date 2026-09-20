<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable([
    'date',
    'is_validated',
    'user_id'
])]
class Day extends Model
{
    use HasFactory, HasUuids;

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'is_validated' => 'boolean',
        ];
    }

    public function goals(): BelongsToMany
    {
        return $this->belongsToMany(Goal::class)
            ->using(DayGoal::class)
            ->withPivot(['completed'])
            ->withTimestamps()
            ->orderBy('position');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function completedGoalsCount(): int
    {
        return $this->goals->where('pivot.completed', true)->count();
    }
}
