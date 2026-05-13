<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;

/*
|--------------------------------------------------------------------------
| USER AREA
|--------------------------------------------------------------------------
*/

// halaman static
Route::view('/profil', 'profil');
Route::view('/katalog', 'katalog');
Route::view('/bantuan', 'bantuan');

// homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// detail event (sementara hardcoded)
Route::get('/event/1', [EventController::class, 'show'])
    ->name('events.show');

// checkout
Route::get('/checkout', [EventController::class, 'checkout'])
    ->name('checkout');

// ticket
Route::get('/my-ticket', [EventController::class, 'ticket'])
    ->name('ticket');
    
Route::get('/api/events', [EventController::class, 'filterByCategory']);


/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('events', AdminEventController::class);

    Route::get('/categories', [AdminCategoryController::class, 'index'])
        ->name('categories.index');

    Route::get('/transactions', [AdminTransactionController::class, 'index'])
        ->name('transactions.index');
});