<!DOCTYPE html> 
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=992">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="address=no">
    <title>@yield('title')</title>
    {{-- <link href='https://fonts.googleapis.com/css?family=Fira+Sans:400,300,500,700&subset=cyrillic' rel='stylesheet' type='text/css'> --}}
    <link rel="stylesheet" href="/assets/css/account/select.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" />
    <link rel="stylesheet" href="/assets/css/account/main.css" />
    <link rel="stylesheet" href="/assets/css/account/custom.css" />
    <link rel="stylesheet" href="/assets/css/account/popup.css" />
    <link rel="stylesheet" href="/assets/css/account/account.css" />
    <link rel="stylesheet" href="/assets/css/account/jquery-ui.min.css" />
    <link rel="stylesheet" href="/assets/css/account/bootstrap-colorpicker.css" />
    <link rel="stylesheet" href="/assets/css/font-awesome.css" />
    <link href="/favicon.ico" rel="shortcut icon" type="image/x-icon" />
</head>
<body>
    <div class="site" id="up">
       @include('partials.accountHeader')
        <div class="site__content site_inner">
            <div class="site__wrap">
                {!! messageAboutTariff() !!}
                @yield('content')
            </div>
        </div>
        @include('partials.accountFooter')
    </div>
    @if(count($errors) > 0)
        <div id="info-massages__item_deleted" class="flash-message" style="display: none">{{$errors->first()}}</div>
    @endif
    @if(Session::has('msg'))
        <div id="{{Session::get('msg')['class']}}" class="flash-message" style="display: none">{{Session::get('msg')['text']}}</div>
    @endif
    <script src="/assets/js/account/jquery-2.1.3.min.js"></script>
    <script src="/assets/js/account/jquery.select.js"></script>
    <script src="/assets/js/account/jquery.nicescroll.min.js"></script>
    <script src="/assets/js/account/jquery-ui.min.js"></script>
    <script src="/assets/js/account/jquery.autocomplite.js"></script>
    <script src="/assets/js/account/jquery.popup.js"></script>
    <script src="/assets/js/account/jquery.messages.js"></script>
    <script src="/assets/js/account/jquery.widget.js"></script>
    <script src="/assets/js/account/jquery.main.js"></script>
    <script src="/assets/js/account/bootstrap-colorpicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>
    <script src="/assets/js/account/custom.js"></script>
    <script src="/assets/js/account/billing.js"></script>
    @if(Route::getCurrentRoute()->getName() == 'main.account.selectProject')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.min.js"></script>
        <script>
            var socket = io('http://62.138.7.69:3002');
            socket.on('notifications', function(type, site, countP, countB){
                switch (type) {
                    case 'spider':
                        $('#pages-count-' + site).text(countP);
                        $('#site-status-' + site).text('Построение структуры (' + countP + '/' + countP +')');
                        break;
                    case 'collector':
                        $('#blocks-count-' + site).text(countB);
                        var allPagesCount = $('#pages-count-' + site).text();
                        $('#site-status-' + site).text('Сбор текста (' + countP + '/' + allPagesCount +')');
                        break;
                    case 'done':
                        if ($('#site-name-' + site).length > 0) {
                            window.location.href = '?msg=Обработка сайта ' + $('#site-name-' + site).text() + ' завершена';
                        }
                        break;
                }
            });
        </script>
    @endif
</body>
</html>
