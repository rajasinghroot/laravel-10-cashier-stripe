<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HomeController;


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

Route::get('/', function () {
    if(Auth::check()) {return redirect('/products');}
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function() {
    /* Stripe*/
    /* Shop page routes */
    Route::get('/products', [ProductController::class, 'index'])->name('product-list');
    Route::get('/checkout/{id}', [ProductController::class, 'checkout'])->name('product-checkout');
    // /* Stripe payment routes */
    Route::post('/ajax-get-set-up-intent', [PaymentController::class, 'ajaxGetSetUpIntent'])->name('ajax-get-set-up-intent');
    Route::post('/purchase', [PaymentController::class, 'purchase'])->name('purchase');
    // /* Success page route */
    Route::get('/success', [OrderController::class, 'success'])->name('success');
    // /* My orders page route */
    Route::get('/orders', [OrderController::class, 'showOrders'])->name('order-lists');  

});