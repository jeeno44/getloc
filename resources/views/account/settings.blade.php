@extends('layouts.account')
@section('title') Настройки @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <div class="account-data">
            <h1 class="site__title">Настройки проекта</h1>
            <form action="#" class="account-data__form">
                <h2 class="site__title site__title_4">Интеграция в сайт</h2>
                <div class="add-code__project">
                    <ul>
                        <li>В конце тега head необходимо добавить:
                            <div>
                                <code>&lt;script type="text/javascript" src="http://api.getloc.ru/getloc.js"&gt;&lt;/script&gt;</code>
                            </div>
                        </li>
                        <li>А так же, перед закрытием тега body добавляем:
                            <div>
                                <code>&lt;script type="text/javascript"&gt;
                                    getloc = new getloc({secret: '{{$site->secret}}', auto_detected: false, lang: 'ru'});
                                    getloc.run();
                                    &lt;/script&gt;</code>
                            </div>
                        </li>
                    </ul>
                </div>
            </form>
        </div>
    </div>
@stop