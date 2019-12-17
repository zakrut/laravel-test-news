<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;
use Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $posts = $user->posts()->orderByDesc('created_at')->paginate(15);
        return view('user.posts', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = \App\Tag::get();
        $categories = \App\Category::get();
        return view('user.post_create', compact('tags', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'title'       => 'required|string|max:255',
            'subtitle'    => 'required|string|max:255',
            'content'     => 'required|string',
            'weight'      => 'required|integer|min:1|max:10',
            'status'      => 'required|string|in:mod,pub',
            'preview_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2000',
            'post_img'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2000',
            'categories'  => 'nullable|string',
            'tags'        => 'nullable|string',
        ]);
        $post = \App\Post::newPost($request);
        if(!$post){
            return redirect()->back()->withInput()->with('message', 'error');
        }
        return redirect()->intended(route('user.index.posts'))->with('message', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('pages.post', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tags = \App\Tag::get();
        $categories = \App\Category::get();
        $post = Post::with('category', 'tags')->findOrFail($id);
        $post_tags = null;
        if($post->tags){
            foreach($post->tags as $tag){
                $post_tags = $post_tags.','.$tag->name;
            }
            $post_tags = substr($post_tags, 1);
        }
        return view('user.post_edit', compact('post', 'post_tags', 'tags', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = \App\Post::find($id);
        $validate = $request->validate([
            'title'       => 'required|string|max:255',
            'subtitle'    => 'required|string|max:255',
            'content'     => 'required|string',
            'weight'      => 'required|integer|min:1|max:10',
            'status'      =>  $post->status == 'cls' ? 'nullable' : 'required|string|in:mod,pub',
            'preview_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2000',
            'post_img'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2000',
            'categories'  => 'nullable|string',
            'tags'        => 'nullable|string',
        ]);
        $post->updatePost($request, $post);
        return redirect()->intended(route('user.index.posts'))->with('message', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::destroy($id);
        return redirect()->back()->with('message', 'success');
    }
}
