<?php

namespace App\Http\Controllers;

use App\Category;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Auth::user()->videos()->orderBy('created_at', 'desc')->paginate(4);
        $categories = Auth::user()->categories()->orderBy('name');
        return view('home', ['videos' => $videos, 'categories' => $categories]);
    }
}
