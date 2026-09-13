<?php

use Illuminate\Support\Facades\Route;
use Modules\Category\Livewire\CategoryList;

Route::prefix('/admin')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/categories', CategoryList::class)->name('category');
});
