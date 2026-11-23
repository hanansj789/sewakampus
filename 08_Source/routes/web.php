<?php

use Illuminate\Support\Facades\Route;

Route::view('/login', 'auth.login')->name('login');

Route::view('/dashboard', 'dashboard')->middleware('auth')->name('dashboard');

Route::redirect('/', '/dashboard');
