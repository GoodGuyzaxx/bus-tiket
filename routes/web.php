<?php

use App\Http\Controllers\WEB\AdminController;
use App\Http\Controllers\WEB\AuthController;
use App\Http\Controllers\WEB\ManagerController;
use App\Http\Controllers\WEB\RedirectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function (){
    return view ('welcome');
});


Route::middleware('guest')->group(function (){
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::middleware(['auth'])->group(function (){
    Route::post('/logout', [AuthController::class,'logout'])->name('logout');
    Route::post('/redirect', [RedirectController::class, 'cek']);

    Route::get('/dashboard', [RedirectController::class, 'dashboard'])->name('dashboard');
});

// Admin routes
Route::group(['middleware' => ['auth', 'checkrole:admin']], function () {
    Route::get("/admin", [AdminController::class, 'index'])->name('admin.dashboard');

    Route::resource('/admin/bus', \App\Http\Controllers\WEB\BusController::class);

    Route::resource('/admin/rute', \App\Http\Controllers\WEB\RuteController::class);
});

// Manager routes (add this - it was missing)
Route::group(['middleware' => ['auth', 'checkrole:manager']], function () {
    Route::get("/manager", [ManagerController::class, 'index'])->name('manager.dashboard');

    Route::get('/manager/user', [\App\Http\Controllers\WEB\UserController::class, 'index'])->name('manager.user.index');
    Route::get('/manager/user/create', [\App\Http\Controllers\WEB\UserController::class, 'create'])->name('manager.user.create');
    Route::post('/manager/user', [\App\Http\Controllers\WEB\UserController::class, 'store'])->name('manager.user.store');
});


