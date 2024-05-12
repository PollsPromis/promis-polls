@extends('app')

@section('title', 'Пользователи')

@section('content')

    <main class="main">
        <div class="main__content content">
            <div class="content__container _container">
                <div class="content__header-block header-block">
                    <h1 class="header-block__title">Пользователи</h1>
                    @can(\App\Enums\Permissions::CreateUsers->getValue())
                        <a href="{{ route('users.create') }}" class="btn btn-success mb-4">
                            Создать пользователя
                        </a>
                    @endcan
                </div>

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
                                <th>ID</th>
                                <th>Имя</th>
                            </tr>
                            </thead>
                            <tbody class="table__tbody">

                            @forelse($users as $user)
                                <tr>
                                    <th>{{ $user->id }}</th>
                                    <td>{{ $user->first_name }}</td>
                                    <td>
                                        @can(\App\Enums\Permissions::EditUsers->value)
                                            <a href="{{route('users.edit', $user->id)}}">
                                                Редактировать
                                            </a>
                                        @endcan
                                    </td>
                                    <td>
                                        @can(\App\Enums\Permissions::DeleteUsers->value)
                                            <form action="{{ route('users.destroy', $user->id) }}" method="post" onsubmit="return confirm('Удалить пользователя?')">
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
