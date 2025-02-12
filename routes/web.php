<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PaymentController;

/** Frontend pages */
    Route::controller(IndexController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/platform/{id?}', 'platform')->name('platform');

            /** get link and sent to payment page */
                Route::get('/link/{key?}', 'link')->name('link');
            /** get link and sent to payment page */
        });
/** Frontend pages */

/** Stripe payments */
    Route::controller(PaymentController::class)
        ->prefix('/payment')
        ->name('payment.')
        ->group(function () {
            Route::get('/charge', 'charge')->name('charge');
            Route::post('/charge/process', 'process')->name('process');
            Route::get('/checkout', 'checkout')->name('checkout');
            Route::get('/element', 'element')->name('element');
            Route::get('/success', 'success')->name('success');
            Route::post('/status', 'status')->name('status');
        });
/** Stripe payments */

/** Random route to main route */
    Route::get("{path}", function () { return redirect()->route('index'); })->where('path', '.+');
/** Random route to main route */