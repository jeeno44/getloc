@extends('layouts.account')
@section('title') Виджет @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <h1>Как подключить виджет</h1>
        <p>В конце тега <code>head</code> необходимо добавить:</p>
        <textarea style="width: 600px; height: 60px;"><script type="text/javascript" src="http://api.get-loc.ru/getloc.js"></script></textarea>
        <p>А так же, перед закрытием тега <code>body</code> добавляем:</p>
        <textarea style="width: 600px; height: 60px;">getloc = new getloc({secret: '{{$site->secret}}', auto_detected: false, lang: 'ru'})
getloc.run()
        </textarea>
        <p>Тут потом напишем все параметры скрипта.</p>

    </div>
@stop