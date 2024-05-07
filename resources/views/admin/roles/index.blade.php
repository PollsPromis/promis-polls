@extends('app')

@section('title', 'Роли')

@section('content')

    <main class="main">
        <div class="main__content content">
            <div class="content__container _container">
                <div class="content__header-block header-block">
                    <h1 class="header-block__title">Роли</h1>
                </div>
                @can(\App\Enums\Permissions::CreateRoles->getValue())
                    <a href="{{ route('roles.create') }}" class="btn btn-success mb-4">
                        Создать роль
                    </a>
                @endcan

                @if(session('success'))
                    <div class="d-block w-100">
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif
                <div class="content__body">
                    <div class="content__main-table">
                        <table class="content__table table">
                            <thead class="table__thead">
                                <tr>
                                    <th>#</th>
                                    <th>Идентификатор</th>
                                    <th>Наименование</th>
                                    <th><i class="fas fa-edit"></i></th>
                                    <th><i class="fas fa-trash-alt"></i></th>
                                </tr>
                                </thead>
                            <tbody class="table__tbody">

                            @forelse($roles as $role)
                                <tr>
                                    <th>{{ $role->id }}</th>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->title }}</td>
                                    <td>
                                        @can(\App\Enums\Permissions::EditRoles->value)
                                            <a href="{{route('roles.edit', $role->id)}}">
                                                Редактировать
                                            </a>
                                        @endcan
                                    </td>
                                    <td>
                                        @can(\App\Enums\Permissions::DeleteRoles->value)
                                            <form action="{{ route('roles.destroy', $role->id) }}" method="post" onsubmit="return confirm('Удалить роль?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="m-0 p-0 border-0 bg-transparent">
                                                    Удалить
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">Пользователи не найдены.</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </main>

@endsection
