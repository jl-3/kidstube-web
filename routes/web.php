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
Route::get('/home', function() {
    return redirect()->route('videos');
});

Route::get('/videos', 'VideoController@index')->name('videos');
Route::post('/video', 'VideoController@add');
Route::delete('/video/{video}', 'VideoController@remove');
Route::post('/video/{video}/addTo', 'VideoController@addToCategory');
Route::get('/video/{video}/removeFrom/{category}', 'VideoController@removeFromCategory');

Route::get('/categories', 'CategoriesController@index')->name('categories');
Route::post('/category', 'CategoriesController@add');
Route::put('/category/{category}', 'CategoriesController@edit');
Route::delete('/category/{category}', 'CategoriesController@remove');
