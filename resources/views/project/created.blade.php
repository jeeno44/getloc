@extends('layouts.account')
@section('title') {{trans('account.t_created_title')}} @stop
@section('content')
    <h1 class="site__title">{{trans('account.t_created_title')}}</h1>
    <div class="add-code">
        <div class="add-code__successfully">
            <div class="add-code__pic" style="background-image: url(/assets/img/account/create-s.png)"></div>
            <span>{{trans('account.t_created_text1')}}</span>
            <p>{{trans('account.t_created_help_email')}} <a href="mailto:support@getloc.ru">support@getloc.ru</a></p>
        </div>
        <div class="add-code__project">
            <ul>
                <li>{{trans('account.t_settings_before')}}
                    <div>
                        <code>&lt;script type="text/javascript" src="http://api.{{env('APP_DOMAIN', 'getloc.ru')}}/getloc.js&gt;&lt;/script&gt;</code>
                    </div>
                </li>
                <li>{{trans('account.t_settings_after')}}
                    <div>
                        <code>&lt;script type="text/javascript"&gt;
                            getloc = new getloc({secret: '{{$site->secret}}', auto_detected: false, lang: 'ru'});
                            getloc.run()
                            &lt;/script&gt;</code>
                    </div>
                </li>
                <!--
                <li>Вы не разработчик? <a class="add-code__links" href="#">Пригласите нового члена команды</a></li>
                <li>Ознакомьтесь с нашей <a class="add-code__links" href="#">Инструкцией по быстрому старту</a> и <a class="add-code__links" href="#">Руководством по интеграции</a></li>
                -->
            </ul>
            <a href="#" class="btn btn_9 btn_blue" id="validate-site" data-id="{{$site->id}}">{{trans('account.t_created_start_work')}}</a>
        </div>
    </div>
@stop