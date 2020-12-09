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

Route::prefix('auth')->middleware(['cors', 'json.response'])->group(function () {
// our routes to be protected will go in here
    Route::middleware('auth:api')->group(function () {
        // our routes to be protected will go in here
        Route::group([], function () {
            Route::post('/logout', 'AuthController@logout')->name('auth.logout');
        });
        Route::prefix('user')->group(function () {
            Route::get('/', "UserController@index");
            Route::get('/find/{id}', "UserController@find");
            Route::put('/update/{id}', "UserController@update");
            Route::delete('/remove/{id}', "UserController@destroy");
            Route::post('/setRole', "UserController@setRoleUser");
            Route::get('/query', "UserController@getUsers");
        });
        Route::prefix('mobile')->group(function () {
            Route::post('/check', 'MobileController@checkVerifyCode')->name('auth.mobile.check');
            Route::post('/retry', 'MobileController@retryGenerateCode')->name('auth.mobile.retry');
        });
        Route::prefix('role')->group(function () {
            Route::get('/', "RoleController@index");
            Route::post('/register', "RoleController@register");
            Route::get('/find/{id}', "RoleController@find");
            Route::put('/update/{id}', "RoleController@update");
            Route::delete('/remove/{id}', "RoleController@destroy");
        });
        Route::prefix('permission')->group(function () {
            Route::get('/', "PermissionController@index");
            Route::post('/register', "PermissionController@register");
            Route::get('/find/{id}', "PermissionController@find");
            Route::put('/update/{id}', "PermissionController@update");
            Route::delete('/remove/{id}', "PermissionController@destroy");
            Route::post('/addPerToRole', "PermissionController@assignPermissionToRole");
        });
    });
    Route::group([], function () {
        Route::post('/login', 'AuthController@login')->name('auth.login');
        Route::post('/register', 'AuthController@register')->name('auth.register');
        Route::prefix('mobile')->group(function () {
            Route::post('/register', 'MobileController@register')->name('auth.mobile.register');
        });
    });

});
