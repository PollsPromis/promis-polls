@extends('app')

@section('title', 'Предложение по улучшению')

@section('content')

    <main class="main">
        <div class="main__content content">
            <div class="content__container _container">
                <div class="content__header-block header-block">
                    <h1 class="header-block__title">Предложение по улучшению</h1>
                </div>
                <form class="content__main-form main-form" method="post" action="{{ route('suggestion.store') }}" onsubmit="clearStorage()" enctype="multipart/form-data">
                    @csrf
                    <div class="main-form__wrapper">
                        <div class="main-form__row row">
                            <div class="row__title">
                                <h3 class="row__text required">Автор (ФИО)</h3>
                            </div>
                            <input class="row__input" required type="text" name="author">
                        </div>

                        <div class="main-form__row row">
                            <div class="row__title">
                                <h3 class="row__text">Соавтор(-ы) (ФИО)</h3>
                            </div>
                            <input class="row__input" type="text" name="collaborator">
                        </div>

                        <label class="main-form__row row _form-check" for="toggle-input-fields">
                            <input class="row__check-input" type="checkbox" id="toggle-input-fields">
                            <span class="row__check-span">Поставьте галочку, если Вам необходима обратная связь</span>
                        </label>

                        <div class="main-form__input-fields" id="input-fields" style="display: none;">
                            <div class="main-form__row row">
                                <div class="row__title">
                                    <h3 class="row__text">Почта</h3>
                                </div>
                                <input class="row__input" type="text" name="email">
                            </div>

                            <div class="main-form__row row">
                                <div class="row__title">
                                    <h3 class="row__text">Телефон</h3>
                                </div>
                                <input class="row__input" type="text" name="phone_number">
                            </div>
                        </div>

                        <div class="main-form__row row">
                            <div class="row__title">
                                <h3 class="row__text required">Подразделение</h3>
                            </div>
                            <select class="row__input" required type="text" name="department">

                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->title }}</option>
                            @endforeach

                            </select>
                        </div>

                        <div class="main-form__row row">
                            <div class="row__title">
                                <h3 class="row__text required">Описание проблемы</h3>
                            </div>
                            <textarea class="row__textarea" required type="text" rows="10" name="description"></textarea>
                        </div>

                        <div class="main-form__row row">
                            <div class="row__title">
                                <h3 class="row__text">Прикрепите фото проблемы (желательно, но не обязательно)</h3>
                            </div>
                            <div class="row__action">
                                <button class="row__button-load _button file-chooser-problem" type="button">Загрузить</button>
                                <span class="row__span">До 5 файлов, допустимый размер одного файла — 20 МБ.</span>
                            </div>
                            <div class="input-list-problem"></div>
                            <div class="row__file-list filename-list-problem"></div>
                        </div>

                        <div class="main-form__row row">
                            <div class="row__title">
                                <h3 class="row__text">Прикрепите фото решенной проблемы (желательно, но не обязательно)</h3>
                            </div>
                            <div class="row__action">
                                <button class="row__button-load _button file-chooser-solution" type="button">Загрузить</button>
                                <span class="row__span">До 5 файлов, допустимый размер одного файла — 20 МБ.</span>
                            </div>
                            <div class="input-list-solution"></div>
                            <div class="row__file-list filename-list-solution"></div>
                        </div>

                        <div class="main-form__row row">
                            <div class="row__title">
                                <h3 class="row__text">Дата</h3>
                            </div>
                            <input type="date" class="row__input input-date" name="date" value="{{ now()->format('Y-m-d') }}">
                        </div>

                        <div class="main-form__row row">
                            <button class="row__button-submit _button" type="submit">Отправить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

@endsection
