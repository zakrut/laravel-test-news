@extends('layouts.app')

@section('title', 'Редактировать новость')

@section('content')
<div class="row py-3">
    <div class="col-12">
        <form action="{{ route('user.update.post', $post->id) }}" method="POST" id="form-post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-row mb-3">
                <div class="col">
                    <label for="preview_img">Превью (< 2mb)</label>
                    <div class="img-form mb-2">
                        @if ($post->preview_img)
                            <img src="/storage/posts/{{ $post->preview_img }}" alt="" class="mw-100">
                        @else
                            Превью нет
                        @endif
                    </div>
                    <input id="preview_img" type="file" name="preview_img" class="form-control-file{{ $errors->has('preview_img') ? ' is-invalid' : '' }}" accept="image/*" >
                    <div class="invalid-feedback">
                        {{ $errors->first('preview_img') }}
                    </div>
                </div>
                <div class="col">
                    <label>Картинка новости (< 2mb)</label>
                    <div  class="img-form overflow-auto mb-2">
                        @if ($post->post_img)
                            <img src="/storage/posts/{{ $post->post_img }}" alt="" class="mw-100">
                        @else
                            Картинки новости нет
                        @endif
                    </div>
                    <input type="file" name="post_img" class="form-control-file{{ $errors->has('post_img') ? ' is-invalid' : '' }}" accept="image/*">
                    <div class="invalid-feedback">
                        {{ $errors->first('post_img') }}
                    </div>
                </div>
                <div class="col">
                    <label>Вес новости (1-10)</label>
                    <input type="number" class="form-control{{ $errors->has('weight') ? ' is-invalid' : '' }}" name="weight" min="1" max="10" value="{{ old('weight') ? old('weight') : $post->weight }}">
                    <div class="invalid-feedback">
                        {{ $errors->first('weight') }}
                    </div>
                </div>
            </div>            
            <div class="form-group">
                <label>Заголовок</label>
                <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') ? old('title') : $post->title }}" required>
                <div class="invalid-feedback">
                    {{ $errors->first('title') }}
                </div>
            </div>
            <div class="form-group">
                <label>Подзаголовок</label>
                <textarea class="w-100 form-control{{ $errors->has('subtitle') ? ' is-invalid' : '' }}" name="subtitle" rows="2" required>{{ old('subtitle') ? old('subtitle') : $post->subtitle }}</textarea>
                <div class="invalid-feedback">
                    {{ $errors->first('subtitle') }}
                </div>
            </div>
            <div class="form-group">
                <label>Текст новости</label>
                <textarea class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" name="content" rows="6" cols="4" required>{{ old('content') ? old('content') : $post->content }}</textarea>
                <div class="invalid-feedback">
                    {{ $errors->first('content') }}
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label>Статус</label>
                    @if ($post->status == 'cls')
                        Закрыта администратором
                    @else
                        <select class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" name="status" required>
                            <option value="mod" {{ $post->status == 'mod' ? 'selected' : '' }}>Не опубликовывать</option>
                            <option value="pub" {{ $post->status == 'pub' ? 'selected' : '' }}>Опубликовать</option>
                        </select>
                        <div class="invalid-feedback">
                            {{ $errors->first('status') }}
                        </div>
                    @endif
                </div>
                <div class="col">
                    <label>Рубрика</label>
                    <input list="categories-list" name="categories" class="form-control" value="{{ old('categories') ? old('categories') : $post->category ? $post->category->name : ''}}"/>
                    <datalist id="categories-list">
                        @foreach ($categories as $category)
                            <option value="{{ $category->name }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="col">
                    <label class="d-block">Теги</label>
                    <input type="text" data-role="tagsinput" class="form-control d-none" name="tags" value="{{ old('tags') ? old('tags') : $post_tags ? $post_tags : '' }}" />
                    @if ($tags->isNotEmpty())
                        <div id="tags" class="mt-3">
                            Существующие теги: 
                            @foreach ($tags as $tag)
                                <span class="tag-name">{{ $tag->name }}</span>,
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row py-3">
    <div class="col-12">
        <button type="submit" form="form-post" type="button" class="btn btn-primary">Обновить новость</button>
    </div>
</div>
@endsection