@extends('layouts.account')
@section('title') Покупка тарифа @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <h1 class="">Покупка тарифа</h1>
        {!! Form::open(['route' => 'main.billing.prepare', 'class' => 'new-project__form']) !!}

        <label>Тариф *</label>
        {!! Form::select('plan_id', $plans, null, ['class' => 'billing-inp']) !!}
        <p>или <a href="{{route('main.billing.individual', ['id' => $site->id])}}">запросить индвидидуальные условия</a> </p>
        <br>

        <label>Срок *</label>
        {!! Form::select('time', getDurations(), null, ['class' => 'billing-inp']) !!}
        <br><br>

        <label>Способ оплаты *</label>
        {!! Form::select('payment_type_id', $paymentTypes, null) !!}
        <br><br>

        <label>Купон</label>
        {!! Form::text('coupon', null, ['class' => 'billing-inp']) !!}
        <div id="coupon_validate"></div>
        {!! Form::hidden('site_id', $site->id, ['class' => 'billing-inp']) !!}
        <br><br>
        <div id="subtotal">

        </div>
        <input type="submit" value="Продолжить">

        {!! Form::close() !!}
    </div>
@stop