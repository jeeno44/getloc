@extends('layouts.account')
@section('title') {{trans('account.t_prolong_title')}} @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <h1 class="">{{trans('account.t_prolong_title')}}</h1>
        {!! Form::open(['route' => 'main.billing.prepare', 'class' => 'new-project__form']) !!}

        <label>{{trans('account.t_prolong_tarif')}} {{$subscription->plan->name}} ({{$subscription->month_cost}}{{trans('account.t_prolong_cost')}})</label>
        {!! Form::hidden('plan_id', $subscription->plan_id, ['class' => 'billing-inp']) !!}

        <label>{{trans('account.t_prolong_expire')}}</label>
        {!! Form::select('time', getDurations(), null, ['class' => 'billing-inp']) !!}
        <br><br>

        <label>{{trans('account.t_prolong_paytype')}}</label>
        {!! Form::select('payment_type_id', $paymentTypes, null) !!}
        <br><br>

        <label>{{trans('account.t_prolong_kupon')}}</label>
        {!! Form::text('coupon', null, ['class' => 'billing-inp']) !!}
        <div id="coupon_validate"></div>
        {!! Form::hidden('site_id', $site->id, ['class' => 'billing-inp']) !!}
        <br><br>
        <div id="subtotal">

        </div>
        <input type="submit" value="{{trans('account.t_prolong_continue')}}">

        {!! Form::close() !!}
    </div>
@stop