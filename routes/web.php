<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaperController;
use App\Http\Controllers\DashboardController;

Route::get('/', [PaperController::class, 'index'])->name('papers.index');
Route::get('/papers/{id}', [PaperController::class, 'show'])->name('papers.show');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');