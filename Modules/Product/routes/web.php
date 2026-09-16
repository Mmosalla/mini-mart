<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\ProductController;
use Modules\Product\Livewire\ProductList;

Route::middleware(['auth' , 'verified'])
    ->prefix('admin')
    ->get('/product_management' , ProductList::class)->name('product-management');
