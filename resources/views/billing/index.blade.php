@extends('layouts.account')
@section('title') Тарифные планы @stop
@section('content')
    <h1 class="site__title title_project">Тарифные планы</h1>
    @if($activity)
        <p style="text-align: center; font-weight: bold">Ваш тарифный план {{$subscription->plan->name}} до {{$subscription->ends_at}}<br><br></p>
        @foreach($plans as $plan)
            <div>
                <p><strong>Тариф: </strong>{{$plan->name}}</p>
                <p><strong>Стоимость: </strong>{{$plan->cost}}</p>
                <p><strong>Слов: </strong>{{$plan->count_words}}</p>
                <p><strong>Языков: </strong>{{$plan->count_languages}}</p>
                <p><strong>whitelabel виджета: </strong>{{$plan->white_label}}</p>
                @if ($subscription->plan_id != $plan->id)
                    <p><a class="btn btn-success" href="{{route('main.billing.upgrade', ['planId' => $plan->id])}}">Перейти на тарифный план</a> </p>
                @endif
            </div>
            <hr>
        @endforeach
    @else
        @foreach($plans as $plan)
            <div>
                <p><strong>Тариф: </strong>{{$plan->name}}</p>
                <p><strong>Стоимость: </strong>{{$plan->cost}}</p>
                <p><strong>Слов: </strong>{{$plan->count_words}}</p>
                <p><strong>Языков: </strong>{{$plan->count_languages}}</p>
                <p><strong>whitelabel виджета: </strong>{{$plan->white_label}}</p>
                <p><a class="btn btn-success" href="{{route('main.billing.prepare', ['planId' => $plan->id])}}">Оплатить</a> </p>
            </div>
            <hr>
        @endforeach
    @endif
@stop