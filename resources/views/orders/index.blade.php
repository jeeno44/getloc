@extends('layouts.account')
@section('title') Мои заказы @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">

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

        @if(!empty($currentOrder))
            <hr>
            <h1 class="">Текущий заказ</h1>
            <table class="table" style="width: 100%">
                <thead>
                <tr>
                    <th>Язык</th>
                    <th>Фраз</th>
                    <th>Слов</th>
                    <th>Стоимость</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($currentOrder as $lang => $data)
                    <tr>
                        <td>{{$lang}}</td>
                        <td>
                            {{-- <a href="/account/phrase?language_id={{$data['lang_id']}}">{{$data['count_phrases']}}</a> --}}
                            {{$data['count_phrases']}}
                        </td>
                        <td>{{$data['count_words']}}</td>
                        <td>{{$data['cost']}} {{trans('phrases.rubles')}}</td>
                        <td>
                            <a href="{{route('main.billing.del-lang-order', ['lang' => $data['lang_id']])}}">X</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <p>
                <strong>Всего фраз</strong> {{$allPhrases}}<br>
                <strong>Всего слов</strong> {{$allWords}}<br>
                <strong>Итого</strong> {{$fullCost}} {{trans('phrases.rubles')}}
            </p>
            <a href="{{route('main.billing.prepare-order', ['id' => $order->id])}}">Перейти к оплате</a>
        @elseif
            <hr>
            <h1 class="">Текущий заказ</h1>
            <p>Не добавлено ни одной фразы к заказу</p>
        @endif


        <hr>
        <h1 class="">История заказов</h1>
        <table class="table" style="width: 100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Фраз</th>
                <th>Стоимость</th>
                <th>Дата</th>
                <th>Статус</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->translates()->count()}}</td>
                    <td>&#8381;{{number_format($order->payment_sum, 0, '.', ' ') }}</td>
                    <td>
                        {{date('d.m.Y H:i:s', strtotime($order->created_at))}}
                    </td>
                    <td>
                        {!! getOrderStatus($order->status) !!}
                    </td>
                    <td>
                        @if(file_exists(public_path('uploads/order_'.$order->id.'.xml')))
                            {!! link_to_asset('uploads/order_'.$order->id.'.xml', 'Скачать файл') !!}
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">История заказов пуста</td>
                </tr>
            @endforelse
            </tbody>
        </table>


    </div>
@stop