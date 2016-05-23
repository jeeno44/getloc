@extends('layouts.account')
@section('title') Виджет @stop
@section('content')
    @if(!empty($site->subscription))
        @if($site->subscription->count_words < $site->count_words || $site->subscription->count_languages < $site->languages()->count())
            <div class="other-tariff">
                <h2 class="other-tariff__title">Необходим более крутой тариф</h2>
                <p>Сейчас в вашем заказе {{$site->count_words}} слов и {{$site->languages()->count()}} язык(а). А ваш тариф рассчитан на {{$site->subscription->count_words}} слов и {{$site->subscription->count_languages}} язык(а).</p>
                <a href="{{route('main.billing.upgrade', ['id' => $site->id])}}" class="other-tariff__change">Сменить тарифный план</a>
            </div>
        @endif
    @endif
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <h1>Как подключить виджет</h1>
        <p>В конце тега <code>head</code> необходимо добавить:</p>
        <textarea style="width: 600px; height: 60px;"><script type="text/javascript" src="http://api.{{env('APP_DOMAIN', 'getloc.ru')}}/getloc.js"></script></textarea>
        <p>А так же, перед закрытием тега <code>body</code> добавляем:</p>
        <textarea style="width: 600px; height: 60px;"><script type="text/javascript">
getloc = new getloc({secret: '{{$site->secret}}', auto_detected: false, lang: 'ru'})
getloc.run()
</script>
        </textarea>
        <p>Тут потом напишем все параметры скрипта.</p>

    </div>
@stop