@extends('app')

@section('title', 'Роль')

@section('content')

    <main class="main">
        <div class="main__content content">
            <div class="content__container _container">
                <h1 class="mb-4">Редактирование роли</h1>
                @if($errors->any())
                    <div class="d-block w-100">
                        @foreach($errors->all() as $error)
                            <p class="alert alert-danger">{{$error}}</p>
                        @endforeach
                    </div>
                @endif

                <form method="post" action="{{ route('roles.update', $role->id) }}" class="w-100">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="name" placeholder="Название"
                               required maxlength="255" value="{{ old('name') ?? $role->name }}">
                    </div>

                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="title" placeholder="Наименование" required maxlength="255" value="{{ old('title') ?? $role->title}}">
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
