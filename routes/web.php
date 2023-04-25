<?php

declare(strict_types=1);

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\StatsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Service\CloudVision;
use Illuminate\Support\Facades\Storage;

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

        Route::get('/vision', function (CloudVision $cloudVision) {
            $img = Storage::disk('public')->get('stats_eng.png');
            return ($cloudVision->getTextFromImg(base64_encode($img))->json());
        })->name('image.read');

        Route::resource('stats',StatsController::class);
    });
