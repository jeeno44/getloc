@extends('layouts.account')
@section('title') Запрос индивидуальных условий @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <h1 class="">Запрос индивидуальных условий</h1>
        {!! Form::model($user, ['route' => ['main.billing.individual-send', $site->id], 'class' => 'new-project__form']) !!}

        <label for="name-project">ФИО</label>
        {!! Form::text('name', null, ['required', 'class' => '']) !!}

        <label for="name-project">Контактный телефон</label>
        {!! Form::text('phone', null, ['class' => '']) !!}

        <label for="name-project">Контактный email</label>
        {!! Form::text('email', null, ['required', 'class' => '']) !!}

        <label for="name-project">Причина</label>
        {!! Form::textarea('text', null, ['required', 'class' => '']) !!}

        {!! Form::hidden('site_id', $site->id) !!}

        <input type="submit" value="Отправить запрос">
        {!! Form::close() !!}
    </div>
@stop