<?php

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

Route::get('/', function () {
    return view('profile.profile');
});

Route::get('/email/verify/{token}/{user_id}', 'Api\Auth\EmailVerificationController@emailVerification');
Route::get('/password/reset/{token}/{email}', 'Api\Auth\PasswordResetController@passwordReset');
Route::post('/change/password', 'Api\Auth\PasswordResetController@changePassword')->name('change-password');
