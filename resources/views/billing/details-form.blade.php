@extends('layouts.account')
@section('title') Покупка тарифа @stop
@section('content')
    <h1 class="">Оплата тарифа</h1>
    {!! Form::model($detail, ['route' => ['main.billing.details-store', $payment->id], 'class' => 'new-project__form']) !!}

    <input type="submit" value="Завершить">
    {!! Form::close() !!}
@stop