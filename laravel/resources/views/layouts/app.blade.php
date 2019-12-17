<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Новости')</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.css" rel="stylesheet">

</head>
<body>
    <header>
        <nav class="navbar navbar-dark sticky-top bg-dark">
            <div class="container">
                <a class="navbar-brand" href="/">Новости</a>
                <div class="d-flex align-items-center">
                    @guest
                        <button type="button" class="btn btn-primary mr-3" data-toggle="modal" data-target="#loginModal">Войти</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#registerModal">Регистрация</button>
                    @else
                        <div class="text-white mr-3">
                            {{ auth()->user()->name }}
                        </div>
                        <div>
                            @if ($user_role = auth()->user()->nameRole())
                                @if ($user_role == 'editor' || $user_role == 'admin')
                                    <a href="{{ route('user.index.posts') }}" class="btn btn-outline-primary">Управление новостями</a>
                                    @if ($user_role == 'admin')
                                        <a href="{{ route('admin.index') }}" class="btn btn-outline-primary ml-3">Админка</a>
                                    @endif
                                @endif
                            @endif
                            <button type="submit" class="btn btn-primary ml-3" form="logout-form">Выход</button>
                            <form id="logout-form" class="d-none" action="{{ route('exit') }}" method="POST">{{ csrf_field() }}</form>
                        </div>
                    @endguest
                </div>
            </div>
        </nav>
    </header>
    @if (session('message'))
        <div class="w-100" id="message-alerts">
            @switch(session('message'))
                @case('error')
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Произошла ошибка!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @break
                @case('access_role')
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>У вас нет прав на доступ!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @break
                @case('success_auth')
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Авторизация прошла успешно!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @break
                @case('exit_auth')
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Вы успешно вышли!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @break
                @default
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Изменения сохранены!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
            @endswitch
        </div>
    @endif
    <main>
        <div class="container">
            @yield('content')
        </div>
    </main>
    <footer>
        @guest
            <!-- Modals -->
            <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title">Войти</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('login') }}" method="POST" id="form-login">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email">
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Пароль">
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Запомнить</label>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" form="form-login">Войти</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
                </div>
            </div>
            <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Регистрация</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('register') }}" method="POST" id="form-register">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col">
                                    <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" placeholder="Имя" value="{{ old('name') }}">
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </div>
                                </div>
                                <div class="form-group col">
                                    <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="Email" value="{{ old('email') }}">
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Пароль">
                                    <div class="invalid-feedback">
                                        {{ $errors->first('password') }}
                                    </div>
                                </div>
                                <div class="form-group col">
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="Подтверждение пароля">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" form="form-register">Регистрация</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
                </div>
            </div>
        @endguest    
    </footer>
    
    <!-- Scripts --> -
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
    
</body>
</html>