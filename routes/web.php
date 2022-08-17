<?php

use App\Http\Controllers\ProductController;
use App\Http\Requests\IndexController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', IndexController::class)->name('index');

Route::get('categories/{category:slug}/products/{product:slug}', [ProductController::class, 'show'])
    ->name('categories.products.show')
    ->scopeBindings();
