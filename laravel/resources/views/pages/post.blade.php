@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="row py-3">
    <div class="col-md-12">
        <div class="d-flex align-items-center mb-2">
            @if ($post->preview_img)
                <img src="/storage/posts/{{ $post->preview_img }}" alt="" class="rounded-circle mr-4" width="70">
            @endif
            <h1 class="mb-0">{{ $post->title }}</h1>
        </div>
        @if ($post->post_img)
            <p><img src="/storage/posts/{{ $post->post_img }}" alt="" class="mw-100"></p>
        @endif
        <p>{{ $post->content }}</p>
        <p class="text-muted">{{ $post->created_at }}</p>
    </div>
</div>
@endsection