<header class="header">
    <div class="header__main-menu main-menu">
        <div class="main-menu__container">
            <div class="main-menu__logo logo">
                <a href="{{ route('app') }}" class="logo__link">
                    <img class="logo__image" src="{{ asset('assets/images/logo.png') }}" alt="logo">
                </a>
            </div>
            <nav class="main-menu__menu menu">
                <ul class="menu__list">
                    <li class="menu__item">
                        <a href="{{ route('suggestions.show') }}">
                            <div class="menu__icon icon">
                                <div class="icon__icon-svg search-svg _svg">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path
                                            d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="menu__item">
                        <div class="menu__icon icon">
                            <div class="icon__icon-svg profile-svg _svg">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path
                                        d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/>
                                </svg>
                            </div>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
