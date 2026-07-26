<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;
use Modules\Auth\Livewire\Register;

Route::get('/register' , Register::class)->name('register');
