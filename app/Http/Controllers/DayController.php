<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\DayGoal;
use App\Models\Goal;
use Illuminate\Http\Request;
use function Laravel\Prompts\error;

class DayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $day = Day::firstOrCreate(
            ['user_id' => auth()->id(), 'date' => today()],
        );

        if ($day->wasRecentlyCreated) {
            $goals = Goal::whereNull('user_id')->get();
            foreach ($goals as $goal) {
                DayGoal::create([
                    'day_id' => $day->id,
                    'goal_id' => $goal->id,
                    'completed' => false,
                ]);
            }
        }

        $dayGoals = $day->goals()->withPivot('completed')->get();
        return view('dashboard', compact('day', 'dayGoals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

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
    public function show(Day $day)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Day $day)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Day $day)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Day $day)
    {
        //
    }

    public function validate(Day $day)
    {
        if ($day->user_id === auth()->id()) {
            $day->update([
                'is_validated' => true,
            ]);

            return response()->json(['message' => 'Bien joué, rendez-vous demain !']);
        }

        return response('nul');
    }
}
