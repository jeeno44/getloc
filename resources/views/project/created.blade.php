@extends('layouts.account')
@section('title') Добавьте код getLoc на ваш сайт @stop
@section('content')
    <h1 class="site__title title_project">Добавьте код getLoc на ваш сайт</h1>
    <div class="add-code">
        <div class="add-code__successfully">
            <div class="add-code__pic" style="background-image: url(/assets/img/account/create-s.png)"></div>
            <span>Желаем вам приятной работы с нашим сервисом?</span>
            <p>По всем интересующим вас вопросам вы можете обращаться на почту: <a href="mailto:support@getloc.ru">support@getloc.ru</a></p>
        </div>
        <div class="add-code__project">
            <ul>
                <li>В конце тега <code>head</code> необходимо добавить:
                    <textarea style="width: 600px; height: 60px;"><script type="text/javascript" src="http://api.get-loc.ru/getloc.js"></script></textarea>
                    <a class="add-code__copy" href="#">Скопировать в буфер-обмена</a>
                </li>
                <li>Вставьте следующий код перед закрывающим тегом body вашего сайта
                    <textarea style="width: 600px; height: 60px;"><script>getloc = new getloc({secret: '{{$site->secret}}', auto_detected: false, lang: 'ru'})</script></textarea>
                    <a class="add-code__copy" href="#">Скопировать в буфер-обмена</a>
                </li>
                <li>После этого нажмите "Подтвердить права на управление сайтом"</li>
            </ul>
            <a href="#" class="btn btn_2" id="validate-site" data-id="{{$site->id}}">Начать работать с проектом</a>
        </div>
    </div>
@stop