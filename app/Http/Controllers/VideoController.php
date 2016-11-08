<?php

namespace App\Http\Controllers;

use App\Category;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VideoController extends Controller
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
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $videos = Auth::user()->videos();
        $cat = $request->input('category');
        if ($request->has('category')) {
            $videos->whereExists(function($query) use ($cat) {
                $query
                    ->select(DB::raw(1))
                    ->from('video_categories')
                    ->whereRaw('video_categories.video_id = videos.id')
                    ->where('video_categories.category_id', '=', $cat);
            });
        }
        $videos = $videos->orderBy('created_at', 'desc')->paginate(config('app.pagination'));
        $categories = Auth::user()->categories()->orderBy('name')->get();
        return view('videos', ['videos' => $videos, 'categories' => $categories, 'filter' => $cat]);
    }

    /**
     * Add a new video to the KidsTube.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $this->validate($request, [
            'url' => ['required', 'url', 'unique:videos', 'regex:/(youtube.com\/.*v=|youtu.be\/)/'],
            'category' => 'exists:categories,id'
        ]);

        $url = $request->input('url');

        $code = '';
        if (preg_match('/youtube.com\/.*v=([a-zA-Z0-9\-_]+)/', $url, $matches)) $code = $matches[1];
        else if (preg_match('/youtu.be\/([a-zA-Z0-9\-_]+)/', $url, $matches)) $code = $matches[1];
        else die('Incorrect video code');

        $video = Video::create([
            'url' => $url,
            'code' => $code,
            'user_id' => Auth::user()->id,
        ]);

        if ($request->has('category')) {
            $category = Category::findOrFail($request->input('category'));
            $category->videos()->attach($video);
            $category->thumbnail = "http://img.youtube.com/vi/$video->code/0.jpg";
            $category->save();
        }

        return redirect()->route('videos');
    }

    /**
     * Remove the video from KidsTube.
     *
     * @param Request $request
     * @param Video $video
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request, Video $video)
    {
        $video->delete();
        return redirect()->route('videos');
    }

    /**
     * Add the video to the category.
     *
     * @param Request $request
     * @param Video $video
     * @return \Illuminate\Http\Response
     */
    public function addToCategory(Request $request, Video $video)
    {
        $category = Category::findOrFail($request->input('category'));
        $video->categories()->attach($category->id);
        $category->thumbnail = "http://img.youtube.com/vi/$video->code/0.jpg";
        $category->save();
        return redirect()->route('videos');
    }

    /**
     * Remove the video from the category.
     *
     * @param Request $request
     * @param Video $video
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function removeFromCategory(Request $request, Video $video, Category $category)
    {
        $video->categories()->detach($category->id);
        $lastVideo = $category->videos()->orderBy('id', 'desc')->first();
        if ($lastVideo != null) {
            $category->thumbnail = "http://img.youtube.com/vi/$lastVideo->code/0.jpg";
            $category->save();
        }
        return redirect()->route('videos');
    }
}
