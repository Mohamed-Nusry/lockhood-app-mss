<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DepartmentController;

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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home');


Route::prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::post('create', [UserController::class, 'create'])->name('user.create');
    Route::post('edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('delete/{id}', [UserController::class, 'delete'])->name('user.delete');
});

Route::prefix('department')->group(function () {
    Route::get('/', [DepartmentController::class, 'index'])->name('department.index');
    Route::post('create', [DepartmentController::class, 'create'])->name('department.create');
    Route::post('edit', [DepartmentController::class, 'edit'])->name('department.edit');
    Route::put('update/{id}', [DepartmentController::class, 'update'])->name('department.update');
    Route::delete('delete/{id}', [DepartmentController::class, 'delete'])->name('department.delete');
});

