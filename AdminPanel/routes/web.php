<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();

Route::get('/', function() {
    if (Auth::check())
        return redirect()->route('videos');
    else
        return redirect()->route('login');
});

Route::get('/home', 'HomeController@index')->name('videos');

Route::post('/video', 'VideoController@postVideo');
Route::delete('/video/{video}', 'VideoController@deleteVideo');
Route::post('/video/{video}/addTo', 'VideoController@addToCategory');
Route::get('/video/{video}/removeFrom/{category}', 'VideoController@removeFromCategory');
