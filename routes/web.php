<?php

use App\Http\Controllers\WEB\AdminController;
use App\Http\Controllers\WEB\AuthController;
use App\Http\Controllers\WEB\ManagerController;
use App\Http\Controllers\WEB\RedirectController;
use App\Http\Controllers\WEB\PaymentController;
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

    Route::resource('/admin/tiket', \App\Http\Controllers\WEB\TicketController::class);


    Route::post('admin/penjualan/export', [PaymentController::class, 'export'])->name('admin.export');
    Route::post('admin/penjualan/preview', [PaymentController::class, 'preview'])->name('admin.preview');


    Route::get('admin/penjualan', [PaymentController::class, 'index'])->name('admin.penjualan.index');
});

// Manager routes (add this - it was missing)
Route::group(['middleware' => ['auth', 'checkrole:manager']], function () {
    Route::get("/manager", [ManagerController::class, 'index'])->name('manager.dashboard');

    Route::get('/manager/user', [\App\Http\Controllers\WEB\UserController::class, 'index'])->name('manager.user.index');
    Route::delete('/manager/user/destory/{id}', [\App\Http\Controllers\WEB\UserController::class, 'destroy'])->name('manager.user.destroy');
    Route::get('/manager/user/create', [\App\Http\Controllers\WEB\UserController::class, 'create'])->name('manager.user.create');
    Route::post('/manager/user', [\App\Http\Controllers\WEB\UserController::class, 'store'])->name('manager.user.store');
    Route::get('/manager/penjualan', [PaymentController::class, 'indexManager'])->name('manager.penjualan.index');
    Route::get('/manager/tiket', [\App\Http\Controllers\WEB\TicketController::class, 'indexManager'])->name('manager.tiket.index');
    Route::prefix('payment')->name('payment.')->group(function () {
        Route::post('/export', [PaymentController::class, 'export'])->name('manager.export');
        Route::post('/preview', [PaymentController::class, 'previewManager'])->name('manager.preview');
    });
});


