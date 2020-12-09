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

Route::prefix('product')->middleware(['cors', 'json.response'])->group(function () {
// our routes to be protected will go in here
    Route::middleware('auth:api')->group(function () {
        // our routes to be protected will go in here
        Route::group([], function () {
            Route::get('/', 'ProductController@index');
            Route::post('/', 'ProductController@store');
            Route::get('/show/{id}', 'ProductController@show');
            Route::put('/update/{id}', 'ProductController@update');
            Route::delete('/destroy/{id}', 'ProductController@destroy');
            Route::get('/query', 'ProductController@getProduct');
        });
        Route::prefix("cart")->group( function () {
            // this part similar up (ProductController)
        });

    });
;

});
