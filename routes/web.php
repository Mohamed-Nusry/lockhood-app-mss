<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\KanbanController;
use App\Http\Controllers\AssignedWorkController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\MaterialController;

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

Route::prefix('work')->group(function () {
    Route::prefix('kanban')->group(function () {
        Route::get('/', [KanbanController::class, 'index'])->name('kanban.index');
        Route::post('create', [KanbanController::class, 'create'])->name('kanban.create');
        Route::post('edit', [KanbanController::class, 'edit'])->name('kanban.edit');
        Route::put('update/{id}', [KanbanController::class, 'update'])->name('kanban.update');
        Route::delete('delete/{id}', [KanbanController::class, 'delete'])->name('kanban.delete');
    });

    Route::prefix('assignedwork')->group(function () {
        Route::get('/', [AssignedWorkController::class, 'index'])->name('assignedwork.index');
        Route::post('create', [AssignedWorkController::class, 'create'])->name('assignedwork.create');
        Route::post('edit', [AssignedWorkController::class, 'edit'])->name('assignedwork.edit');
        Route::put('update/{id}', [AssignedWorkController::class, 'update'])->name('assignedwork.update');
        Route::delete('delete/{id}', [AssignedWorkController::class, 'delete'])->name('assignedwork.delete');
    });
});

Route::prefix('inventory')->group(function () {
    Route::prefix('supplier')->group(function () {
        Route::get('/', [SupplierController::class, 'index'])->name('supplier.index');
        Route::post('create', [SupplierController::class, 'create'])->name('supplier.create');
        Route::post('edit', [SupplierController::class, 'edit'])->name('supplier.edit');
        Route::put('update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
        Route::delete('delete/{id}', [SupplierController::class, 'delete'])->name('supplier.delete');
    });

    Route::prefix('material')->group(function () {
        Route::get('/', [MaterialController::class, 'index'])->name('material.index');
        Route::post('create', [MaterialController::class, 'create'])->name('material.create');
        Route::post('edit', [MaterialController::class, 'edit'])->name('material.edit');
        Route::put('update/{id}', [MaterialController::class, 'update'])->name('material.update');
        Route::delete('delete/{id}', [MaterialController::class, 'delete'])->name('material.delete');
    });

  
});




