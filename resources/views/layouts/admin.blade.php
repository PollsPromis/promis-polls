@extends('app')

@section('title', 'Панель администратора')

@section('content')
    <main class="wrapper">
        <aside class="sidebar">
            <!-- Sidebar -->
            <nav class="sidebar__nav">
                <ul class="menu__list__admin">
                    <li class="menu__item__admin">
                        <a href="#" class="menu__link__admin active">
                            Новые Пользователи
                        </a>
                    </li>
                    <li class="menu__item__admin">
                        <a href="#" class="menu__link__admin">
                            Редактировать Предложения
                        </a>
                    </li>
                    <li class="menu__item__admin">
                        <a href="#" class="menu__link__admin">
                            База Данных
                        </a>
                    </li>
                    <li class="menu__item__admin">
                        <a href="#" class="menu__link__admin">
                            Статусы Предложений
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
    </main>
@endsection


