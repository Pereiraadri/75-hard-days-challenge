<?php

namespace App\Policies;

use App\Models\Day;
use App\Models\User;

class DayPolicy
{
    public function update(User $user, Day $day): bool
    {
        return $user->id === $day->user_id;
    }
}
