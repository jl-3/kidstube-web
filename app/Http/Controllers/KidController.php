<?php

namespace App\Http\Controllers;

use App\Category;
use App\Helpers\YouTubeLinkParser;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $categories = Category::whereNotNull('thumbnail')->orderBy('updated_at', 'desc')->get();
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
        $videos = $category->videoList()->orderBy('updated_at', 'desc')->paginate(config('app.pagination'));
        return view('kid-category', ['videos' => $videos, 'category' => $category]);
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
        $parser = new YouTubeLinkParser($video->url);
        return view('kid-video', ['video' => $video, 'mp4' => $parser->url, 'category' => $category]);
    }
}
