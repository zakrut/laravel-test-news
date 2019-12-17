@extends('layouts.app')

@section('title', 'Админка - Пользователи')

@section('content')
<div class="row">
    <table class="table table-hover mt-4">
        <thead>
            <tr>
                <th scope="col">Дата регистрации</th>
                <th scope="col">Имя</th>
                <th scope="col">Почта</th>
                <th scope="col">Роль</th>
                <th scope="col">Действие</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if ($user->role)
                            @switch($user->role->name)
                                @case('admin')
                                    Администратор
                                    @break
                                @case('editor')
                                    Редактор
                                    @break                                    
                            @endswitch
                        @else
                            Пользователь    
                        @endif
                    </td>
                    <td class="d-flex justify-content-end">
                        @if ($user->role)
                            @switch($user->role->name)
                                @case('editor')
                                    <form action="{{ route('admin.delete.role.user', $user->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">Сделать пользователем</button>
                                    </form>
                                    @break                                    
                            @endswitch
                        @else
                            <form action="{{ route('admin.role.user', $user->id) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">Сделать редактором</button>
                            </form> 
                        @endif
                        <form action="{{ route('admin.delete.user', $user->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm ml-3">Удалить</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="4">
                        Пользователей нет
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="row">
    <div class="text-center">
        {{ $users->links() }}
    </div>
</div>
@endsection