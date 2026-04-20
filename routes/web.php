<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaperController;

Route::get('/', [PaperController::class, 'index'])->name('papers.index');
Route::get('/papers/{id}', [PaperController::class, 'show'])->name('papers.show');

Route::get('/deploy-migrate', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return "Migration successful: " . Artisan::output();
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});
