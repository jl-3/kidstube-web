<?php

namespace App\Http\Controllers;

use App\Category;
use App\Video;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function categories()
    {
        return Category::whereNotNull('thumbnail')->orderBy('name')->get();
    }

    public function category(Category $category)
    {
        return $category;
    }

    public function videos(Category $category)
    {
        return $category->videos()->orderBy('created_at', 'desc')->get();
    }

    public function video(Category $category, Video $video)
    {
        return $video;
    }
}
