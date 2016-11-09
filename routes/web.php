<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', 'ChildController@index')->name('childHome');
Route::get('/category{category}', 'ChildController@videoList')->name('childVideoList');
Route::get('/category{category}/{video}', 'ChildController@player')->name('childVideoPlayer');

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
