@extends('layouts.account')
@section('title') Покупка тарифа @stop
@section('content')
    <h1 class="">Оплата тарифа</h1>
    {!! Form::model($detail, ['route' => ['main.billing.details-store', $payment->id], 'class' => 'new-project__form']) !!}

    <label for="name-project">Контактное лицо</label>
    {!! Form::text('contact_name', null, ['required']) !!}

    <label for="name-project">Контактный телефон</label>
    {!! Form::text('contact_phone', null, ['required']) !!}

    <label for="name-project">Контактный email</label>
    {!! Form::text('contact_email', null, ['required']) !!}

    <label for="name-project">Юридический адрес</label>
    {!! Form::text('law_address', null, ['required']) !!}

    <label for="name-project">Почтовый адрес</label>
    {!! Form::text('post_address', null, ['required']) !!}

    <label for="name-project">Наименование организации</label>
    {!! Form::text('company_name', null, ['required']) !!}

    <label for="name-project">ИНН</label>
    {!! Form::text('company_inn', null, ['required']) !!}

    <label for="name-project">ОГРН</label>
    {!! Form::text('company_ogrn', null, ['required']) !!}

    <label for="name-project">Наименование банка</label>
    {!! Form::text('company_bank_name', null, ['required']) !!}

    <label for="name-project">Расчетный счет</label>
    {!! Form::text('company_bank_account', null, ['required']) !!}

    <label for="name-project">Бик</label>
    {!! Form::text('company_bank_bik', null, ['required']) !!}

    <label for="name-project">ФИО Руководителя</label>
    {!! Form::text('company_principal_name', null, ['required']) !!}

    <label for="name-project">Должность руководителя</label>
    {!! Form::text('company_principal_post', null, ['required']) !!}

    <input type="submit" value="Завершить">
    {!! Form::close() !!}
@stop