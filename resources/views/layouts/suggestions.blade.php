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
                        <select class="search-block__row" required name="field">

                            @foreach($filters as $key => $name)
                                <option value="{{ $key }}" {{ old('field', request()->input('field')) === $key ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach

                        </select>
                        <input class="search-block__row" required type="text" name="search" value="{{ old('search', request()->input('search')) }}">
                        <button type="submit" class="search-block__button _button-svg" title="Поиск">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M21 21L16.7 16.7" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>

                        <a href="{{ route('suggestion.show') }}" class="search-block__button _button-svg" title="Очистить">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 6L6 18" stroke="#3d3d3d" stroke-width="2" stroke-linecap="round"
                                      stroke-linejoin="round" />
                                <path d="M6 6L18 18" stroke="#3d3d3d" stroke-width="2" stroke-linecap="round"
                                      stroke-linejoin="round" />
                            </svg>
                        </a>
                    </form>

                    <div class="content__main-table">
                        <table class="content__table table">
                            <thead class="table__thead">
                            <tr>

                                @foreach($filters as $name)
                                    <th>{{ $name }}</th>
                                @endforeach

                            </tr>
                            </thead>
                            <tbody class="table__tbody">

                            @forelse($suggestions as $suggestion)
                                <tr>
                                    <th>{{ $suggestion->id }}</th>
                                    <td>{{ $suggestion->created_at->format('Y-m-d') }}</td>
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

                    @if($suggestions->hasPages() && $suggestions->lastPage() > 1)
                    <div class="content__pagination pagination">
                        <div class="pagination__container">
                            <ul class="pagination__body">
                                @if(!$suggestions->onFirstPage())
                                    <li class="pagination__button">
                                        <a href="{{ $suggestions->appends($_GET)->previousPageUrl() }}" class="pagination__link _button-svg">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15 18L9 12L15 6" stroke="#3d3d3d" stroke-width="2" stroke-linecap="round"
                                                      stroke-linejoin="round" />
                                            </svg>
                                        </a>
                                    </li>
                                @endif

                                <li class="pagination__button">
                                    <a href="{{ $suggestions->appends($_GET)->url(1) }}" class="pagination__link _button-svg {{ $suggestions->currentPage() === 1 ? 'active' : '' }}">1</a>
                                </li>

                                @if($suggestions->currentPage() > 3)
                                    <li class="pagination__button">
                                        <div class="pagination__link _button-svg disable">...</div>
                                    </li>
                                @endif

                                @for($i = 2; $i <= $suggestions->lastPage() - 1; $i++)
                                    @if(($suggestions->currentPage() - $i < 3 && $i - $suggestions->currentPage() < 3))
                                        <li class="pagination__button">
                                            <a href="{{ $suggestions->appends($_GET)->url($i) }}" class="pagination__link _button-svg {{ $suggestions->currentPage() === $i ? 'active' : '' }}">{{ $i }}</a>
                                        </li>
                                    @endif
                                @endfor

                                @if($suggestions->lastPage() - $suggestions->currentPage() > 2 )
                                    <li class="pagination__button">
                                        <div class="pagination__link _button-svg disable">...</div>
                                    </li>
                                @endif

                                <li class="pagination__button">
                                    <a href="{{ $suggestions->appends($_GET)->url($suggestions->lastPage()) }}" class="pagination__link _button-svg {{ $suggestions->currentPage() === $suggestions->lastPage() ? 'active' : '' }}">{{ $suggestions->lastPage() }}</a>
                                </li>

                                @if($suggestions->currentPage() !== $suggestions->lastPage())
                                    <li class="pagination__button">
                                        <a href="{{ $suggestions->appends($_GET)->nextPageUrl() }}" class="pagination__link _button-svg">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9 18L15 12L9 6" stroke="#3d3d3d" stroke-width="2" stroke-linecap="round"
                                                      stroke-linejoin="round" />
                                            </svg>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </main>

@endsection
