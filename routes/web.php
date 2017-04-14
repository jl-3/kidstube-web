<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', 'KidController@index')->name('kid-home');
Route::get('/watch/{category}', 'KidController@category')->name('kid-category');
Route::get('/watch/{category}/{video}', 'KidController@video')->name('kid-video');

Auth::routes();

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function() {
    Route::get('/', function() {
        if (Auth::check())
            return redirect()->route('videos');
        else
            return redirect()->route('login');
    });

    Route::resource('videos', 'VideoController');
    Route::resource('categories', 'CategoriesController');
});
