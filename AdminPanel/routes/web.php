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

Route::get('/', function () {
    if (Auth::check())
        return redirect('/videos');
    else
        return redirect('/login');
});

Route::get('/login', function() {
    return view('welcome');
});

Route::get('/videos', function() {
    return view('videos');
});
