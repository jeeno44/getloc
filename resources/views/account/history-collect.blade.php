@extends('layouts.account')

@section('title') История просчетов @stop

@section('content')
    <aside class="site__aside">
        {!! accountMenu() !!}
    </aside>
    <div class="inside-content">

        <form class="site__wrap_2" method="post">
            {!! csrf_field() !!}
            <div class="site__panel">
                <h2 class="site__title">История просчетов</h2>
            </div>
        </form>
        <div class="block-header bg-gray-lighter" style="margin: -40px 0 20px">
            <h3 class="block-title" style="float: left; margin-right: 20px">Просчетов за текущий месяц: {{$currentMonths}}</h3>
            <h3 class="block-title">Просчетов всего: {{$prevMonths}}</h3>
        </div>
        <table class="projects">
            <thead>
            <tr>
                <td>Сайт</td>
                <td>Дата просчета</td>
            </tr>
            </thead>
            @foreach($items as $item)
                <tr>
                    <td>
                        {!! $item->name !!}
                    </td>
                    <td>
                        {!! ruDate($item->created_at) !!}
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

@stop
