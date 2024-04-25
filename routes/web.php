<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\SuggestionController;
use App\Http\Controllers\AdminController;

Route::get('/', [IndexController::class, 'index'])->name('app');

Route::group(['prefix' => 'suggestions'], function () {
    Route::get('/', [SuggestionController::class, 'index'])->name('suggestion.show');
    Route::post('/', [SuggestionController::class, 'store'])->name('suggestion.store');
    Route::get('/filter', [SuggestionController::class, 'filter'])->name('suggestion.filter');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
