<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Image;

class Post extends Model
{
    protected $fillable = [
        'type',
        'user_id',
        'category_id',
        'title',
        'subtitle',
        'content',
        'weight',
        'preview_img',
        'post_img',
        'status',
    ];

    public static function boot() {
        parent::boot();
        // DElete images from POST
        self::deleting(function($post) {
            if($post->preview_img && Storage::disk('public')->exists('/posts/'. $post->preview_img)){
                Storage::disk('public')->delete('/posts/'. $post->preview_img);
            }
            if($post->post_img && Storage::disk('public')->exists('/posts/'. $post->post_img)){
                Storage::disk('public')->delete('/posts/'. $post->post_img);
            }
        });    
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'post_tag');
    }

    // Create new POST
    public static function newPost($request){
        $user = auth()->user();
        $preview_img = null;
        if($request->hasFile('preview_img')){

            $preview_img = Image::make($request->file('preview_img'))->fit(220, 220)->save(storage_path('app/public/posts') .'/preview_'. uniqid(). '_'. $user->id .'.png')->basename;
        }
        $post_img = null;
        if($request->hasFile('post_img')){

            $post_img = Image::make($request->file('post_img'))->save(storage_path('app/public/posts') .'/post_'. uniqid(). '_'. $user->id .'.png')->basename;
        }
        $request->categories ? $category_id = \App\Category::firstOrCreate(['name' => $request->categories])->id : $category_id = null;
        $post = $user->posts()->create([
            'title'       => $request->title,
            'subtitle'    => $request->subtitle,
            'content'     => $request->content,
            'weight'      => $request->weight, 
            'preview_img' => $preview_img,
            'post_img'    => $post_img,
            'category_id' => $category_id,
            'status'      => $request->status,
        ]);
        if($request->tags){
            $array_tags_post = array_map('trim', explode(',', $request->tags));
            $tags = \App\Tag::get();
            $array_tags = $tags->pluck('name')->toArray();
            $diff_tags = array_diff($array_tags_post, $array_tags);
            $diff_tags_id = [];
            if($diff_tags){
                foreach ($diff_tags as $tag) {
                    $array_diff_tags[]['name'] = $tag;
                }
                $diff_tags_id = \App\Tag::insertGetId($array_diff_tags);
            }
            $exist_tags_id = $tags->whereIn('name', $array_tags_post)->pluck('id')->toArray();
            $tags_id = array_merge($diff_tags_id, $exist_tags_id);
            $post->tags()->sync($tags_id);
        }        
        return $post;
    }

    // Update POST
    public function updatePost($request, $post){
        $preview_img = $post->preview_img;
        if($request->hasFile('preview_img')){
            if($post->preview_img && Storage::disk('public')->exists('/posts/'. $post->preview_img)){
                Storage::disk('public')->delete('/posts/'. $post->preview_img);
            }
            $preview_img = Image::make($request->file('preview_img'))->fit(220, 220)->save(storage_path('app/public/posts') .'/preview_'. uniqid(). '_'. $post->user_id .'.png')->basename;
        }
        $post_img = $post->post_img;
        if($request->hasFile('post_img')){
            if($post->post_img && Storage::disk('public')->exists('/posts/'. $post->post_img)){
                Storage::disk('public')->delete('/posts/'. $post->post_img);
            }
            $post_img = Image::make($request->file('post_img'))->save(storage_path('app/public/posts') .'/post_'. uniqid(). '_'. $post->user_id .'.png')->basename;
        }
        $request->categories ? $category_id = \App\Category::firstOrCreate(['name' => $request->categories])->id : $category_id = null;
        $post->update([
            'title'       => $request->title,
            'subtitle'    => $request->subtitle,
            'content'     => $request->content,
            'weight'      => $request->weight, 
            'preview_img' => $preview_img,
            'post_img'    => $post_img,
            'category_id' => $category_id,
            'status'      => $post->status == 'cls' ? 'cls' : $request->status,
        ]);
        if($request->tags){
            $array_tags_post = array_map('trim', explode(',', $request->tags));
            $tags = \App\Tag::get();
            $array_tags = $tags->pluck('name')->toArray();
            $diff_tags = array_diff($array_tags_post, $array_tags);
            $diff_tags_id = [];
            if($diff_tags){
                foreach ($diff_tags as $tag) {
                    $array_diff_tags[]['name'] = $tag;
                }
                $diff_tags_id = \App\Tag::insertGetId($array_diff_tags);
            }
            $exist_tags_id = $tags->whereIn('name', $array_tags_post)->pluck('id')->toArray();
            $tags_id = array_merge($diff_tags_id, $exist_tags_id);
            $post->tags()->sync($tags_id);
        }        
        return $post;
    }
}
