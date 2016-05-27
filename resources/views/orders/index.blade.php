@extends('layouts.account')
@section('title') Мои заказы @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <h1 class="site__title site__title_2">Мои заказы</h1>

        @if(!empty($currentOrder))
            <div class="translate-orders inside-content__wrap">
                <div class="inside-content__title inside-content__title_2">
                    <h2>Новый заказ</h2>
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
                                <span class="translate-orders__num"><b>{{$data['count_phrases']}}</b></span> фраз, <span class="translate-orders__num"><b>{{$data['count_words']}}</b></span> слов
                            </div>
                            <div class="translate-orders__amount site__align-right">
                                <span class="translate-orders__price"><span>{{$data['cost']}}</span> {{trans('phrases.rubles')}}</span>&nbsp;
                                <a class="translate-orders__del" href="{{route('main.billing.del-lang-order', ['lang' => $data['lang_id']])}}"></a>
                            </div>
                        </div>
                    @endforeach
                    <div class="translate-orders__item site__align-items-justify translate-orders__item_no-border translate-orders__item_total">
                        <div class="translate-orders__status">
                            Заказ будет выполнен в течении <span class="translate-orders__status-important"><b>48</b> часов</span>
                        </div>
                        <div class="translate-orders__total site__align-right">
                            Итого к оплате: <span class="translate-orders__total-sum"><span>{{$fullCost}}</span> Р</span>
                        </div>
                    </div>
                    <form action="#" class="translate-orders__send site__align-right">
                        <a href="{{route('main.billing.prepare-order', ['id' => $order->id])}}" class="btn btn_6" style="padding-top: 14px;">Перейти к оплате</a>
                    </form>

                </div>
            </div>
        @else
            <div class="translate-orders inside-content__wrap">
                <div class="inside-content__title inside-content__title_2">
                    <h2>Новый заказ</h2>
                </div>
                <div class="translate-orders__content">
                    Не добавлено ни одной фразы к заказу<br><br>
                </div>
            </div>
        @endif

        @if(count($orders))
            <h2 class="site__title site__title_3">ЗАКАЗЫ В ОБРАБОТКЕ</h2>
            <div class="translate-orders inside-content__wrap">
                @foreach($orders as $order)
                    <div class="inside-content__title inside-content__title_2">
                        <h2>Заказ на перевод фраз</h2>
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
                                    фраз,
                                    <span class="translate-orders__num">{{$lang->count_words}}</span>
                                    слов
                                </div>
                                <div class="translate-orders__amount site__align-right">
                                    <span class="translate-orders__price"><span>{{$lang->count_words * $lang->word_cost}}</span> Р</span>
                                </div>
                            </div>
                        @endforeach
                        <div class="translate-orders__item site__align-items-justify translate-orders__item_no-border translate-orders__item_total">
                            <div class="translate-orders__status">
                                Заказ будет выполнен в течении <span class="translate-orders__status-important">48 часов</span>
                            </div>
                            <div class="translate-orders__total site__align-right">
                                Итого к оплате: <span class="translate-orders__total-sum"><span>{{$order->original_sum}}</span> Р</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if(count($doneOrders))
            <h2 class="site__title site__title_3">ГОТОВЫЕ ЗАКАЗЫ</h2>
            <div class="translate-orders inside-content__wrap">
                @foreach($doneOrders as $order)
                    <div class="inside-content__title inside-content__title_2">
                        <h2>Заказ на перевод фраз</h2>
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
                                    фраз,
                                    <span class="translate-orders__num">{{$lang->count_words}}</span>
                                    слов
                                </div>
                                <div class="translate-orders__amount site__align-right">
                                    <span class="translate-orders__price"><span>{{$lang->count_words * $lang->word_cost}}</span> Р</span>
                                </div>
                            </div>
                        @endforeach
                        <div class="translate-orders__item site__align-items-justify translate-orders__item_no-border translate-orders__item_total">
                            <div class="translate-orders__status">
                                Заказ выполнен
                            </div>
                            <div class="translate-orders__total site__align-right">
                                Итого к оплате: <span class="translate-orders__total-sum"><span>{{$order->original_sum}}</span> Р</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
@stop