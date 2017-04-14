<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', 'KidController@index')->name('kid-home');
Route::get('/category{category}', 'KidController@category')->name('kid-category');
Route::get('/category{category}/{video}', 'KidController@video')->name('kid-video');

Auth::routes();

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function() {
    Route::get('/', function() {
        if (Auth::check())
            return redirect()->route('videos');
        else
            return redirect()->route('login');
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
});
