<?php

declare(strict_types=1);

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\UserAsTeamController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

require __DIR__.'/auth.php';

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('index');

Route::middleware(['auth'])
    ->group(function () {
        Route::get('/dashboard', fn () => Inertia::render('Dashboard'))
            ->middleware(['verified'])
            ->name('dashboard');

        Route::controller(ProfileController::class)
            ->prefix('/profile')
            ->name('profile.')
            ->group(function () {
                Route::get('/', 'edit')->name('edit');
                Route::patch('/', 'update')->name('update');
                Route::delete('/', 'destroy')->name('destroy');
            });

        Route::resource('competition',CompetitionController::class);
        Route::post('/competition/data', [CompetitionController::class,'data'])->name('competition.data');

        Route::resource('user_as_team',UserAsTeamController::class);
        Route::post('/userAsTeam/data', [UserAsTeamController::class,'data'])->name('user_as_team.data');

    });
