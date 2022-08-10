<?php

use App\Http\Controllers\Admin\AttachmentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SetupPasswordController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
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

Route::get('/', fn () => view('welcome'));

Route::middleware(['signed'])->get('password-setup', [SetupPasswordController::class, 'show'])->name('setup-password');
Route::middleware(['signed'])->post('password-setup', [SetupPasswordController::class, 'store']);

Route::resource('attachments', AttachmentController::class);

Route::resource('users', UserController::class);
Route::resource('categories', CategoryController::class);
Route::resource('categories.products', ProductController::class);
