@extends('admin.layouts.master')

@section('title')
    Заказы
@stop

@section('content')
    <div class="block block-bordered">
        <div class="block-content">
            <table class="table">
                <thead>
                <tr>
                    <th>Пользователь</th>
                    <th>Сумма</th>
                    <th>Дата</th>
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
                            &#8381;{{number_format($item->payment_sum, 0, '.', ' ') }}
                        </td>
                        <td>
                            {{date('d.m.Y H:i:s', strtotime($item->created_at))}}
                        </td>
                        <td>
                            {!! getOrderStatus($item->status) !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $items->render() !!}
        </div>
    </div>
@stop