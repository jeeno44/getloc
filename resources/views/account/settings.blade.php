@extends('layouts.account')
@section('title') {{trans('account.t_settings_title')}} @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <div class="account-data">
            <form action="#" class="account-data__form">
                <h2 class="site__title site__title_4">{{trans('account.t_settings_integration_in_site')}}</h2>
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
            </form>
        </div>
    </div>
@stop