@extends('layouts.account')
@section('title') {{trans('account.overviewProject')}} @stop
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
                <li>
                    <span>{{$site['count_words']}}</span>
                    {{trans('account.words')}}
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
                    <b>{{$site->name}}</b> – {{$site->url}}
                </h2>
                {{--
                <a href="#" class="inside-content__tune">{{trans('account.settings')}}</a>
                --}}
            </div>
            <div class="project__item">
                <div id="setAutoTranslateProject" class="btn-lock @if ($site_settings->auto_translate == 1) btn-lock_on @endif"></div>
                <span class="project__topic">{{trans('account.t_on_autotrans')}}</span>
                <span class="project__status">{{trans('account.t_on_autotrans_desc')}}</span>
            </div>
            <div class="project__item">
                <div id="setAutoPublishingProject" class="btn-lock @if ($site_settings->auto_publishing == 1) btn-lock_on @endif"></div>
                <span class="project__topic">{{trans('account.t_on_autopub')}}</span>
                <span class="project__status">{{trans('account.t_on_autopub_desc')}}</span>
            </div>
        </div>
        <div class="tariff inside-content__wrap">
            <div class="inside-content__title">
                <h2>{{trans('account.t_tarif')}}</h2>
                @if($site->subscription)
                    <div class="inside-content__tune">
                        <a href="#" data-popup="tt" class="inside-content__tune-link popup__open">{{trans('account.t_change')}}</a>
                        <a href="{{route('main.billing.prolong', ['id' => $site->id])}}" class="inside-content__tune-link">{{trans('account.t_cont')}}</a>
                    </div>
                @else
                    <div class="inside-content__tune">
                        <a href="#" class="inside-content__tune-link popup__open" data-popup="bb">{{trans('account.t_buy')}}</a>
                    </div>
                @endif

            </div>
            @if($site->subscription)
            <div class="tariff__info">
                {{$site->subscription->plan->name}} –
                <span class="tariff__sum">{{number_format($site->subscription->month_cost, 0, ' ', ' ')}}</span> {{trans('account.t_month_cost')}}
            </div>
            <div class="tariff__period">
                @if($site->subscription->deposit > 0.00)
                    <?php $diff = round($site->subscription->deposit / ($site->subscription->month_cost / 30 ))?>
                    <p>{{Lang::choice('phrases.ostalos', $diff)}} <b><span class="tariff__days">
                            {{$diff}}</span></b>
                        {{Lang::choice('phrases.count_days', $diff)}} {{trans('account.t_diff_range')}}
                    </p>
                @else
                    <p>{{trans('account.t_buy_exit')}}</p>
                @endif
            </div>
            @else
                <div class="tariff__info">
                    {{trans('account.t_not_select_tarif')}}
                </div>
            @endif
        </div>
        <div class="translation inside-content__wrap">
            <div class="inside-content__title">
                <h2>{{trans('account.napLang')}}</h2>
                <div class="inside-content__tune">
                    <a href="{{URL::route('main.account.languages')}}" class="inside-content__tune-link">{{trans('account.controlLangs')}}</a>
                </div>

            </div>
            @foreach ($stats['langStats'] as $short => $lang)
            <div class="translation__item">
                <div class="translation__language translation__language_overview">
                    <div class="translate-languages">
                        <div class="translate-languages__item">
                            <span class="flag" style="background-image: url(/icons/{{$site->language->icon_file}})"></span>
                            {{$site->language->original_name}}
                        </div>
                        <div class="translate-languages__item">
                            <span class="flag" style="background-image: url(/icons/{{$lang['icon']}})"></span>
                            {{$lang['name']}}
                        </div>
                    </div>
                </div>
                <div class="translation__info">
                    {{trans('account.inProcTranslated')}}
                    <b><span class="translation__num">{{$lang['cc']}} / {{$lang['ccb']}}</span></b>
                    {{Lang::choice('account.phrases', $lang['cc'])}}
                </div>
                <div class="translation__status @if ($lang['per'] == 100)status-done @endif">
                    <div style="width: {{$lang['per']}}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="popup">
        <div class="popup__wrap">
            <div class="popup__content popup__tariff popup__tt">
                <a href="#" class="popup__close">close</a>
                <div class="tariff-plan">
                    <h2 class="site__title site__title_center">{{trans('account.t_select_tarif')}}</h2>
                    <div class="tariff-plan__items">
                        @if(!empty($site->subscription->plan_id))
                            <?php $plans = \App\Plan::where('id', '!=', $site->subscription->plan_id)->where('enabled', 1)->get()?>
                        @else
                            <?php $plans = \App\Plan::where('enabled', 1)->get()?>
                        @endif
                        @foreach($plans as $plan)
                            <div class="tariff-plan__item">
                                <h3 class="tariff-plan__name">{{$plan->name}}</h3>
                                <div class="tariff-plan__cost">
                                    <div class="tariff-plan__cost-num">{{(int)$plan->cost}}</div>
                                    <span>{{trans('account.t_month_cost2')}}</span>
                                </div>
                                <div class="tariff-plan__possibility">
                                    <div>
                                        <span class="tariff-plan__possibility-num">{{$plan->count_languages}}</span> {{trans_choice('account.languages_count', $plan->count_languages)}} {{trans('account.t_overview_trans')}}
                                    </div>
                                    <div>
                                        <span class="tariff-plan__possibility-num">{{$plan->count_words}}</span> {{trans('account.t_overview_words')}}
                                    </div>
                                </div>
                                <form action="{{route('main.billing.upgrade-store')}}" method="post">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="site_id" value="{{$site->id}}">
                                    <input type="hidden" name="plan_id" value="{{$plan->id}}">
                                    <button type="submit" class="btn btn_9 btn_blue btn_full-width">{{trans('account.t_overview_select_tarif')}}</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                    <p>{{trans('account.t_overview_select_tarif_recommend')}}</p>
                </div>
            </div>
            <div class="popup__content popup__tariff popup__bb">
                <a href="#" class="popup__close">close</a>
                <div class="tariff-plan">
                    <h2 class="site__title site__title_center">{{trans('account.t_select_tarif')}}</h2>
                    <div class="tariff-plan__items">
                        @foreach(\App\Plan::where('enabled', 1)->get() as $plan)
                            <form action="{{route('main.billing', ['id' => $site->id])}}" class="tariff-plan__item">
                                <h3 class="tariff-plan__name">{{$plan->name}}</h3>
                                <div class="tariff-plan__cost">
                                    <div class="tariff-plan__cost-num">{{(int)$plan->cost}}</div>
                                    <span>{{trans('account.t_month_cost2')}}</span>
                                </div>
                                <div class="tariff-plan__possibility">
                                    <div>
                                        <span class="tariff-plan__possibility-num">{{$plan->count_languages}}</span> {{trans_choice('account.languages_count', $plan->count_languages)}} {{trans('account.t_overview_trans')}}
                                    </div>
                                    <div>
                                        <span class="tariff-plan__possibility-num">{{$plan->count_words}}</span> {{trans('account.t_overview_words')}}
                                    </div>
                                </div>
                                <div class="site__select1">
                                    {!! Form::select('time', getDurations(), null) !!}
                                </div>
                                <input type="hidden" name="plan_id" value="{{$plan->id}}">
                                <button type="submit" class="btn btn_9 btn_blue btn_full-width">{{trans('account.t_overview_select_tarif')}}</button>
                            </form>
                        @endforeach
                    </div>
                    <p>{{trans('account.t_overview_select_tarif_recommend')}}</p>
                </div>
            </div>
        </div>
    </div>
@stop