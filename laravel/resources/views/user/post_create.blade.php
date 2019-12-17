@extends('layouts.app')

@section('title', 'Создать новость')

@section('content')
<div class="row py-3">
    <div class="col-12">
        <form action="{{ route('user.store.post') }}" method="POST" id="form-post" enctype="multipart/form-data">
            @csrf
            <div class="form-row mb-3">
                <div class="col">
                    <label for="preview_img">Превью</label>
                    <input id="preview_img" type="file" name="preview_img" class="form-control-file{{ $errors->has('preview_img') ? ' is-invalid' : '' }}" accept="image/*" >
                    <div class="invalid-feedback">
                        {{ $errors->first('preview_img') }}
                    </div>
                </div>
                <div class="col">
                    <label>Картинка новости (< 2mb)</label>
                    <input type="file" name="post_img" class="form-control-file{{ $errors->has('post_img') ? ' is-invalid' : '' }}" accept="image/*">
                    <div class="invalid-feedback">
                        {{ $errors->first('post_img') }}
                    </div>
                </div>
                <div class="col">
                    <label>Вес новости (1-10)</label>
                    <input type="number" class="form-control{{ $errors->has('weight') ? ' is-invalid' : '' }}" name="weight" min="1" max="10" value="1">
                    <div class="invalid-feedback">
                        {{ $errors->first('weight') }}
                    </div>
                </div>
            </div>            
            <div class="form-group">
                <label>Заголовок</label>
                <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" required>
                <div class="invalid-feedback">
                    {{ $errors->first('title') }}
                </div>
            </div>
            <div class="form-group">
                <label>Подзаголовок</label>
                <textarea class="w-100 form-control{{ $errors->has('subtitle') ? ' is-invalid' : '' }}" name="subtitle" rows="2" required>{{ old('subtitle') }}</textarea>
                <div class="invalid-feedback">
                    {{ $errors->first('subtitle') }}
                </div>
            </div>
            <div class="form-group">
                <label>Текст новости</label>
                <textarea class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" name="content" rows="6" cols="4" required>{{ old('content') }}</textarea>
                <div class="invalid-feedback">
                    {{ $errors->first('content') }}
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label>Статус</label>
                    <select class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" name="status" required>
                        <option value="mod" selected>Не опубликовывать</option>
                        <option value="pub">Опубликовать</option>
                    </select>
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                </div>
                <div class="col">
                    <label>Рубрика</label>
                    <input list="categories-list" name="categories" class="form-control" value="{{ old('categories') }}"/>
                    <datalist id="categories-list">
                        @foreach ($categories as $category)
                            <option value="{{ $category->name }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="col">
                    <label class="d-block">Теги</label>
                    <input type="text" data-role="tagsinput" class="form-control d-none" name="tags" value="{{ old('tags') }}" />
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
        <button type="submit" form="form-post" type="button" class="btn btn-primary">Сохранить новость</button>
    </div>
</div>
@endsection