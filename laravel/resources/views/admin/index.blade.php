@extends('layouts.app')

@section('title', 'Админка')

@section('content')
<div class="row">
    <div class="col-12 mt-4">
        <a href="{{ route('admin.users') }}" type="button" class="btn btn-primary">Пользователи <span class="badge badge-light">{{ $count['users'] }}</span></a>
        <a href="{{ route('admin.posts') }}" type="button" class="btn btn-primary">Новости <span class="badge badge-light">{{ $count['posts'] }}</span></a>
        <a href="{{ route('admin.categories') }}" type="button" class="btn btn-primary">Категории <span class="badge badge-light">{{ $count['categories'] }}</span></a>
        <a href="{{ route('admin.tags') }}" type="button" class="btn btn-primary">Теги <span class="badge badge-light">{{ $count['tags'] }}</span></a>
    </div>
</div>
@endsection