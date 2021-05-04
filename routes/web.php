<?php

use App\Http\Controllers\Shop\ShopController;
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

Route::middleware(['auth', 'verified'])->group(function() {

    Route::get('/', function() {
        return redirect()->route('shop');
    });

    Route::get('/shop/{slug?}', [ShopController::class, 'index'])->name('shop');
});

require __DIR__.'/auth.php';
