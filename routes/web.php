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
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

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
        Route::post('status', [KanbanController::class, 'changeStatus'])->name('kanban.status');
    });

    Route::prefix('assignedwork')->group(function () {
        Route::get('/', [AssignedWorkController::class, 'index'])->name('assignedwork.index');
        Route::post('create', [AssignedWorkController::class, 'create'])->name('assignedwork.create');
        Route::post('edit', [AssignedWorkController::class, 'edit'])->name('assignedwork.edit');
        Route::put('update/{id}', [AssignedWorkController::class, 'update'])->name('assignedwork.update');
        Route::delete('delete/{id}', [AssignedWorkController::class, 'delete'])->name('assignedwork.delete');
        Route::post('status', [AssignedWorkController::class, 'changeStatus'])->name('assignedwork.status');
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

    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('product.index');
        Route::post('create', [ProductController::class, 'create'])->name('product.create');
        Route::post('edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('update/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
    });

    Route::prefix('order')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('order.index');
        Route::post('create', [OrderController::class, 'create'])->name('order.create');
        Route::post('price', [OrderController::class, 'price'])->name('order.price');
        Route::post('edit', [OrderController::class, 'edit'])->name('order.edit');
        Route::put('update/{id}', [OrderController::class, 'update'])->name('order.update');
        Route::delete('delete/{id}', [OrderController::class, 'delete'])->name('order.delete');
    });

  
});

Route::prefix('report')->group(function () {
    Route::prefix('work')->group(function () {
        Route::get('/', [ReportController::class, 'workreport'])->name('workreport.index');
        Route::post('/pdf', [ReportController::class, 'workreportPDF'])->name('workreport.pdf');
    });
    Route::prefix('income')->group(function () {
        Route::get('/', [ReportController::class, 'incomereport'])->name('incomereport.index');
        Route::post('/pdf', [ReportController::class, 'incomereportPDF'])->name('incomereport.pdf');
    });
});




