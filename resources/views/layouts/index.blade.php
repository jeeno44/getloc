<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=992">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="address=no">
    <title>@yield('title')</title>
    <link href="/favicon.ico" rel="shortcut icon" type="image/x-icon">
    <meta itemprop="name" content="getLoc - get Localization">
    <meta itemprop="description" content="Идеальное решение для быстрого перевода и локализации веб-сайта на любые языки">
    <meta itemprop="image" content="http://get-loc.ru/assets/img/share.png">

    <meta property="og:site_name" content="getLoc - get Localization" />
    <link rel="image_src" href="http://get-loc.ru/assets/img/share.png" />
    <meta property="og:image" content="http://get-loc.ru/assets/img/share.png" />
    <meta property="og:title" content="getLoc - get Localization" />
    <meta property="og:description" content="Идеальное решение для быстрого перевода и локализации веб-сайта на любые языки" />
    <meta property="og:url" content="http://get-loc.ru/" />
    
    <link href='https://fonts.googleapis.com/css?family=Fira+Sans:400,300,500,700&subset=cyrillic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/assets/css/swiper.min.css" />
    <link rel="stylesheet" href="/assets/css/select.css" />
    <link rel="stylesheet" href="/assets/css/main.css" />
    <link rel="stylesheet" href="/assets/css/custom.css" />
</head>
<body>
<!-- site -->
<div class="site" id="up">
    @include('partials.header')
    @yield('content')
    <footer class="site__footer">
        <div class="site__footer-layout">
            <div class="footer__logo">
                <img src="/assets/img/logo.png" width="90" height="26" alt="getLoc">
            </div>
            <div class="footer-menu">
                <dl>
                    <dt><a href="{{route('main.feature')}}" class="active"><span>{{trans('phrases.capabilities')}}</span></a></dt>
                </dl>
                <dl>
                    <dt><a href="{{route('scan.main')}}"><span>{{trans('phrases.analytics')}}</span></a></dt>
                </dl>
            </div>
            <div class="social">
                <a href="https://vk.com/getloc" class="social-vk" target="_blank"></a>
                <a href="https://www.facebook.com/getlocru/" class="social-fb" target="_blank"></a>
            </div>
        </div>
    </footer>
</div>
<div class="popup">
    <div class="popup__wrap">
        <div class="popup__content popup__content_check popup__login">
            <button class="popup__close popup__close_small"><span></span></button>
            <div class="popup__head">
                <a href="#" class="logo">
                    <img src="/assets/img/logo.png" width="90" height="26" alt="GETLOC">
                </a>
            </div>
            <div class="popup__inner">
                <form action="{{route('login.post')}}" class="site__form" novalidate method="post">
                    {!! csrf_field() !!}
                    <span class="site__form-title">Вход</span>
                    <fieldset>
                        <label for="email">Ваша эл. почта *</label>
                        <input type="email" id="email" required name="email">
                    </fieldset>
                    <fieldset>
                        <label for="password">Пароль</label>
                        <input type="password" id="password" required name="password">
                    </fieldset>
                    <button type="submit" class="btn btn_enroll">Войти</button>
                    <a href="{{route('password.reset.form')}}" class="site__form-forgot">Забыли пароль?</a>
                </form>
                <div class="popup__social">
                    Вы можете зайти через соцсети
                    <div class="social-2">
                        <a href="{{route('facebook.redirect')}}" class="social-2__fb">facebook</a>
                        <a href="{{route('twitter.redirect')}}" class="social-2__tw">twitter</a>
                        <a href="{{route('google.redirect')}}" class="social-2__google">google</a>
                    </div>
                </div>
            </div>
            <div class="popup__footer">
                Нет учётной записи?
                <a href="#" class="popup__open" data-popup="registry">Зарегистрироваться</a>
            </div>
        </div>
        <div class="popup__content popup__content_check popup__registry">
            <button class="popup__close popup__close_small"><span></span></button>
            <div class="popup__head">
                <a href="#" class="logo">
                    <img src="/assets/img/logo.png" width="90" height="26" alt="GETLOC">
                </a>
            </div>
            <div class="popup__inner">
                <form action="{{route('register.post')}}" class="site__form" novalidate method="post">
                    {!! csrf_field() !!}
                    <span class="site__form-title">Регистрация</span>
                    <fieldset>
                        <label for="name">Ваше имя</label>
                        <input type="text" id="name" required name="name">
                    </fieldset>
                    <fieldset>
                        <label for="email2">Ваша эл. почта *</label>
                        <input type="email" id="email2" required name="email">
                    </fieldset>
                    <fieldset>
                        <label for="password2">Пароль</label>
                        <input type="password" id="password2" required name="password">
                    </fieldset>
                    <button type="submit" class="btn btn_enroll">Попробовать бесплатно</button>
                </form>
                <div class="popup__social">
                    Вы можете зарегистрироваться через соцсети
                    <div class="social-2">
                        <a href="{{route('facebook.redirect')}}" class="social-2__fb">facebook</a>
                        <a href="{{route('twitter.redirect')}}" class="social-2__tw">twitter</a>
                        <a href="{{route('google.redirect')}}" class="social-2__google">google</a>
                    </div>
                </div>
            </div>
            <div class="popup__footer">
                Уже регистрированы?
                <a href="#" class="popup__open" data-popup="login">Войти</a>
            </div>
        </div>
        <div class="popup__content popup__order">
            <div class="order-popup">
                <div class="order-popup__content">
                    <div class="discount__layout">
                        <h2 class="site__title">{{trans('phrases.add_site')}}</h2>
                        <div class="popup__introduction">
                            <p>{!!trans('phrases.get_discount_form_header')!!}</p>
                        </div>
                        <div class="discount__form popup_form">
                            {!! Form::open(['route' => 'main.get-demo', 'novalidate']) !!}
                                <fieldset>
                                    <label for="popup__email">{{trans('phrases.your_email')}}</label>
                                    <input type="email" id="discount__email"  placeholder="yourmail@site.com" required/>
                                </fieldset>
                                <fieldset>
                                    <label for="popup__name">{{trans('phrases.name_last_name')}}</label>
                                    <input type="text" id="discount__name"/>
                                </fieldset>
                                <fieldset>
                                    <label for="popup__address">{{trans('phrases.site_address')}}</label>
                                    <input type="text" id="discount__address" placeholder="http://yoursite.com" required/>
                                </fieldset>
                                <fieldset>
                                    <label for="popup__phone">{{trans('phrases.phone_number')}}</label>
                                    <input type="tel" id="discount__phone"/>
                                </fieldset>
                                <fieldset class="discount__language">
                                    <label>Язык перевода *</label>
                                    <div class="discount__selects-language" data-language='{{getLanguagesJson()}}'>
                                        <div class="discount__language-wrapper">
                                            <select name="lang_1" id="lang_1" required>
                                                <option value="0">Выберите язык</option>
                                            </select>
                                            <a href="#" class="discount__languadge-add">Добавить язык перевода</a>
                                        </div>
                                    </div>
                                </fieldset>
                                <button class="btn btn_discount">
                                    <span>{{trans('phrases.add_your_site')}}</span>
                                </button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <button class="popup__close"><span></span></button>
                </div>
            </div>
        </div>
        <div class="popup__content popup__thanks">
            <div class="thanks-popup">
                <div class="thanks-popup__content">
                    <div class="discount__thanks">
                        <img src="/assets/img/img-thanks.png" alt="img"/>
                        <h2 class="discount__thanks-title">{{trans('phrases.big_thanks_for_request')}}</h2>
                        <p>{{trans('phrases.we_create_project')}}</p>
                        <p>{{trans('phrases.we_send_letter')}}</p>
                        <!--
                        <a href="{{route('scan.main')}}" class="btn btn_2">
                            <span>{{trans('phrases.show_stat')}}</span>
                        </a>
                         -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/assets/js/jquery-2.1.3.min.js"></script>
<script src="/assets/js/swiper.min.js"></script>
<script src="/assets/js/jquery.nicescroll.min.js"></script>
<script src="/assets/js/jquery.select.js"></script>
<script src="/assets/js/jquery.main.js"></script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-73373530-1', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>