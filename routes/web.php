<?php

    use Illuminate\Support\Facades\Route;
    use Inertia\Inertia;
    use App\Http\Controllers\SuggestionController;

    Route::get('/', function () {
        return view('layouts.index');
    })->name('app');

    Route::post('/submit-suggestion', [SuggestionController::class, 'store'])->name('submit.suggestion');


    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ])->group(function () {
        Route::get('/dashboard', function () {
            return Inertia::render('Dashboard');
        })->name('dashboard');
    });

