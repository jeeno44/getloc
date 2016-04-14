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

    <link rel="stylesheet" href="/assets/css/normalize.css" />
    <link rel="stylesheet" href="/assets/css/ion.rangeSlider.css" />
    <link rel="stylesheet" href="/assets/css/ion.rangeSlider.skinFlat.css" />
    <link rel="stylesheet" href="/assets/css/account/select.css" />
    <link rel="stylesheet" href="/assets/css/account/main.css" />
    <link rel="stylesheet" href="/assets/css/account/custom.css" />
    <link rel="stylesheet" href="/assets/css/account/account.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" />

    {{--<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/ui-lightness/jquery-ui.css">--}}
</head>
<body>
    <div class="site" id="up">
       @include('partials.accountHeader')
        <div class="site__content site_inner">
            <div class="site__wrap">
                @yield('content')
            </div>
        </div>
        @include('partials.accountFooter')
    </div>
    <script src="/assets/js/account/jquery-2.1.3.min.js"></script>
    <script src="/assets/js/account/ion.rangeSlider.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.11.4/jquery-ui.min.js"></script>

    {{--<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>--}}
    <script src="/assets/js/account/jquery.nicescroll.min.js"></script>
    <script src="/assets/js/account/jquery.select.js"></script>
    <script src="/assets/js/account/jquery.main.js"></script>
    <script src="/assets/js/account/toastr.min.js"></script>
    <link rel="stylesheet" href="/assets/css/account/toastr.min.css" />
    {{--<script src="/assets/js/account/jquery.account.js"></script>--}}
    <script src="/assets/js/account/custom.js"></script>
    <script src="/assets/js/account/billing.js"></script>
</body>
</html>
