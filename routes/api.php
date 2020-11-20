<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::apiResource('posts', '\App\Http\Controllers\API\PostController'); // Without Auth

/*
 * PASSPORT ROUTES
 */

Route::post('register', '\App\Http\Controllers\Auth\LoginController@register');
Route::post('login', '\App\Http\Controllers\Auth\LoginController@login');//->name('login');
Route::get('login', '\App\Http\Controllers\Auth\LoginController@login')->name('login');
Route::middleware('auth:api')->get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::middleware('auth:api')->get('posts', '\App\Http\Controllers\API\PostController@index'); // With Auth
Route::middleware('auth:api')->get('user', function (Request $request) {
    return $request->user();
})->name('user');
