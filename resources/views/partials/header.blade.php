@if (!empty($route) && $route == 'main')
    <header class="site__header">
        <div class="site__header-layout">
            <h1 class="logo anchor" data-href="#up">
                <img src="/assets/img/logo.png" width="90" height="26" alt="getLoc">
            </h1>
            <div class="site__header-inner">
                <nav class="header__menu">
                    <a href="#">{{trans('phrases.capabilities')}}</a>
                    <a href="#">Цены</a>
                    <a href="#">О проекте</a>
                </nav>
                <a class="btn btn_header btn_header-login popup__open" data-popup="login">{{trans('phrases.login')}}</a>
                <div class="language">
                    <button class="language__btn">RU</button>
                    <ul class="language__list">
                        <li><a href="#">Русский</a></li>
                        <li><a class="active" href="#">English</a></li>
                        <li><a href="#">Deutsch</a></li>
                        <li><a href="#">Español</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
@elseif (!empty($route) && $route == 'main.feature')
    <header class="site__header">
        <div class="site__header-layout">
            <h1 class="logo anchor" data-href="#up">
                <img src="/assets/img/logo.png" width="90" height="26" alt="getLoc">
            </h1>
            <div class="site__header-inner">
                <nav class="header__menu">
                    <a class="active" href="#">{{trans('phrases.capabilities')}}</a>
                    <a href="#">Цены</a>
                    <a href="#">О проекте</a>
                </nav>
                <a class="btn btn_header btn_header-login popup__open" data-popup="login">{{trans('phrases.login')}}</a>
                <div class="language">
                    <button class="language__btn">RU</button>
                    <ul class="language__list">
                        <li><a href="#">Русский</a></li>
                        <li><a class="active" href="#">English</a></li>
                        <li><a href="#">Deutsch</a></li>
                        <li><a href="#">Español</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
@else
    <header class="site__header">
        <div class="site__header-layout">
            <h1 class="logo anchor" data-href="#up">
                <img src="/assets/img/logo.png" width="90" height="26" alt="getLoc">
            </h1>
            <div class="site__header-inner">
                <nav class="header__menu">
                    <a class="active" href="#">{{trans('phrases.capabilities')}}</a>
                    <a href="#">Цены</a>
                    <a href="#">О проекте</a>
                </nav>
                <a class="btn btn_header btn_header-login popup__open" data-popup="order">{{trans('phrases.get_demo')}}</a>
                <div class="language">
                    <button class="language__btn">RU</button>
                    <ul class="language__list">
                        <li><a href="#">Русский</a></li>
                        <li><a class="active" href="#">English</a></li>
                        <li><a href="#">Deutsch</a></li>
                        <li><a href="#">Español</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
@endif
