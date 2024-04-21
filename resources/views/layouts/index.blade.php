@extends('app')

@section('title', 'Предложение по улучшению')

@section('content')

    <main class="main">
        <div class="main__content content">
            <div class="content__container _container">
                <div class="content__header-block header-block">
                    <h1 class="header-block__title">Предложение по улучшению</h1>
                </div>
                <form method="post" class="content__main-form main-form" action="{{ route('submit.suggestion') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="main-form__row row">
                        <div class="row__title">
                            <h3 class="row__text required">Автор (ФИО)</h3>
                        </div>
                        <input class="row__input" name="author" required type="text">
                    </div>

                    <div class="main-form__row row">
                        <div class="row__title">
                            <h3 class="row__text">Соавтор(-ы) (ФИО)</h3>
                        </div>
                        <input class="row__input" name="collaborator" type="text">
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
                            <input class="row__input" name="email" type="text">
                        </div>

                        <div class="main-form__row row">
                            <div class="row__title">
                                <h3 class="row__text">Телефон</h3>
                            </div>
                            <input class="row__input" name="phone" type="text">
                        </div>
                    </div>

                    <div class="main-form__row row">
                        <div class="row__title">
                            <h3 class="row__text required">Подразделение</h3>
                        </div>
                        <input class="row__input" name="department" required type="text">
                    </div>

                    <div class="main-form__row row">
                        <div class="row__title">
                            <h3 class="row__text required">Описание проблемы</h3>
                        </div>
                        <textarea class="row__textarea" name="description" required type="text" rows="10"></textarea>
                    </div>

                    <div class="main-form__row row">
                        <div class="row__title">
                            <h3 class="row__text">Прикрепите фото проблемы (желательно, но не обязательно)</h3>
                        </div>
                        <div class="row__action">
                            <button class="row__button-load _button file-chooser" name="photo_problem" type="button">Загрузить</button>
                            <span class="row__span">До 5 файлов, допустимый размер одного файла — 20 МБ.</span>
                        </div>
                        <div class="row__file-list"></div>
                    </div>

                    <div class="main-form__row row">
                        <div class="row__title">
                            <h3 class="row__text">Прикрепите фото решенной проблемы (желательно, но не обязательно)</h3>
                        </div>
                        <div class="row__action">
                            <button class="row__button-load _button file-chooser" name="photo_solution" type="button">Загрузить</button>
                            <span class="row__span">До 5 файлов, допустимый размер одного файла — 20 МБ.</span>
                        </div>
                        <div class="row__file-list"></div>
                    </div>

                    <div class="main-form__row row">
                        <div class="row__title">
                            <h3 class="row__text">Дата</h3>
                        </div>
                        <input type="date" class="row__input input-date" name="date">
                    </div>
                    <div class="main-form__row row">
                        <button class="row__button-submit _button" type="submit">Отправить</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

@endsection
