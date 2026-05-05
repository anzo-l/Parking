<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');
    Route::post('/reservation/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservation.cancel');
    Route::post('/waitlist/{id}/cancel', [ReservationController::class, 'cancelWaitlist'])->name('reservation.cancel-waitlist');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    
    // Gestion utilisateurs
    Route::get('/admin/users/create', [AdminController::class, 'create_user'])->name('admin.users.create');
    Route::post('/admin/users', [AdminController::class, 'store_user'])->name('admin.users.store');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'edit_user'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [AdminController::class, 'update_user'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'delete_user'])->name('admin.users.destroy');
    
    // Gestion places de parking
    Route::get('/admin/parking/create', [AdminController::class, 'create_parking'])->name('admin.parking.create');
    Route::post('/admin/parking', [AdminController::class, 'store_parking'])->name('admin.parking.store');
    Route::get('/admin/parking/{id}/edit', [AdminController::class, 'edit_parking'])->name('admin.parking.edit');
    Route::put('/admin/parking/{id}', [AdminController::class, 'update_parking'])->name('admin.parking.update');
    Route::delete('/admin/parking/{id}', [AdminController::class, 'delete_parking'])->name('admin.parking.destroy');
    
    // Gestion file d'attente
    Route::delete('/admin/waitlist/{id}', [AdminController::class, 'remove_from_waitlist'])->name('admin.waitlist.destroy');
    Route::post('/admin/waitlist/{id}/promote', [AdminController::class, 'promote_from_waitlist'])->name('admin.waitlist.promote');
});

require __DIR__.'/auth.php';
