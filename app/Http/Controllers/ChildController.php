<?php

namespace App\Http\Controllers;

use App\Category;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChildController extends Controller
{
    /**
     * Show the list of available videos
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $videos = Video::orderBy('created_at', 'desc');
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
        $videos = $videos->paginate(config('app.pagination'));
        $categories = Category::orderBy('name')->get();
        return view('childVideoList', ['videos' => $videos, 'categories' => $categories, 'filter' => $cat]);
    }

    /**
     * Show the video player
     *
     * @param Request $request
     * @param Video $video
     * @return \Illuminate\Http\Response
     */
    public function player(Request $request, Video $video)
    {
        return view('childVideoPlayer', ['video' => $video]);
    }
}
