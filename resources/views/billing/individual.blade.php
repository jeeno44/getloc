@extends('layouts.account')
@section('title') {{trans('account.t_individual_title')}} @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <h1 class="">{{trans('account.t_individual_title')}}</h1>
        {!! Form::model($user, ['route' => ['main.billing.individual-send', $site->id], 'class' => 'new-project__form']) !!}

        <label for="name-project">{{trans('account.')}}</label>
        {!! Form::text('name', null, ['required', 'class' => '']) !!}

        <label for="name-project">{{trans('account.t_individual_phone')}}</label>
        {!! Form::text('phone', null, ['class' => '']) !!}

        <label for="name-project">{{trans('account.t_individual_email')}}</label>
        {!! Form::text('email', null, ['required', 'class' => '']) !!}

        <label for="name-project">{{trans('account.t_individual_reason')}}</label>
        {!! Form::textarea('text', null, ['required', 'class' => '']) !!}

        {!! Form::hidden('site_id', $site->id) !!}

        <input type="submit" value="{{trans('account.t_individual_request_send')}}">
        {!! Form::close() !!}
    </div>
@stop