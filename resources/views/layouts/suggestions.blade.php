@extends('app')

@section('title', 'Предложения')

@section('content')

    <main class="main">
        <div class="main__content content">
            <div class="content__container _container">
                <div class="content__header-block header-block">
                    <h1 class="header-block__title">Предложения</h1>
                </div>

                <div class="content__body">
                    <form action="{{ route('suggestion.filter') }}" method="get" class="content__search-block search-block">
                        <span class="search-block__title">Поиск по полю:</span>
                        <select class="search-block__row" name="filter">

                            <option value="id">ID</option>
                            <option value="date">Дата создания</option>
                            <option value="author">Автор</option>
                            <option value="collaborator">Соавтор</option>
                            <option value="department">Отдел</option>
                            <option value="status">Статус</option>

                        </select>
                        <input class="search-block__row" type="text" name="search" value="{{ old('search') }}">
                        <button type="submit" class="search-block__button _button-svg">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M21 21L16.7 16.7" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                    </form>

                    <div class="content__main-table">
                        <table class="content__table table">
                            <thead class="table__thead">
                            <tr>
                                <th>ID</th>
                                <th>Дата создания</th>
                                <th>Автор</th>
                                <th>Соавтор</th>
                                <th>Отдел</th>
                                <th>Статус предложения</th>
                            </tr>
                            </thead>
                            <tbody class="table__tbody">

                            @forelse($suggestions as $suggestion)
                                <tr>
                                    <th>{{ $suggestion->id }}</th>
                                    <td>{{ $suggestion->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $suggestion->author }}</td>
                                    <td>{{ $suggestion->collaborator }}</td>
                                    <td>{{ $suggestion->department->title }}</td>
                                    <td>{{ $suggestion->status->title }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">Предложений не найдено.</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>

                    <div class="content__pagination pagination">
                        <div class="pagination__container">
                            <ul class="pagination__body">
                                <li class="pagination__button">
                                    <a href="#" class="pagination__link _button-svg">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15 18L9 12L15 6" stroke="#3d3d3d" stroke-width="2" stroke-linecap="round"
                                                  stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                </li>
                                <li class="pagination__button">
                                    <a href="#" class="pagination__link _button-svg active">1</a>
                                </li>
                                <li class="pagination__button">
                                    <a href="#" class="pagination__link _button-svg">2</a>
                                </li>
                                <li class="pagination__button">
                                    <a href="#" class="pagination__link _button-svg">3</a>
                                </li>
                                <li class="pagination__button">
                                    <a href="#" class="pagination__link _button-svg disable">...</a>
                                </li>
                                <li class="pagination__button">
                                    <a href="#" class="pagination__link _button-svg">10</a>
                                </li>
                                <li class="pagination__button">
                                    <a href="#" class="pagination__link _button-svg">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 18L15 12L9 6" stroke="#3d3d3d" stroke-width="2" stroke-linecap="round"
                                                  stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

@endsection
