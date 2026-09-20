<?php

use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\DayController;
use App\Http\Controllers\DayGoalController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\EnsureUserHasChallenge;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/challenges/create', [ChallengeController::class, 'create'])->name('challenges.create');
    Route::post('/challenges', [ChallengeController::class, 'store'])->name('challenges.store');

    Route::middleware(EnsureUserHasChallenge::class)->group(function () {
        Route::get('/dashboard', [DayController::class, 'index'])->name('dashboard');
        Route::get('/days', [DayController::class, 'calendar'])->name('days.calendar');
        Route::get('/days/{date}', [DayController::class, 'show'])->name('days.show');
        Route::get('/stats', [DayController::class, 'stats'])->name('days.stats');

        Route::patch('/days/{day}/validate', [DayController::class, 'validate'])->name('days.validate');
        Route::patch('/days/{day}/unvalidate', [DayController::class, 'unvalidate'])->name('days.unvalidate');
        Route::patch('/days/{day}/goals/{goal}/toggle', [DayGoalController::class, 'toggle'])->name('day-goals.toggle');
    });
});

require __DIR__.'/auth.php';
