<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\KeycloakAuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ItemController;

Route::view('/login', 'auth.login')->name('login');

Route::get('/auth/keycloak/redirect', [KeycloakAuthController::class, 'redirect'])->name('auth.keycloak.redirect');
Route::get('/auth/keycloak/callback', [KeycloakAuthController::class, 'callback'])->name('auth.keycloak.callback');
Route::post('/logout', [KeycloakAuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/logout/callback', [KeycloakAuthController::class, 'logoutCallback'])->name('auth.keycloak.logout.callback');

Route::middleware('auth')->group(function () {
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
    Route::patch('/items/{item}', [ItemController::class, 'update'])->name('items.update');
    Route::post('/items/{item}/pause', [ItemController::class, 'pause'])->name('items.pause');
    Route::post('/items/{item}/photos', [ItemController::class, 'storePhoto'])->name('items.photos.store');
    Route::get('/items/{item}/availability', [ItemController::class, 'availability'])->name('items.availability');
    Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');

    Route::post('/items/{item}/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings/{booking}/approve', [BookingController::class, 'approve'])->name('bookings.approve');
    Route::post('/bookings/{booking}/reject', [BookingController::class, 'reject'])->name('bookings.reject');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::get('/items/{item}/photos/{photo}', [ItemController::class, 'showPhoto'])->name('items.photos.show');
});

Route::get('/dashboard', function () {
    return redirect()->route(auth()->user()->role === 'ADMIN' ? 'admin.dashboard' : 'student.dashboard');
})->middleware('auth')->name('dashboard');

Route::view('/admin/dashboard', 'dashboard', ['pageRole' => 'ADMIN'])
    ->middleware(['auth', 'role:ADMIN'])
    ->name('admin.dashboard');
Route::view('/student/dashboard', 'dashboard', ['pageRole' => 'STUDENT'])
    ->middleware(['auth', 'role:STUDENT'])
    ->name('student.dashboard');

Route::redirect('/', '/dashboard');
