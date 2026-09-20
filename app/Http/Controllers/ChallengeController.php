<?php

namespace App\Http\Controllers;

use App\ChallengeStatus;
use App\Models\Challenge;
use App\Models\Goal;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    public function create()
    {
        return view('challenges.create', [
            'goals' => Goal::shared()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date' => ['required', 'date'],
        ]);

        Challenge::create([
            'user_id' => auth()->id(),
            'start_date' => $request->start_date,
            'status' => ChallengeStatus::Created,
        ]);

        return redirect()->route('dashboard');
    }
}
