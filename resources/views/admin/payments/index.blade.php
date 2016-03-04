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
                    <th>Тариф</th>
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
                            {{$item->plan->name}}
                        </td>
                        <td>
                            &#8381;{{number_format($item->sum, 0, '.', ' ') }}
                        </td>
                        <td>
                            {{$item->created_at}}
                        </td>
                        <td>
                            {!! getStatus($item->status) !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $items->render() !!}
        </div>
    </div>
@stop