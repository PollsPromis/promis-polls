@extends('app')

@section('title', 'Создание пользователя')

@section('content')

    <main class="main">
        <div class="main__content content">
            <div class="content__container _container">
                <h1 class="mb-4">Создание пользователя</h1>
                @if($errors->any())
                    <div class="d-block w-100">
                        @foreach($errors->all() as $error)
                            <p class="alert alert-danger">{{$error}}</p>
                        @endforeach
                    </div>
                @endif
                <form method="post" action="{{ route('users.store') }}">
                    @csrf
                    @method('POST')
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="first_name" placeholder="Имя" required maxlength="255" value="{{ old('first_name')}}">
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="second_name" placeholder="Отчество" required maxlength="255" value="{{ old('second_name')}}">
                    </div>
                    <div class="form-group mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Адрес почты" required maxlength="255" value="{{ old('email')}}">
                    </div>

                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="password" maxlength="255" placeholder="Пароль" value="">
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="password_confirmation" maxlength="255" placeholder="Пароль еще раз" value="">
                    </div>

                    @can(\App\Enums\Permissions::AssignRoles->getValue())
                        @include('admin.roles')
                    @endcan

                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

@endsection
