<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

// Locale switching route
Route::get('/locale/{locale}', [LocaleController::class, 'changeLocale'])->name('locale.change');

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Contact routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/dashboard', [UserDashboardController::class, 'index'])->middleware(['auth', 'verified', 'role'])->name('dashboard');

Route::get('/test-layout', function () {
    return view('test-layout');
})->middleware(['auth'])->name('test-layout');

// Role selection routes
Route::middleware(['auth'])->group(function () {
    Route::get('/role', [App\Http\Controllers\RoleController::class, 'show'])->name('role.show');
    Route::post('/role', [App\Http\Controllers\RoleController::class, 'store'])->name('role.store');
});

// Association details routes
Route::middleware(['auth'])->group(function () {
    Route::get('/association/details', [App\Http\Controllers\AssociationDetailsController::class, 'show'])->name('association.details');
    Route::post('/association/details', [App\Http\Controllers\AssociationDetailsController::class, 'store'])->name('association.details.store');
    Route::get('/association/edit', [App\Http\Controllers\AssociationDetailsController::class, 'edit'])->name('association.edit');
    Route::put('/association/edit', [App\Http\Controllers\AssociationDetailsController::class, 'update'])->name('association.edit.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// User area routes
Route::middleware(['auth', 'verified', 'role'])->group(function () {
    Route::get('/my-cats', [UserDashboardController::class, 'cats'])->name('user.cats');
});

require __DIR__.'/auth.php';
