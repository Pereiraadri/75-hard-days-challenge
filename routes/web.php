<?php

use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\DayController;
use App\Http\Controllers\DayGoalController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\UserHaveChallenge;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DayController::class, 'index'])
        ->middleware(['auth', 'verified', UserHaveChallenge::class])
        ->name('dashboard');

    Route::patch('/days/{day}/validate', [DayController::class, 'validate']);
    Route::get('/days', [DayController::class, 'calendar'])->name('days.calendar');
    Route::get('/days/{date}', [DayController::class, 'show'])->name('days.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('challenges')->group(function () {
        Route::get('/create', [ChallengeController::class, 'create'])->name('challenges.create');
        Route::post('/challenges', [ChallengeController::class, 'store'])->name('challenges.store');
    });

    Route::patch('/days/{day}/goals/{goal}/toggle', [DayGoalController::class, 'toggle']);
});








require __DIR__.'/auth.php';
