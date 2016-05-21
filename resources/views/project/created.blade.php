@extends('layouts.account')
@section('title') Добавьте код getLoc на ваш сайт @stop
@section('content')
    <h1 class="site__title">Добавьте код getLoc на ваш сайт</h1>
    <div class="add-code">
        <div class="add-code__successfully">
            <div class="add-code__pic" style="background-image: url(/assets/img/account/create-s.png)"></div>
            <span>Желаем вам приятной работы с нашим сервисом?</span>
            <p>По всем интересующим вас вопросам вы можете обращаться на почту: <a href="mailto:support@getloc.ru">support@getloc.ru</a></p>
        </div>
        <div class="add-code__project">
            <ul>
                <li>В конце тега head необходимо добавить:
                    <div>
                        <code>&lt;script type="text/javascript" src="http://api.{{env('APP_DOMAIN', 'getloc.ru')}}/getloc.js&gt;&lt;/script&gt;</code>
                    </div>
                </li>
                <li>А так же, перед закрытием тега body добавляем:
                    <div>
                        <code>&lt;script type="text/javascript"&gt;
                            getloc = new getloc({secret: '{{$site->secret}}', auto_detected: false, lang: 'ru'})
                            getloc.run()
                            &lt;/script&gt;</code>
                    </div>
                </li>
                <!--
                <li>Вы не разработчик? <a class="add-code__links" href="#">Пригласите нового члена команды</a></li>
                <li>Ознакомьтесь с нашей <a class="add-code__links" href="#">Инструкцией по быстрому старту</a> и <a class="add-code__links" href="#">Руководством по интеграции</a></li>
                -->
            </ul>
            <a href="#" class="btn btn_9 btn_blue" id="validate-site" data-id="{{$site->id}}">Начать работать с проектом</a>
        </div>
    </div>
@stop