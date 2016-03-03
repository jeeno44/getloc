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
                                    <span class="statistic__line-number">{{$graph['cc']}}</span>
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
                    <span class="inside-content__name">itbFirst</span>
                </h2>
                <a href="#" class="inside-content__tune">Настроить</a>
            </div>
            <div class="project__item">
                <div class="btn-lock"></div>
                <span class="project__topic">Автоматический перевод</span>
                <span class="project__status">Перевод новых страниц будет осуществляться автоматически</span>
            </div>
            <div class="project__item">
                <div class="btn-lock btn-lock_on"></div>
                <span class="project__topic">Автопубликация</span>
                <span class="project__status">Новые переведенные фразы сразу публикуются</span>
            </div>
        </div>
        <div class="tariff inside-content__wrap">
            <div class="inside-content__title">
                <h2>Тарифный план</h2>
                <a href="#" class="inside-content__tune">Изменить</a>
            </div>
            <div class="tariff__info">
                Простечковый совсем –
                <span class="tariff__sum">500</span>
                р/мес
            </div>
            <div class="tariff__period">
                <p>Осталось
                    <span class="tariff__days">13 дней</span>
                    до истечения оплаченного периода</p>
                <p><a href="#">Информация об оплате</a></p>
            </div>
        </div>
        <div class="translation inside-content__wrap">
            <div class="inside-content__title">
                <h2>Направления перевода</h2>
                <a href="#" class="inside-content__tune">Управление языками</a>
            </div>
            <div class="translation__item">
                <div class="translation__language">
                    <span class="translation__language-flag" style="background-image: url('/assets/img/account/icons-en.png')"></span>
                    Немецкий
                </div>
                <div class="translation__info">
                    Переведено
                    <span class="translation__num">200 / 3298</span>
                    фраз
                </div>
                <div class="translation__status">
                    <div style="width: 62%"></div>
                </div>
            </div>
            <div class="translation__item">
                <div class="translation__language">
                    <span class="translation__language-flag" style="background-image: url('/assets/img/account/icons-en.png')"></span>
                    Японский
                </div>
                <div class="translation__info">
                    Переведено
                    <span class="translation__num">17263 / 17263</span>
                    фраз
                </div>
                <div class="translation__status status-done">
                    <div style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
@stop