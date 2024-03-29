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
    <!-- /site__footer -->
    <footer class="site__footer">
        <!-- /site__footer-layout -->
        <div class="site__footer-layout">
            <!-- footer__logo -->
            <div class="footer__logo">
                <img src="/assets/img/logo.png" width="90" height="26" alt="getLoc">
            </div>
            <!-- footer-menu -->
			 <div class="footer-menu">
				<dl>
					<dt><a href="{{route('main.feature')}}" class="active"><span>{{trans('phrases.capabilities')}}</span></a></dt>
				</dl>
				<dl>
					<dt><a href="{{route('scan.main')}}"><span>{{trans('phrases.analytics')}}</span></a></dt>
				</dl>
			 </div>
			 <!-- /footer-menu -->
            <div class="social">
                <a href="https://vk.com/getloc" class="social-vk" target="_blank"></a>
                <a href="https://www.facebook.com/getlocru/" class="social-fb" target="_blank"></a>
            </div>
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
                        <h2 class="site__title">{{trans('phrases.add_site')}}</h2>
                        <!-- /site__title -->

                        <!-- popup__introduction -->
                        <div class="popup__introduction">
                            <p>{!!trans('phrases.get_discount_form_header')!!}</p>
                        </div>
                        <!-- /popup__introduction -->

                        <!-- discount__form -->
                        <div class="discount__form popup_form">
                            {!! Form::open(['route' => 'main.get-demo']) !!}

                                <fieldset>
                                    <label for="popup__email">{{trans('phrases.your_email')}}</label>
                                    <input type="email" id="popup__email"  placeholder="yourmail@site.com" required/>
                                </fieldset>

                                <fieldset>
                                    <label for="popup__name">{{trans('phrases.name_last_name')}}</label>
                                    <input type="text" id="popup__name"/>
                                </fieldset>

                                <fieldset>
                                    <label for="popup__address">{{trans('phrases.site_address')}}</label>
                                    <input type="text" id="popup__address" placeholder="http://yoursite.com" required/>
                                </fieldset>

                                <fieldset>
                                    <label for="popup__phone">{{trans('phrases.phone_number')}}</label>
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
                                    <span>{{trans('phrases.add_your_site')}}</span>
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
                        <h2 class="discount__thanks-title">{{trans('phrases.big_thanks_for_request')}}</h2>
                        <!-- /discount__thanks-title -->

                        <p>{{trans('phrases.we_create_project')}}</p>
                        <p>{{trans('phrases.we_send_letter')}}</p>

                        <!--
                        <a href="{{route('scan.main')}}" class="btn btn_2">
                            <span>{{trans('phrases.show_stat')}}</span>
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
<script src="/assets/js/app.js"></script>
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