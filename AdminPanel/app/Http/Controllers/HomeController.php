<?php

namespace App\Http\Controllers;

use App\Category;
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
        $categories = Auth::user()->categories()->orderBy('name')->get();
        return view('home', ['videos' => $videos, 'categories' => $categories]);
    }
}
