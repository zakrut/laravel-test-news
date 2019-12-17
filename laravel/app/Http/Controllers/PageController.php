<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $posts = \App\Post::where('status', 'pub')->with(['category', 'tags'])->orderByDesc('weight')->orderByDesc('created_at')->paginate(15);
        $categories = \App\Category::get();
        return view('pages.index', compact('posts', 'categories'));
    }
    public function category($id)
    {
        if($id != 0){
            $category = \App\Category::findOrFail($id);
            $posts = \App\Post::where([['status', 'pub'], ['category_id', $id]])->with(['category', 'tags'])->orderByDesc('weight')->orderByDesc('created_at')->paginate(15);
        }
        else{
            $posts = \App\Post::where([['status', 'pub'], ['category_id', null]])->with(['category', 'tags'])->orderByDesc('weight')->orderByDesc('created_at')->paginate(15);
        }
        $categories = \App\Category::get();
        return view('pages.index', compact('posts', 'categories'));
    }
}
