<?php

namespace App\Http\Controllers;

use App\Category;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KidController extends Controller
{
    /**
     * Show the list of video categories
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::orderBy('updated_at', 'desc')->get();
        return view('kid-home', ['categories' => $categories]);
    }

    /**
     * Show the list of videos in the category
     *
     * @param Request $request
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function category(Request $request, Category $category)
    {
        $videos = $category->videos()->orderBy('created_at', 'desc')->paginate(config('app.pagination'));
        $categories = Category::whereNotNull('thumbnail')->orderBy('name')->get();
        return view('kid-category', ['videos' => $videos, 'categories' => $categories, 'category' => $category]);
    }

    /**
     * Show the video player
     *
     * @param Request $request
     * @param Category $category
     * @param Video $video
     * @return \Illuminate\Http\Response
     */
    public function video(Request $request, Category $category, Video $video)
    {
        return view('kid-video', ['video' => $video, 'category' => $category]);
    }
}
