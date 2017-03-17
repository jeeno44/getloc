@extends('admin.layouts.master')

@section('title')
    Контроль просчетов
@stop

@section('content')
    <div class="block block-bordered">

        <div class="block-content">
            <div class="row">
                <div class="col-sm-6 col-lg-6">
                    <div class="block block-bordered">
                        <div class="block-header bg-gray-lighter">
                            <h3 class="block-title">Просчетов за текущий месяц</h3>
                        </div>
                        <div class="block-content">
                            <p>
                                <a href="?from={{$startCurrentMonth}}&to={{date('Y-m-d H:i:s')}}">{{$currentMonths}}</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <div class="block block-bordered">
                        <div class="block-header bg-gray-lighter">
                            <h3 class="block-title">Просчетов за прошлый месяц</h3>
                        </div>
                        <div class="block-content">
                            <p>
                                <a href="?from={{$startPrevMonth}}&to={{$startCurrentMonth}}">{{$prevMonths}}</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>Сайт</th>
                    <th>Пользователь</th>
                    <th>Дата</th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>
                            {{$item->name}}
                        </td>
                        <td>
                            {{$item->user->email}}
                        </td>
                        <td>
                            {{ruDate($item->created_at)}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $items->render() !!}
        </div>
    </div>
@stop