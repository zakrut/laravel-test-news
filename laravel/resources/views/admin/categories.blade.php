@extends('layouts.app')

@section('title', 'Админка - Категории')

@section('content')
<div class="row">
    <table class="table table-hover mt-5">
        <thead>
            <tr>
                <th scope="col">Наименование</th>
                <th scope="col">Количество новостей</th>
                <th scope="col">Действие</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td></td>
                    <td>
                        <form action="{{ route('admin.delete.category', $category->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm ml-3">Удалить</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="4">
                        Категорий нет
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="row">
    <div class="text-center">
        {{ $categories->links() }}
    </div>
</div>
@endsection