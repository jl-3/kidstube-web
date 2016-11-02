<?php

namespace App\Http\Controllers;

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
     * Show the application dashboard.
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

        return redirect('/home');
    }
}
