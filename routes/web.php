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

    Route::prefix('/shop')
        ->name('shop')
        ->group(function() {
            Route::get('/{slug?}', [ShopController::class, 'index']);
            Route::post('/cart', [ShopController::class, 'addToCart'])->name('.cart');

            Route::get('/orders/{order}', [ShopController::class, 'getOrder'])->name('.order');
            Route::post('/orders', [ShopController::class, 'order'])->name('.order.create');
        });
});

// VerifyCsrfToken!!!!!!
Route::post('/webhooks/mollie', [ShopController::class, 'webhook'])->name('webhooks.mollie');

require __DIR__.'/auth.php';
