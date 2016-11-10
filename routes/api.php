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

Route::get('/categories', 'ApiController@categories');
Route::get('/categories/{category}', 'ApiController@category');
Route::get('/categories/{category}/videos', 'ApiController@videos');
Route::get('/categories/{category}/videos/{video}', 'ApiController@video');
