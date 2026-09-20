<?php

namespace App\Http\Controllers;

use App\ChallengeStatus;
use App\Models\Goal;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    public function create(Request $request)
    {
        if ($request->user()->challenge) {
            return redirect()->route('dashboard');
        }

        return view('challenges.create', [
            'goals' => Goal::shared()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $request->user()->challenge()->firstOrCreate(
            attributes: [],
            values: [
                'start_date' => $request->date('start_date'),
                'status' => ChallengeStatus::Created,
            ],
        );

        return redirect()->route('dashboard');
    }
}
