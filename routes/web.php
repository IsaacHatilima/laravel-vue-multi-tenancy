<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

foreach (config('tenancy.central_domains') as $domain) {
    // Routes available to root domain(s) listed in central_domains config/tenancy.php
    Route::domain($domain)->group(function () {});
}

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/download-recovery-codes', [ProfileController::class, 'copy_recovery_codes'])->name('recovery.codes');
    Route::patch('/clear-two-factor-confirmed-at',
        [ProfileController::class, 'clear_two_factor_confirmed_at'])->name('clear.2fa.confirmation');
});

require __DIR__.'/auth.php';
