@extends('app')

@section('title', 'Личный кабинет')

@section('content')

    <main class="main">
        <div class="main__content content">
            <div class="content__container _container">
                <div class="content__header-block header-block">
                    <h1 class="header-block__title">Предложения</h1>
                </div>

                <div class="content__body">
                    <table class="content__main-table main-table">
                        <thead class="main-table__thead">
                        <tr>
                            <th>Номер предложения</th>
                            <th>Автор</th>
                            <th>Соавтор</th>
                            <th>Подразделение</th>
                            <th>Статус</th>
                            <th>Дата</th>
                        </tr>
                        </thead>
                        <tbody class="main-table__tbody">
                        @forelse($suggestions as $suggestion)
                            <tr>
                                <td>{{ $suggestion->id }}</td>
                                <td>{{ $suggestion->author }}</td>
                                <td>{{ $suggestion->collaborator }}</td>
                                <td>{{ $suggestion->department->title }}</td>
                                <td>{{ $suggestion->status->title }}</td>
                                <td>{{ $suggestion->created_at->format('d-m-Y') }}</td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">Предложений не найдено.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

@endsection
