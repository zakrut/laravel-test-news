@extends('layouts.app')

@section('title', 'Админка - Новости')

@section('content')
<div class="row">
    <div class="col">
        <table class="table table-hover mt-5">
            <thead>
                <tr>
                    <th>Дата создания</th>
                    <th>Заголовок</th>
                    <th>Редактор</th>
                    <th>Вес</th>
                    <th>Статус</th>
                    <th class="text-right">Действие</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post)
                    <tr>
                        <td>{{ $post->created_at }}</td>
                        <td>
                            <a href="{{ route('show.post', $post->id) }}">{{ $post->title }}</a>
                        </td>
                        <td>{{ $post->user->name }}</td>
                        <td>{{ $post->weight }}</td>
                        <td>
                            <form action="{{ route('admin.status.post', $post->id) }}" method="post">
                                @csrf
                                <select name="status">
                                    <option value="mod" {{ $post->status == 'mod' ? 'selected' : '' }}>Не опубликован</option>
                                    <option value="pub" {{ $post->status == 'pub' ? 'selected' : '' }}>Опубликован</option>
                                    <option value="cls" {{ $post->status == 'cls' ? 'selected' : '' }}>Закрыт</option>
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm">Сменить статус</button>
                            </form> 
                        </td>
                        <td  class="d-flex justify-content-end">
                            <form action="{{ route('admin.delete.post', $post->id) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm ml-3">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="4">
                            Новостей нет
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="text-center">
        {{ $posts->links() }}
    </div>
</div>
@endsection