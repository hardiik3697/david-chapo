<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IndexController;

Route::group(['middleware' => ['prevent-back-history']], function(){
    /** frontend */
        Route::get('/', [IndexController::class, 'index'])->name('index');
    /** frontend */

    /** backend */
        Route::group(['middleware' => 'guest'], function () {
            Route::get('/login', [AuthController::class, 'login'])->name('login');
            Route::post('/singin', [AuthController::class, 'singin'])->name('singin');
        });

        Route::group(['middleware' => ['auth']], function () {
            /** Dashboard */
                Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

                Route::controller(DashboardController::class)->group(function () {
                    Route::get('/dashboard', 'dashboard')->name('dashboard');
                    Route::get('/profile', 'profile')->name('profile');
                    Route::get('/profile-update', 'profileUpdate')->name('profile.update');
                    Route::post('/update-profile', 'updateProfile')->name('update.profile');
                    Route::get('/change-password', 'changePassword')->name('change.password');
                    Route::post('/password-change', 'passwordChange')->name('password.change');
                });
            /** Dashboard */

            /** user */
                Route::controller(UserController::class)->group(function () {
                    Route::any('/user', 'index')->name('user');
                    Route::get('/user/create', 'create')->name('user.create');
                    Route::post('/user/insert', 'insert')->name('user.insert');
                    Route::get('/user/update/{id?}', 'update')->name('user.update');
                    Route::patch('/user/alter/{id?}', 'alter')->name('user.alter');
                    Route::get('/user/read/{id?}', 'read')->name('user.read');
                    Route::post('/user/status', 'status')->name('user.status');
                });
            /** user */
        });
    /** backend */

    /** this for route anynomus route redirect to index */
        Route::get("{path?}", function () {
            return redirect()->route('index');
        })->where('path', '.+');
    /** this for route anynomus route redirect to index */
});
