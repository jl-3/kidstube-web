<?php

namespace App\Http\Controllers;

use App\Category;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChildController extends Controller
{
    /**
     * Show the list of video categories
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // small fix: update all the categories that don't have a photo
        foreach (Category::whereNull('thumbnail')->get() as $category)
        {
            $lastVideo = $category->videos()->orderBy('id', 'desc')->first();
            if ($lastVideo != null) {
                $category->thumbnail = "http://img.youtube.com/vi/$lastVideo->code/0.jpg";
                $category->save();
            }
        }

        // display categories
        $categories = Category::whereNotNull('thumbnail')->orderBy('name')->get();
        return view('childVideoCategories', ['categories' => $categories]);
    }

    /**
     * Show the list of videos in the category
     *
     * @param Request $request
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function videoList(Request $request, Category $category)
    {
        $videos = Video::whereExists(function($query) use ($category) {
            $query
                ->select(DB::raw(1))
                ->from('video_categories')
                ->whereRaw('video_categories.video_id = videos.id')
                ->where('video_categories.category_id', '=', $category->id);
        })->orderBy('created_at', 'desc')->paginate(config('app.pagination'));
        $categories = Category::whereNotNull('thumbnail')->orderBy('name')->get();
        return view('childVideoList', ['videos' => $videos, 'categories' => $categories, 'category' => $category]);
    }

    /**
     * Show the video player
     *
     * @param Request $request
     * @param Category $category
     * @param Video $video
     * @return \Illuminate\Http\Response
     */
    public function player(Request $request, Category $category, Video $video)
    {
        return view('childVideoPlayer', ['video' => $video, 'category' => $category]);
    }
}
