<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable([
    'title',
    'body',
    'user_id',
])]
class Goal extends Model
{

    use HasFactory, HasUuids;

    public function days(): BelongsToMany
    {
        return $this->belongsToMany(Day::class)
            ->using(DayGoal::class)
            ->withPivot(['completed'])
            ->withTimestamps();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
