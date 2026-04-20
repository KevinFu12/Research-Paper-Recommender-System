<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaperController;

Route::get('/', [PaperController::class, 'index'])->name('papers.index');
Route::get('/papers/{id}', [PaperController::class, 'show'])->name('papers.show');
