@extends('layouts.account')
@section('title') Оплата подписки @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <h2 class="site__title site__title_4">Оплата подписки</h2>
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
                <div class="tariff__info" style="width: 100%">
                    @if($site->demo_ends_at > date('Y-m-d H:i:s'))
                        Демо режим закончится {{ruDate($site->demo_ends_at)}}
                    @else
                        {{trans('account.t_not_select_tarif')}}
                    @endif

                </div>
            @endif
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