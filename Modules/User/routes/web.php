<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Livewire\UserList;

Route::prefix('/admin')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/users' , UserList::class)->name('admin.users');
});


