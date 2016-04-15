@extends('layouts.account')
@section('title') Обзор проекта @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <div class="statistic inside-content__wrap">
            <ul class="statistic__numbers">
                <li>
                    <span>{{$stats['ccPages']}}</span>
                    {{Lang::choice('account.ccPages', $stats['ccPages'])}} {{trans('account.searchPages')}}
                </li>
                <li>
                    <span>{{$stats['ccBlocks']}}</span>
                    {{Lang::choice('account.phrases', $stats['ccBlocks'])}}
                </li>
            </ul>
            <div class="tabs">
                <div class="statistic__tabs tabs__content">
                    @foreach ($stats['lineGraph'] as $lang)
                        <div class="statistic__line">
                            @foreach ($lang as $graph)
                                <div class="statistic__line-0{{$graph['i']}}" style="width: {{$graph['per']}}%">
                                    <span class="statistic__line-number">@if ($graph['cc'] != 0){{$graph['cc']}}@endif</span>
                                    <span class="statistic__line-popup">{{trans('account.'.$graph['name'])}}</span>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
                <div class="statistic__tabs-links tabs__links">
                    @foreach ($stats['listLangs'] as $lang)
                        <a href="#">{{$lang->name}}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="project inside-content__wrap">
            <div class="inside-content__title">
                <h2>
                    Проект –
                    <span class="inside-content__name">{{$site->name}}</span>
                </h2>
                {{--
                <a href="#" class="inside-content__tune">{{trans('account.settings')}}</a>
                --}}
            </div>
            <div class="project__item">
                <div id="setAutoTranslateProject" class="btn-lock @if ($site_settings->auto_translate == 1) btn-lock_on @endif"></div>
                <span class="project__topic">Автоматический перевод</span>
                <span class="project__status">Перевод новых страниц будет осуществляться автоматически</span>
            </div>
            <div class="project__item">
                <div id="setAutoPublishingProject" class="btn-lock @if ($site_settings->auto_publishing == 1) btn-lock_on @endif"></div>
                <span class="project__topic">Автопубликация</span>
                <span class="project__status">Новые переведенные фразы сразу публикуются</span>
            </div>
        </div>
        <div class="tariff inside-content__wrap">
            <div class="inside-content__title">
                <h2>Тарифный план</h2>
                @if($site->subscription)
                    <a href="{{route('main.billing.upgrade', ['id' => $site->id])}}" class="">Изменить</a>
                    <a href="{{route('main.billing.prolong', ['id' => $site->id])}}" class="">Продлить</a>
                @else
                    <a href="{{route('main.billing', ['id' => $site->id])}}" class="inside-content__tune">Купить</a>
                @endif

            </div>
            @if($site->subscription)
            <div class="tariff__info">
                {{$site->subscription->plan->name}} –
                <span class="tariff__sum">{{$site->subscription->month_cost}}</span>р/мес
            </div>
            <div class="tariff__period">
                @if($site->subscription->deposit > 0.00)
                    <?php $diff = round($site->subscription->deposit / ($site->subscription->month_cost / 30 ))?>
                    <p>{{Lang::choice('phrases.ostalos', $diff)}} <span class="tariff__days">
                            {{$diff}}</span>
                        {{Lang::choice('phrases.count_days', $diff)}} до истечения оплаченного периода
                    </p>
                @else
                    <p>Оплаченный период истек</p>
                @endif
            </div>
            @else
                <div class="tariff__info">
                    не подключен ни один тарифный план
                </div>
            @endif
        </div>
        <div class="translation inside-content__wrap">
            <div class="inside-content__title">
                <h2>{{trans('account.napLang')}}</h2>
                <a href="{{URL::route('main.account.languages')}}" class="inside-content__tune">{{trans('account.controlLangs')}}</a>
            </div>
            @foreach ($stats['langStats'] as $short => $lang)
            <div class="translation__item">
                <div class="translation__language">
                    <span class="translation__language-flag" style="background-image: url('/assets/img/account/icons-en.png')"></span>
                    {{$lang['name']}}
                </div>
                <div class="translation__info">
                    {{trans('account.inProcTranslated')}}
                    <span class="translation__num">{{$lang['cc']}} / {{$lang['ccb']}}</span>
                    {{Lang::choice('account.phrases', $lang['cc'])}}
                </div>
                <div class="translation__status @if ($lang['per'] == 100)status-done @endif">
                    <div style="width: {{$lang['per']}}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@stop