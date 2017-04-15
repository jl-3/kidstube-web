<?php

namespace App\Http\Controllers;

use App\Category;
use App\Console\Commands\VideosDownload;
use App\Jobs\DownloadYoutubeVideo;
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
     * Show the list of all the videos of current user.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $videos = Auth::user()->videos();
        $category_id = $request->input('category');
        if ($category_id) $videos->where('category_id', $category_id);
        $videos = $videos->orderBy('updated_at', 'desc')->paginate(config('app.pagination'));
        $categories = Auth::user()->categories()->orderBy('name')->get();

        $size = Video::where('type', 1)->sum('size');
        $size_str = $size.' Б';
        if ($size > 1024) { $size = intval($size * 10 / 1024) / 10; $size_str = $size.' КБ'; }
        if ($size > 1024) { $size = intval($size * 10 / 1024) / 10; $size_str = $size.' МБ'; }
        if ($size > 1024) { $size = intval($size * 10 / 1024) / 10; $size_str = $size.' ГБ'; }

        return view('videos', [
            'videos' => $videos,
            'categories' => $categories,
            'filter' => $category_id,
            'local_size' => $size_str,
            'local_count' => Video::where('type', 1)->count(),
        ]);
    }

    /**
     * Add a new video to the KidsTube.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'url' => ['required', 'url', 'unique:videos', 'regex:/(youtube.com\/.*v=|youtu.be\/)/'],
            'category' => 'exists:categories,id'
        ]);

        $url = $request->input('url');

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
            $category->videoList()->save($video);
            $category->updateThumbnail();
        }

        dispatch(new DownloadYoutubeVideo($url));

        return redirect()->route('videos.index', ['category' => $request->input('category')]);
    }

    /**
     * Remove the video from KidsTube.
     *
     * @param Request $request
     * @param Video $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Video $video)
    {
        $cat_id = $video->category_id;
        if ($video->author->id == Auth::id()) $video->delete();
        Category::find($cat_id)->updateThumbnail();
        return redirect()->route('videos.index', ['category' => $cat_id]);
    }

    /**
     * Update video properties (actually update video category).
     *
     * @param Request $request
     * @param Video $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video)
    {
        $oldCategory = $video->category;
        $category = Category::findOrFail($request->input('category_id'));
        $category->videoList()->save($video);
        $category->updateThumbnail();
        if ($oldCategory) $oldCategory->updateThumbnail();
        return redirect()->route('videos.index', ['category' => $category->id]);
    }
}
