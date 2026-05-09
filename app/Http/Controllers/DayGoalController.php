<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\DayGoal;
use App\Models\Goal;
use Illuminate\Http\Request;

class DayGoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DayGoal $dayGoal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DayGoal $dayGoal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DayGoal $dayGoal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DayGoal $dayGoal)
    {
        //
    }

    public function toggle(Request $request, Day $day, Goal $goal)
    {
        $dayGoal = DayGoal::where('day_id', $day->id)
            ->where('goal_id', $goal->id)
            ->firstOrFail();

        $dayGoal->update(['completed' => !$dayGoal->completed]);

        return response()->json(['completed' => $dayGoal->completed]);
    }
}
