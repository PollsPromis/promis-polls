<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\SuggestionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

Route::get('/', [IndexController::class, 'index'])->name('app');

Route::group(['prefix' => 'suggestions'], function () {
    Route::get('/', [SuggestionController::class, 'index'])->name('suggestion.show');
    Route::post('/', [SuggestionController::class, 'store'])->name('suggestion.store');
    Route::get('/filter', [SuggestionController::class, 'filter'])->name('suggestion.filter');
});
    Route::post('/auth-show', [AuthController::class, 'auth'])->name('auth.admin');
    Route::get('/auth-show', [AuthController::class, 'index'])->name('auth.show');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.show');
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
