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

    <link rel="stylesheet" href="/assets/css/account/select.css" />
    <link rel="stylesheet" href="/assets/css/account/main.css" />

</head>
<body>
    <!-- site -->
    <div class="site" id="up">

       @include('partials.accountHeader')

        <!-- site__content -->
        <div class="site__content site_inner">

            <!-- site__wrap -->
            <div class="site__wrap">

                <!--site__aside-->
                <aside class="site__aside">

                    <!--site__aside-menu-->
                    <div class="site__aside-menu">

                        <a @if (Request::is('account') or Request::is('account/overview'))class="active" @endif href="{{ URL::route('main.account.overview') }}">{{trans('account.overviewProject')}}</a>
                        <a @if (Request::is('account/languages')) class="active" @endif href="{{ URL::route('main.account.languages') }}">{{trans('account.languages')}}</a>
                        <a href="#">{{trans('account.pagesProject')}}</a>
                        <a href="#">{{trans('account.translatePhrases')}}</a>
                        <a href="#">{{trans('account.widget')}}</a>
                        <a href="#">{{trans('account.settingsProject')}}</a>
                        <a href="#" class="aside-menu__order">{{trans('account.myOrders')}} <span>2</span></a>

                    </div>
                    <!--/site__aside-menu-->

                </aside>
                <!--/site__aside-->

                <!-- inside-content -->
                <div class="inside-content">

                    @yield('content')

                </div>
                <!-- /inside-content -->

            </div>
            <!-- /site__wrap -->

        </div>
        <!-- /site__content -->

        @include('partials.accountFooter')

    </div>
    <!-- /site -->

    <script src="/assets/js/account/jquery-2.1.3.min.js"></script>
    <script src="/assets/js/account/jquery.nicescroll.min.js"></script>
    <script src="/assets/js/account/jquery.select.js"></script>
    <script src="/assets/js/account/jquery.main.js"></script>
</body>
</html>
