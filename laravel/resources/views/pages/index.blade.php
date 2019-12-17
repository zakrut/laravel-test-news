@extends('layouts.app')

@if ($id = request()->route()->parameters('id'))
    @section('title', 'Новости по категории')
@else
    @section('title', 'Главная страница')              
@endif

@section('content')

@if ($categories->isNotEmpty())
    <div class="row py-2">
        <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Категории новостей:
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item {{ !$id ? 'active' : '' }}" href="{{ route('main') }}">Все новости</a>
                    <a class="dropdown-item {{ isset($id['id']) && $id['id'] == 0 ? 'active' : '' }}" href="{{ route('category', 0) }}">Без категории</a>
                    @foreach ($categories as $category)
                        <a class="dropdown-item {{ isset($id['id']) && $id['id'] == $category->id ? 'active' : '' }}" href="{{ route('category', $category->id) }}">{{ $category->name }}</a>
                    @endforeach
            </div>
        </div>
    </div>
@endif
<div class="row py-4">
    @forelse ($posts as $post)
        <div class="mb-4 col-md-6">
            <div class="border rounded shadow-sm justify-content-between h-100">  
            <div class="p-4 h-100 d-flex flex-column">
                <div class="d-flex justify-content-between h-100">
                    <div>
                        <strong class="d-inline-block mb-2 text-primary">
                            @if ($post->category)
                                {{ $post->category->name }}
                            @else
                                Без категории
                            @endif
                        </strong>
                        <h3 class="mb-0 h4">{{ $post->title }}</h3>
                        <div class="mb-1 text-muted">{{ $post->created_at }}</div>
                    </div>
                    <a href="{{ route('show.post', $post->id) }}" class="ml-2">
                        @if ($post->preview_img)
                            <img src="/storage/posts/{{ $post->preview_img }}" alt="" class="rounded-circle" width="130">
                        @else
                            <img src="/img/default.png" alt="" class="rounded-circle" width="130">
                        @endif
                    </a>
                </div>
                <div class="mt-2">
                    <p class="card-text mb-auto">{{ $post->subtitle }}</p>
                    <a href="{{ route('show.post', $post->id) }}">Далее...</a>
                </div>
            </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center">
            Новостей нет
        </div>
    @endforelse
</div>
<div class="row">
    <div class="col">
        {{ $posts->links() }}
    </div>
</div>
@endsection