<?php

    use Illuminate\Support\Facades\Route;
    use Inertia\Inertia;
    use App\Http\Controllers\SuggestionController;
    use App\Http\Controllers\AuthController;

    Route::get('/', function () {
        return view('layouts.index');
    })->name('app');

    Route::get('/suggestions-show', [SuggestionController::class, 'index'])->name('suggestions.show');
    Route::get('/auth-show', [AuthController::class, 'index'])->name('auth.show');

    Route::post('/suggestion-submit', [SuggestionController::class, 'store'])->name('suggestion.submit');


    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ])->group(function () {
        Route::get('/dashboard', function () {
            return Inertia::render('Dashboard');
        })->name('dashboard');
    });

