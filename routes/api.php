<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace'=>'Api'], function ($router) {

    Route::group(['namespace'=>'Auth'], function ($router) {
        Route::group(['prefix'=>'auth'],function (){
            Route::post('register', 'AuthController@register');
            Route::post('login', 'AuthController@login');
            Route::post('reset-password', 'PasswordResetController@resetPassword');
            Route::post('android/reset-password', 'PasswordResetController@androidResetPassword');
            Route::post('android/reset-code-check', 'PasswordResetController@androidResetCodeCheck');
            Route::post('android/password-change', 'PasswordResetController@androidChangePassword');

            Route::group(['middleware' => 'auth:api'],function (){
                Route::post('logout', 'AuthController@logout');
                Route::post('refresh', 'AuthController@refresh');
                Route::post('me', 'AuthController@me');
            });
        });
        Route::group(['prefix'=>'email','middleware' => 'auth:api'],function (){
            Route::post('/send-verification', 'EmailVerificationController@sendEmailVerification');
        });
    });


});

