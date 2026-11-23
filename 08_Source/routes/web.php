<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\KeycloakAuthController;

Route::view('/login', 'auth.login')->name('login');

Route::get('/auth/keycloak/redirect', [KeycloakAuthController::class, 'redirect'])->name('auth.keycloak.redirect');
Route::get('/auth/keycloak/callback', [KeycloakAuthController::class, 'callback'])->name('auth.keycloak.callback');
Route::post('/logout', [KeycloakAuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/logout/callback', [KeycloakAuthController::class, 'logoutCallback'])->name('auth.keycloak.logout.callback');

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
