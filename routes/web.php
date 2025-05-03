<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BulkActionController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\RelationshipController;
use App\Http\Controllers\User\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('', [PartnerController::class, 'partner'])->name('partner');
Route::post('partner', [PartnerController::class, 'store'])->name('partner.submit');

Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'login'])->name('login');
        Route::post('login', [AuthController::class, 'authenticate'])->name('submitLogin');
    });

    Route::middleware('auth')->group(function () {
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::resource('relationship', RelationshipController::class);


        Route::get('contact', [PartnerController::class, 'index'])->name('contact');

        Route::post('/delete-items', [BulkActionController::class, 'deleteItems'])->name('delete.items');

    });
});

