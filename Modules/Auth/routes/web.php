<?php

use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;
use Modules\Auth\Livewire\Login;
use Modules\Auth\Livewire\Register;
use Modules\Auth\Livewire\ResetPassword;

//register
Route::get('/register' , Register::class)->middleware('guest')->name('register');
//login
Route::get('/login' , Login::class)->middleware('guest')->name('login');
//reset password
Route::get('/reset_password' , ResetPassword::class)->middleware('guest')->name('reset_password');
//logout
Route::middleware('auth')->get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');
