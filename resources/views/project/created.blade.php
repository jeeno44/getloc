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
                <li>Вставьте следующий код над тегом body вашего сайта
                    <div>
                        <p>
                            Доступные данные по проекту:<br>
                            @foreach($site['attributes'] as $key => $val)
                                {{$key}} => {{$val}}<br>
                            @endforeach
                        </p>
                    </div>
                    <a class="add-code__copy" href="#">Скопировать в буфер-обмена</a>
                </li>
                <li>Вы не разработчик? <a class="add-code__links" href="#">Пригласите нового члена команды</a></li>
                <li>Ознакомьтесь с нашей <a class="add-code__links" href="#">Инструкцией по быстрому старту</a> и
                    <a class="add-code__links" href="#">Руководством по интеграции</a>
                </li>
            </ul>
            <a href="#" class="btn btn_2">Начать работать с проектом</a>
        </div>
    </div>
@stop