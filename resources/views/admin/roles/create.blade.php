@extends('app')

@section('title', 'Роль')

@section('content')

    <main class="main">
        <div class="main__content content">
            <div class="content__container _container">
                <h1 class="mb-4">Создание роли</h1>
                @if($errors->any())
                    <div class="d-block w-100">
                        @foreach($errors->all() as $error)
                            <p class="alert alert-danger">{{$error}}</p>
                        @endforeach
                    </div>
                @endif
                <form method="post" action="{{ route('roles.store') }}">
                    @csrf
                    @method('POST')
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="name" placeholder="Идентификатор" required maxlength="255" value="{{ old('name')}}">
                    </div>

                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="title" placeholder="Наименование" required maxlength="255" value="{{ old('title')}}">
                    </div>

                    @can(\App\Enums\Permissions::AssignPermissions->getValue())
                        @include('admin.permissions')
                    @endcan
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

@endsection
