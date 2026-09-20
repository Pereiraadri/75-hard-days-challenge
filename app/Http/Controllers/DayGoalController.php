<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\DayGoal;
use App\Models\Goal;

class DayGoalController extends Controller
{
    public function toggle(Day $day, Goal $goal)
    {
        $this->authorize('update', $day);

        $dayGoal = DayGoal::where('day_id', $day->id)
            ->where('goal_id', $goal->id)
            ->firstOrFail();

        $dayGoal->update(['completed' => ! $dayGoal->completed]);

        return response()->json(['completed' => $dayGoal->completed]);
    }
}
