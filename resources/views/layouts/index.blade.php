<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=992">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="address=no">
    <title>@yield('title')</title>
    <link href='https://fonts.googleapis.com/css?family=Fira+Sans:400,300,500,700&subset=cyrillic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/assets/css/swiper.min.css" />
    <link rel="stylesheet" href="/assets/css/select.css" />
    <link rel="stylesheet" href="/assets/css/main.css" />
</head>
<body>
<!-- site -->
<div class="site" id="up">
    @if (!empty($route) && $route == 'main')
        <header class="site__header">

            <!-- site__header-layout -->
            <div class="site__header-layout">

                <!-- logo -->
                <h1 class="logo anchor" data-href="#up">
                    <img src="/assets/img/logo.png" alt="GETLOC">
                </h1>
                <!-- /logo -->

                <!-- header__menu -->
                <nav class="header__menu">
                    <a href="{{route('main.futures')}}">Возможности</a>
                    {{--
                    <a href="#">Цены</a>
                    <a href="#">О проекте</a>
                    --}}
                </nav>
                <!-- /header__menu -->

                <!-- btn -->
                <a class="btn btn_header anchor" data-href="#discount">Запросить демо</a>
                <!-- /btn -->
                {{--
                <!-- language -->
                <div class="language">

                    <!-- language__btn -->
                    <button class="language__btn">RU</button>
                    <!-- /language__btn -->

                    <!-- language__list -->
                    <ul class="language__list">
                        <li><a href="#">Русский</a></li>
                        <li><a class="active" href="#">English</a></li>
                        <li><a href="#">Deutsch</a></li>
                        <li><a href="#">Español</a></li>
                    </ul>
                    <!-- /language__list -->

                </div>
                <!-- /language -->
                --}}
            </div>
            <!-- /site__header-layout -->

        </header>
    @else
        <header class="site__header">
            <!-- site__header-layout -->
            <div class="site__header-layout">
                <!-- logo -->
                <a href="{{route('main')}}" class="">
                    <img src="/assets/img/logo.png" alt="GETLOC" style="margin-top: 5px;">
                </a>
                <!-- /logo -->
                <!-- header__menu -->
                <nav class="header__menu">
                    <a href="{{route('main.futures')}}" class="active">Возможности</a>
                </nav>
                <!-- /header__menu -->
                <!-- btn -->
                <a class="btn btn_header popup__open" data-popup="order">Запросить демо</a>
                <!-- /btn -->
            </div>
            <!-- /site__header-layout -->
        </header>
    @endif
    <!-- /site__header -->

    <!-- /site__header -->
    @yield('content')
    <!-- /site__footer -->
    <footer class="site__footer">
        <!-- /site__footer-layout -->
        <div class="site__footer-layout">
            <!-- footer__logo -->
            <div class="footer__logo">
                <img src="/assets/img/logo.png" alt="GETLOC">
            </div>
            <!-- /footer__logo -->
            <!--
            <div class="footer-menu">
                <dl>
                    <dt>Как это работает?</dt>
                    <dd>
                        <a href="#"><span>Наша платформа</span></a>
                        <a href="#"><span>Управление переводом</span></a>
                        <a href="#"><span>Заказ перевода</span></a>
                        <a href="#"><span>Интеграция</span></a>
                        <a href="#"><span>Планы развити</span></a>
                    </dd>
                </dl>
                <dl>
                    <dt>О нас</dt>
                    <dd>
                        <a href="#"><span>Команда проекта</span></a>
                        <a href="#"><span>Наши клиенты</span></a>
                        <a href="#"><span>Новости</span></a>
                    </dd>
                </dl>
            </div>
            <div class="social">
                <a href="#" class="social-vk"></a>
                <a href="#" class="social-fb"></a>
                <a href="#" class="social-ok"></a>
            </div>
            -->
        </div>
        <!-- /site__footer-layout -->
    </footer>
    <!-- /site__footer -->
</div>
<!-- /site -->

<!-- popup -->
<div class="popup">
    <!-- popup__wrap -->
    <div class="popup__wrap">
        <!-- popup__content -->
        <div class="popup__content popup__order">
            <!-- order-popup -->
            <div class="order-popup">
                <!-- order-popup__content -->
                <div class="order-popup__content">

                    <!-- discount__layout -->
                    <div class="discount__layout">

                        <!-- site__title -->
                        <h2 class="site__title">Добавьте сайт</h2>
                        <!-- /site__title -->

                        <!-- popup__introduction -->
                        <div class="popup__introduction">
                            <p>Заполните форму и когда проект запуститься, у вас будет возможность пользоваться услугами сервиса со скидкой.</p>
                        </div>
                        <!-- /popup__introduction -->

                        <!-- discount__form -->
                        <div class="discount__form popup_form">
                            {!! Form::open(['route' => 'main.get-demo']) !!}

                                <fieldset>
                                    <label for="popup__email">Ваша эл. почта *</label>
                                    <input type="email" id="popup__email"  placeholder="yourmail@gmai" required/>
                                </fieldset>

                                <fieldset>
                                    <label for="popup__name">Имя, фамилия</label>
                                    <input type="text" id="popup__name"/>
                                </fieldset>

                                <fieldset>
                                    <label for="popup__address">Адрес вашего сайта *</label>
                                    <input type="text" id="popup__address" placeholder="http://yoursite.ru" required/>
                                </fieldset>

                                <fieldset>
                                    <label for="popup__phone">Номер телефона</label>
                                    <input type="tel" id="popup__phone"/>
                                </fieldset>

                                <fieldset class="discount__language">

                                    <!-- options__selects-wrap -->
                                    <div class="discount__selects-language" data-language='{
                                        "languages": [
                                            {
                                                "id": 1,
                                                "name": "Английский",
                                                "src": "img/icons-en.png"
                                            },
                                            {
                                                "id": 2,
                                                "name": "Русский",
                                                "src": "img/icons-en.png"
                                            },
                                            {
                                                "id": 3,
                                                "name": "Украинский",
                                                "src": "img/icons-ua.png"
                                            }
                                        ]
                                        }'>
                                    </div>
                                    <!-- /discount__selects-language -->
                                </fieldset>
                                <!-- btn -->
                                <button class="btn btn_discount">
                                    <span>Добавить свой сайт</span>
                                </button>
                                <!-- /btn -->
                            {!! Form::close() !!}
                        </div>
                        <!-- discount__form -->
                    </div>
                    <!-- /discount__layout -->

                    <!-- popup__close -->
                    <button class="popup__close"><span></span></button>
                    <!-- /popup__close -->
                </div>
                <!-- /order-popup_content -->
            </div>
            <!-- /order-popup -->
        </div>
        <!-- popup__content -->
        <!-- popup__content -->
        <div class="popup__content popup__thanks">
            <!-- thanks-popup -->
            <div class="thanks-popup">
                <!-- thanks-popup__content -->
                <div class="thanks-popup__content">

                    <!-- discount__thanks -->
                    <div class="discount__thanks">

                        <img src="/assets/img/img-thanks.png" alt="img"/>

                        <!-- discount__thanks-title -->
                        <h2 class="discount__thanks-title">Спасибо большое за вашу заявку</h2>
                        <!-- /discount__thanks-title -->

                        <p>Мы добавили ваш сайт на просчёт текста. Мы можете посмотреть сколько там страниц, символов, слов и т.д.</p>
                        <p>Мы также выслали вам письмо ссылкой на статистику по вашему сайту.</p>

                        <!--
                        <a href="{{route('scan.main')}}" class="btn btn_2">
                            <span>Посмотреть статистику</span>
                        </a>
                         -->

                    </div>
                    <!-- /discount__thanks -->

                </div>
                <!-- /thanks-popup__content -->
            </div>
            <!-- /thanks__content -->
        </div>
        <!-- /popup__content -->
    </div>
    <!-- /popup__wrap -->
</div>
<!-- /popup -->

<script src="/assets/js/jquery-2.1.3.min.js"></script>
<script src="/assets/js/swiper.min.js"></script>
<script src="/assets/js/jquery.nicescroll.min.js"></script>
<script src="/assets/js/jquery.select.js"></script>
<script src="/assets/js/jquery.main.js"></script>
</body>
</html>