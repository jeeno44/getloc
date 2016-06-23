@extends('layouts.account')
@section('title') {{trans('account.t_prepare_title')}} @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <h1 class="">{{trans('account.t_prepare_title')}}</h1>
        {!! Form::open(['route' => ['main.billing.store-order', 'id' => $order->id], 'class' => 'new-project__form']) !!}

        <label>{{trans('account.t_buy_tarif_paytype')}}</label>
        {!! Form::select('payment_type_id', $paymentTypes, null) !!}
        <br><br>

        <label>{{trans('account.t_buy_tarif_kupon')}}</label>
        {!! Form::text('coupon', null, ['class' => 'billing-inp']) !!}
        <div id="coupon_validate"></div>
        {!! Form::hidden('site_id', $order->site_id, ['class' => 'billing-inp']) !!}
        {!! Form::hidden('order_id', $order->id, ['class' => 'billing-inp']) !!}
        <br><br>
        <div id="order-subtotal">

        </div>
        <input type="submit" value="{{trans('account.pay')}}">
        {!! Form::close() !!}
    </div>

@stop