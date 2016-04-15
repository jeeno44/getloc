@extends('layouts.account')
@section('title') Оплата заказа @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <h1 class="">Оплата заказа</h1>
        {!! Form::open(['route' => ['main.billing.store-order', 'id' => $order->id], 'class' => 'new-project__form']) !!}

        <label>Способ оплаты *</label>
        {!! Form::select('payment_type_id', $paymentTypes, null) !!}
        <br><br>

        <label>Купон</label>
        {!! Form::text('coupon', null, ['class' => 'billing-inp']) !!}
        <div id="coupon_validate"></div>
        {!! Form::hidden('site_id', $order->site_id, ['class' => 'billing-inp']) !!}
        {!! Form::hidden('order_id', $order->id, ['class' => 'billing-inp']) !!}
        <br><br>
        <div id="order-subtotal">

        </div>
        <input type="submit" value="Оплатить">
        {!! Form::close() !!}
    </div>

@stop