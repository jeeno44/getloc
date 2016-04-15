@extends('layouts.account')
@section('title') Изменение тарифа @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <h1 class="">Изменение тарифа</h1>
        {!! Form::open(['route' => 'main.billing.upgrade-store', 'class' => 'new-project__form']) !!}

        <label>Тариф *</label>
        {!! Form::select('plan_id', $plans, null) !!}
        <br>
        {!! Form::hidden('site_id', $site->id, ['class' => 'billing-inp']) !!}
        <br>
        <input type="submit" value="Продолжить">

        {!! Form::close() !!}
    </div>
@stop