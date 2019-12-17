<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $count = [
            'posts' => \App\Post::count(),
            'users' => \App\User::count(),
            'categories' => \App\Category::count(),
            'tags' => \App\Tag::count(),
        ];
        return view('admin.index', compact('count'));
    }

    public function users()
    {
        $users = \App\User::with('role')->orderByDesc('created_at')->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function deleteUser($id)
    {
        \App\User::destroy($id);
        return redirect()->route('admin.users')->with('message', 'success');
    }

    public function roleUser($id)
    {
        $user = \App\User::find($id);
        !$user->role()->first() ? $user->role()->create(['name' => 'editor']) : '';
        return redirect()->back()->with('message', 'success');
    }

    public function deleteRoleUser($id)
    {
        $user = \App\User::find($id);
        $user->role()->delete();
        return redirect()->back()->with('message', 'success');
    }

    public function posts()
    {
        $posts = \App\Post::with(['user'])->orderByDesc('created_at')->paginate(15);
        return view('admin.posts', compact('posts'));
    }

    public function deletePost($id)
    {
        \App\Post::destroy($id);
        return redirect()->back()->with('message', 'success');
    }

    public function categories()
    {
        $categories = \App\Category::paginate(15);
        return view('admin.categories', compact('categories'));
    }

    public function deleteCategory($id)
    {
        \App\Category::destroy($id);
        return redirect()->back()->with('message', 'success');
    }

    public function tags()
    {
        $tags = \App\Tag::paginate(15);
        return view('admin.tags', compact('tags'));
    }

    public function deleteTag($id)
    {
        \App\Tag::destroy($id);
        return redirect()->back()->with('message', 'success');
    }

    public function statusPost(Request $request, $id)
    {
        \App\Post::find($id)->update(['status' => $request->status]);
        return redirect()->intended(route('admin.posts'))->with('message', 'success');
    }
}
