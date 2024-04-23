<?php

    use Illuminate\Support\Facades\Route;
    use Inertia\Inertia;
    use App\Http\Controllers\SuggestionController;
    use \App\Http\Controllers\AdminController;

    Route::get('/', function () {
        return view('layouts.index');
    })->name('app');

    Route::get('/suggestions-show', [SuggestionController::class, 'index'])->name('suggestions.show');

    Route::post('/suggestion-submit', [SuggestionController::class, 'store'])->name('suggestion.submit');

    Route::get('/admin', [AdminController::class, 'index'])->name('admin');

    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ])->group(function () {
        Route::get('/dashboard', function () {
            return Inertia::render('Dashboard');
        })->name('dashboard');
    });

