<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
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
     * Show the list of all the categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Auth::user()->categories()->orderBy('name')->get();
        return view('categories', ['categories' => $categories]);
    }

    /**
     * Add a new video category to the KidsTube.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $this->validate($request, ['name' => 'required|unique:categories']);

        Category::create([
            'name' => $request->input('name'),
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('categories');
    }

    /**
     * Edits the existing category.
     *
     * @param Request $request
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Category $category)
    {
        $this->validate($request, ['name' => 'required|unique:categories']);

        $category->name = $request->input('name');
        $category->save();

        return redirect()->route('categories');
    }

    /**
     * Remove the category from KidsTube.
     *
     * @param Request $request
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request, Category $category)
    {
        $category->delete();
        return redirect()->route('categories');
    }
}
