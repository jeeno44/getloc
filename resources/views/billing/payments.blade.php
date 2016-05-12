@extends('layouts.account')
@section('title') История платежей @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <div class="block block-bordered">
            <div class="block-content">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Назначение</th>
                        <th>Сумма</th>
                        <th>Дата</th>
                        <th>Тип</th>
                        <th>Статус</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($payments as $item)
                        <tr>
                            <td>
                                @if ($item->relation == 'App\Order')
                                    Заказ перевода № {{$item->outer_id}}
                                @else
                                    @if(!empty($item->subscription->plan->name) && !empty($item->subscription->site->name))
                                        Подписка на тарифный план {{$item->subscription->plan->name}} для проекта {{$item->subscription->site->name}}
                                    @else
                                        Оплата подписки (проект или подписка удалены)
                                    @endif

                                @endif
                            </td>
                            <td>
                                &#8381;{{number_format($item->sum, 1, '.', ' ') }}
                            </td>
                            <td>
                                {{date('d.m.Y H:i', strtotime($item->created_at))}}
                            </td>
                            <td>
                                {{$item->type->name}}
                            </td>
                            <td>
                                {!! getPaymentStatus($item->status) !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop