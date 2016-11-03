<?php

namespace App\Http\Controllers;

use App\Category;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * Add a new video to the KidsTube.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function postVideo(Request $request)
    {
        $this->validate($request, ['url' => 'required|url|unique:videos']);

        $url = $request->input('url');
        $code = substr($url, strrpos($url, 'v=') + 2);
        Video::create([
            'url' => $url,
            'code' => $code,
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('videos');
    }

    /**
     * Remove the video from KidsTube.
     *
     * @param Request $request
     * @param Video $video
     * @return \Illuminate\Http\Response
     */
    public function deleteVideo(Request $request, Video $video)
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
        return redirect()->route('videos');
    }
}
