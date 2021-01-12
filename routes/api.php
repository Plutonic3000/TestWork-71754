<?php

use App\Http\Controllers\API\PostController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::group(['prefix' => 'auth'], function() {
    Route::post('register', '\App\Http\Controllers\API\APIController@register');
    Route::post('login', '\App\Http\Controllers\API\APIController@login');
    Route::get('login', '\App\Http\Controllers\API\APIController@login')->name('login');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', '\App\Http\Controllers\API\APIController@logout');
    });
});

Route::group(['prefix' => 'account'], function() {
    Route::middleware('auth:api')->get('profile', function (Request $request) {
        return $request->user();
    })->name('profile');
});

Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth:api', 'scope:do_anything'],
], function () {
    Route::apiResource('posts', '\App\Http\Controllers\API\PostController');
    Route::get('blog', function (Request $request) {
        return $request->user();
    });
});

Route::apiResource('posts', PostController::class);
