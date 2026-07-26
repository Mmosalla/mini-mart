<?php

use Illuminate\Support\Facades\Route;
use Modules\Dashboard\Http\Controllers\DashboardController;
use Modules\Dashboard\Livewire\Panel;

Route::prefix('admin/')->get('/dashboard', Panel::class)->name('admin.dashboard');
