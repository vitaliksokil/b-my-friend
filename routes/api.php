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
            Route::post('/change', 'EmailController@update');
        });
    });

    Route::group(['prefix'=>'users','middleware' => 'auth:api'],function (){
        Route::get('/', 'UserController@getAllUsers');
        Route::put('/', 'UserController@update');
        Route::patch('/upload-photo', 'UserController@uploadPhoto');
        Route::group(['prefix'=>'posts'],function (){
            Route::post('/','PostController@store');
            Route::get('/','PostController@index');
            Route::get('/of/{user_id}','PostController@getUserPosts');
            Route::get('/{post}','PostController@show');
            Route::put('/{post}','PostController@update');
            Route::delete('/{post}','PostController@destroy');
        });
        Route::group(['prefix'=>'feeds'],function (){
            Route::get('/of/{user_id}','FeedController@getUserFeeds');
            Route::post('/','FeedController@store');
            Route::get('/','FeedController@index');
            Route::get('/{feed}','FeedController@show');
            Route::put('/{feed}','FeedController@update');
            Route::delete('/{feed}','FeedController@destroy');
        });
    });

    Route::group(['prefix'=>'followers','middleware' => 'auth:api'],function (){
        Route::get('/', 'FollowerController@getAllFollowers');
        Route::get('/count-all', 'FollowerController@getAllFollowersCount');
    });
    Route::group(['prefix'=>'following','middleware' => 'auth:api'],function (){
        Route::get('/', 'FollowerController@getAllFollowing');
        Route::get('/count-all', 'FollowerController@getAllFollowingCount');
        Route::post('/', 'FollowerController@follow');
        Route::delete('/{user_id}', 'FollowerController@unFollow');
    });

    Route::group(['prefix'=>'groups','middleware' => 'auth:api'],function (){
        Route::get('/of/{user_id}','GroupController@getUserGroups');
        Route::post('/','GroupController@store');
        Route::get('/','GroupController@index');
        Route::get('/{group_id}','GroupController@show');
        Route::put('/{group_id}','GroupController@update');
        Route::delete('/{group_id}','GroupController@destroy');
    });
});

