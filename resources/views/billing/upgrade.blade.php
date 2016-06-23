@extends('layouts.account')
@section('title') {{trans('account.t_upgrade_title')}} @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <h1 class="">{{trans('account.t_upgrade_title')}}</h1>
        {!! Form::open(['route' => 'main.billing.upgrade-store', 'class' => 'new-project__form']) !!}

        <label>{{trans('account.t_upgrade_tarif')}}</label>
        {!! Form::select('plan_id', $plans, null) !!}
        <br>
        {!! Form::hidden('site_id', $site->id, ['class' => 'billing-inp']) !!}
        <br>
        <input type="submit" value="{{trans('account.t_upgrade_continue')}}">

        {!! Form::close() !!}
    </div>
@stop