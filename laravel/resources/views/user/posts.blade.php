@extends('layouts.app')

@section('title', 'Редактор новостей')

@section('content')
<div class="row py-3">
    <div class="col-12">
        <a href="{{ route('user.create.post') }}" type="button" class="btn btn-primary">Создать новость</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Дата создания</th>
                    <th>Заголовок</th>
                    <th>Категория</th>
                    <th>Статус</th>
                    <th>Вес</th>
                    <th class="text-right">Действие</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post)
                    <tr>
                        <td>{{ $post->created_at }}</td>
                        <td><a href="{{ route('show.post', $post->id) }}">{{ $post->title }}</a></td>
                        <td>
                            @if ($post->category)
                                {{ $post->category->name }}
                            @else
                                Без категории
                            @endif
                        </td>
                        <td>
                            @switch($post->status)
                                @case('mod')
                                    Не опубликован
                                    @break
                                @case('cls')
                                    Закрыто администратором
                                    @break
                                @default
                                    Опубликован
                            @endswitch
                        </td>
                        <td>{{ $post->weight }}</td>
                        <td class="d-flex justify-content-end">
                            <a href="{{ route('user.edit.post', $post->id) }}" class="btn btn-primary btn-sm">Редактировать</a>
                            <form action="{{ route('user.destroy.post', $post->id) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm ml-3">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="4">
                            У вас не новостей
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-12">
        {{ $posts->links() }}
    </div>
</div>
@endsection