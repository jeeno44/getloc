@extends('admin.layouts.master')

@section('title')
    История платежей
@stop

@section('content')
    <div class="block block-bordered">
        <div class="block-content">
            <table class="table">
                <thead>
                <tr>
                    <th>Пользователь</th>
                    <th>Назначение</th>
                    <th>Сумма</th>
                    <th>Дата</th>
                    <th>Тип</th>
                    <th>Статус</th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>
                            {{$item->user->name}}
                        </td>
                        <td>
                            @if ($item->relation == 'order')
                                <a href="/admin/billing/orders/{{$item->outer_id}}">Заказ перевода № {{$item->outer_id}}</a>
                            @else
                                Подписка на тарифный план {{$item->subscription->plan->name}} для проекта {{$item->subscription->site->name}}
                            @endif
                        </td>
                        <td>
                            &#8381;{{number_format($item->sum, 0, '.', ' ') }}
                        </td>
                        <td>
                            {{date('d.m.Y H:i:s', $item->created_at)}}
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
            {!! $items->render() !!}
        </div>
    </div>
@stop