@extends('layouts.account')
@section('title') Интеграция в сайт @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <div class="account-data" style="width: 100%">
            <form action="#" class="account-data__form"  style="width: 100%">
                <h2 class="site__title site__title_4">{{trans('account.t_settings_integration_in_site')}}</h2>
                @if($site->demo_ends_at == null && empty($site->subscription))
                    <div class="warn_panel" style="width: 100%; margin-bottom: 20px;">
                        <p>C момента генерации кода для вставки вам будет предоставлен демо режим сроком 14 дней </p>
                    </div>
                    <a class="btn btn_7 btn_blue" href="?activate=true" style="padding-top: 12px">Сгенерировать код</a>
                @else
                    <div class="add-code__project">
                        <ul>
                            <li>{{trans('account.t_settings_before')}}
                                <div>
                                    <code>&lt;script type="text/javascript" src="http://api.getloc.ru/getloc.js"&gt;&lt;/script&gt;</code>
                                </div>
                            </li>
                            <li>{{trans('account.t_settings_after')}}
                                <div>
                                    <code>&lt;script type="text/javascript"&gt;
                                        getloc = new getloc({secret: '{{$site->secret}}', auto_detected: false, lang: 'ru'});
                                        getloc.run();
                                        &lt;/script&gt;</code>
                                </div>
                            </li>
                        </ul>
                    </div>
                @endif
            </form>
        </div>
    </div>
@stop