@extends('layouts.account')
@section('title') Мои заказы @stop
@section('content')
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
    <hr>
    <h1 class="">Текущий заказ</h1>

    <hr>
    <h1 class="">История заказов</h1>


@stop