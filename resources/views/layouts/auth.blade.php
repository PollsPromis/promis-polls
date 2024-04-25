@extends('app')

@section('title', 'Форма авторизации')

@section('content')

    <main class="main">
        <div class="main__content content">
            <div class="content__container _container">
                <div class="content__header-block header-block">
                    <h1 class="header-block__title">Форма авторизации</h1>
                </div>

                <div class="content__body">
                    <form method="POST" action="{{ route('auth.show') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        </div>

                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <input id="password" type="password" name="password" required autocomplete="current-password">
                        </div>

                        <div class="form-group">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">Запомнить меня</label>
                        </div>

                        <button type="submit">Войти</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

@endsection
