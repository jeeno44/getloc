@extends('layouts.account')
@section('title') Обзор проекта @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <a class="" href="{{route('main.account.project-remove', ['id' => Session::get('projectID')])}}">Удалить проект</a>
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
        <?php $sub = Auth::user()->subscription()->first()?>
        @if ($sub)
            <div class="tariff inside-content__wrap">
                <div class="inside-content__title">
                    <h2>Тарифный план</h2>
                    <a href="{{route('main.billing')}}" class="inside-content__tune">Изменить</a>
                </div>
                <div class="tariff__info">
                    {{$sub->plan->name}} –
                    <span class="tariff__sum">{{$sub->plan->cost}}</span>
                    р/мес
                </div>
                <div class="tariff__period">
                    <p>Осталось
                        <span class="tariff__days">{{Carbon\Carbon::now()->diffForHumans(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $sub->ends_at))}}</span>
                        до истечения оплаченного периода</p>
                    <p><a href="#">Информация об оплате</a></p>
                </div>
            </div>
        @endif
        <div class="translation inside-content__wrap">
            <div class="inside-content__title">
                <h2>{{trans('account.napLang')}}</h2>
                <a href="#" class="inside-content__tune">{{trans('account.controlLangs')}}</a>
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