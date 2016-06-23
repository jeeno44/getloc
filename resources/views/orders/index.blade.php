@extends('layouts.account')
@section('title') {{trans('account.t_order_title')}} @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <h1 class="site__title site__title_2">{{trans('account.t_order_title')}}</h1>

        @if(!empty($currentOrder))
            <div class="translate-orders inside-content__wrap">
                <div class="inside-content__title inside-content__title_2">
                    <h2>{{trans('account.t_order_new_order')}}</h2>
                </div>
                <div class="translate-orders__content">
                    @foreach($currentOrder as $lang => $data)
                        <div class="translate-orders__item site__align-items-justify">
                            <div class="translate-orders__languages">
                                <div class="translate-languages translate-languages_small">
                                    <div class="translate-languages__item">
                                        <span class="flag" style="background-image: url(/icons/{{$site->language->icon_file}})"></span>
                                        {{$site->language->name}}
                                    </div>
                                    <div class="translate-languages__item">
                                        <span class="flag" style="background-image: url(/icons/{{$data['icon']}})"></span>
                                        {{$lang}}
                                    </div>
                                </div>
                            </div>
                            <div class="translate-orders__info">
                                <span class="translate-orders__num"><b>{{$data['count_phrases']}}</b></span> {{trans('account.t_sproject_phrases')}}, <span class="translate-orders__num"><b>{{$data['count_words']}}</b></span> {{trans('account.t_overview_words')}}
                            </div>
                            <div class="translate-orders__amount site__align-right">
                                <span class="translate-orders__price"><span>{{$data['cost']}}</span> {{trans('phrases.rubles')}}</span>&nbsp;
                                <a class="translate-orders__del" href="{{route('main.billing.del-lang-order', ['lang' => $data['lang_id']])}}"></a>
                            </div>
                        </div>
                    @endforeach
                    <div class="translate-orders__item site__align-items-justify translate-orders__item_no-border translate-orders__item_total">
                        <div class="translate-orders__status">
                            {{trans('account.t_order_uslovie')}} <span class="translate-orders__status-important"><b>48</b> {{trans('account.t_order_timing')}}</span>
                        </div>
                        <div class="translate-orders__total site__align-right">
                            {{trans('account.t_subtotal_total')}} <span class="translate-orders__total-sum"><span>{{$fullCost}}</span> {{trans('account.t_order_rubl')}}</span>
                        </div>
                    </div>
                    <form action="#" class="translate-orders__send site__align-right">
                        <a href="{{route('main.billing.prepare-order', ['id' => $order->id])}}" class="btn btn_6" style="padding-top: 14px;">{{trans('account.t_order_go_pay')}}</a>
                    </form>

                </div>
            </div>
        @else
            <div class="translate-orders inside-content__wrap">
                <div class="inside-content__title inside-content__title_2">
                    <h2>{{trans('account.t_order_new_order')}}</h2>
                </div>
                <div class="translate-orders__content">
                    {{trans('account.t_order_not_phrases')}}<br><br>
                </div>
            </div>
        @endif

        @if(count($orders))
            <h2 class="site__title site__title_3">{{trans('account.t_order_status_1')}}</h2>
            <div class="translate-orders inside-content__wrap">
                @foreach($orders as $order)
                    <div class="inside-content__title inside-content__title_2">
                        <h2>{{trans('account.t_order_order_title')}}</h2>
                        <time class="inside-content__time" datetime="{{$order->created_at}}">{{ruDate($order->created_at)}}</time>
                    </div>
                    <div class="translate-orders__content">
                        @foreach($order->langs as $lang)
                            <div class="translate-orders__item site__align-items-justify">
                                <div class="translate-orders__languages">
                                    <div class="translate-languages translate-languages_small">
                                        <div class="translate-languages__item">
                                            <span class="flag" style="background-image: url(/icons/{{$site->language->icon_file}})"></span>
                                            {{$site->language->name}}
                                        </div>
                                        <div class="translate-languages__item">
                                            <span class="flag" style="background-image: url(/icons/{{$lang->icon_file}})"></span>
                                            {{$lang->original_name}}
                                        </div>
                                    </div>
                                </div>
                                <div class="translate-orders__info">
                                    <span class="translate-orders__num">{{$lang->count_blocks}}</span>
                                    {{trans('account.t_sproject_phrases')}},
                                    <span class="translate-orders__num">{{$lang->count_words}}</span>
                                    {{trans('account.t_overview_words')}}
                                </div>
                                <div class="translate-orders__amount site__align-right">
                                    <span class="translate-orders__price"><span>{{$lang->count_words * $lang->word_cost}}</span> {{trans('account.t_order_rubl')}}</span>
                                </div>
                            </div>
                        @endforeach
                        <div class="translate-orders__item site__align-items-justify translate-orders__item_no-border translate-orders__item_total">
                            <div class="translate-orders__status">
                                {{trans('account.t_order_uslovie')}} <span class="translate-orders__status-important">48 {{trans('account.t_order_timing')}}</span>
                            </div>
                            <div class="translate-orders__total site__align-right">
                                {{trans('account.t_subtotal_total')}} <span class="translate-orders__total-sum"><span>{{$order->original_sum}}</span> {{trans('account.t_order_rubl')}}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if(count($doneOrders))
            <h2 class="site__title site__title_3">{{trans('account.t_order_status_2')}}</h2>
            <div class="translate-orders inside-content__wrap">
                @foreach($doneOrders as $order)
                    <div class="inside-content__title inside-content__title_2">
                        <h2>{{trans('account.t_order_order_title')}}</h2>
                        <time class="inside-content__time" datetime="{{$order->created_at}}">{{ruDate($order->created_at)}}</time>
                    </div>
                    <div class="translate-orders__content">
                        @foreach($order->langs as $lang)
                            <div class="translate-orders__item site__align-items-justify">
                                <div class="translate-orders__languages">
                                    <div class="translate-languages translate-languages_small">
                                        <div class="translate-languages__item">
                                            <span class="flag" style="background-image: url(/icons/{{$site->language->icon_file}})"></span>
                                            {{$site->language->name}}
                                        </div>
                                        <div class="translate-languages__item">
                                            <span class="flag" style="background-image: url(/icons/{{$lang->icon_file}})"></span>
                                            {{$lang->original_name}}
                                        </div>
                                    </div>
                                </div>
                                <div class="translate-orders__info">
                                    <span class="translate-orders__num">{{$lang->count_blocks}}</span>
                                    {{trans('account.t_sproject_phrases')}},
                                    <span class="translate-orders__num">{{$lang->count_words}}</span>
                                    {{trans('account.t_overview_words')}}
                                </div>
                                <div class="translate-orders__amount site__align-right">
                                    <span class="translate-orders__price"><span>{{$lang->count_words * $lang->word_cost}}</span> {{trans('account.t_order_rubl')}}</span>
                                </div>
                            </div>
                        @endforeach
                        <div class="translate-orders__item site__align-items-justify translate-orders__item_no-border translate-orders__item_total">
                            <div class="translate-orders__status">
                                {{trans('account.t_order_status_3')}}
                            </div>
                            <div class="translate-orders__total site__align-right">
                                {{trans('account.t_subtotal_total')}} <span class="translate-orders__total-sum"><span>{{$order->original_sum}}</span> {{trans('account.t_order_rubl')}}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
@stop