@extends('layouts.account')
@section('title') {{trans('account.t_buy_tarif_title')}} @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <h1 class="">{{trans('account.t_buy_tarif_title')}}</h1>
        <div style="float: right"><a href="{{URL::previous()}}">{{trans('account.t_buy_tarif_back')}}</a> </div>
        {!! Form::open(['route' => 'main.billing.prepare', 'class' => 'new-project__form']) !!}

        <label>{{trans('account.t_buy_tarif_tarif')}}</label>
        {!! Form::select('plan_id', $plans, Request::get('plan_id'), ['class' => 'billing-inp']) !!}
        <p>{{trans('account.t_buy_tarif_or')}} <a href="{{route('main.billing.individual', ['id' => $site->id])}}">{{trans('account.t_buy_tarif_req_indiv')}}</a> </p>
        <br>

        <label>{{trans('account.t_buy_tarif_expir')}}</label>
        {!! Form::select('time', getDurations(), Request::get('time'), ['class' => 'billing-inp']) !!}
        <br><br>

        <label>{{trans('account.t_buy_tarif_paytype')}}</label>
        {!! Form::select('payment_type_id', $paymentTypes, null) !!}
        <br><br>

        <label>{{trans('account.t_buy_tarif_kupon')}}</label>
        {!! Form::text('coupon', null, ['class' => 'billing-inp']) !!}
        <div id="coupon_validate"></div>
        {!! Form::hidden('site_id', $site->id, ['class' => 'billing-inp']) !!}
        <br><br>
        <div id="subtotal">

        </div>
        <input type="submit" value="{{trans('account.t_buy_tarif_continue')}}">

        {!! Form::close() !!}
    </div>
@stop