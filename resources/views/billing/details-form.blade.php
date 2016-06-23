@extends('layouts.account')
@section('title') {{trans('account.t_billing_title_buy')}} @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <h1 class="">{{trans('account.t_billing_header_buy_title')}}</h1>
        {!! Form::model($detail, ['route' => ['main.billing.details-store', $payment->id], 'class' => 'new-project__form']) !!}

        <label for="name-project">{{trans('account.t_billing_fio')}}</label>
        {!! Form::text('contact_name', null, ['required']) !!}

        <label for="name-project">{{trans('account.t_billing_con_phone')}}</label>
        {!! Form::text('contact_phone', null, ['required']) !!}

        <label for="name-project">{{trans('account.t_billing_con_email')}}</label>
        {!! Form::text('contact_email', null, ['required']) !!}

        <label for="name-project">{{trans('account.t_billing_ur_address')}}</label>
        {!! Form::text('law_address', null, ['required']) !!}

        <label for="name-project">{{trans('account.t_billing_post_address')}}</label>
        {!! Form::text('post_address', null, ['required']) !!}

        <label for="name-project">{{trans('account.t_billing_name_org')}}</label>
        {!! Form::text('company_name', null, ['required']) !!}

        <label for="name-project">{{trans('account.t_billing_inn')}}</label>
        {!! Form::text('company_inn', null, ['required']) !!}

        <label for="name-project">{{trans('account.t_billing_ogrn')}}</label>
        {!! Form::text('company_ogrn', null, ['required']) !!}

        <label for="name-project">{{trans('account.t_billing_name_bank')}}</label>
        {!! Form::text('company_bank_name', null, ['required']) !!}

        <label for="name-project">{{trans('account.t_billing_rs')}}</label>
        {!! Form::text('company_bank_account', null, ['required']) !!}

        <label for="name-project">{{trans('account.t_billing_bik')}}</label>
        {!! Form::text('company_bank_bik', null, ['required']) !!}

        <label for="name-project">{{trans('account.t_billing_fio_chief')}}</label>
        {!! Form::text('company_principal_name', null, ['required']) !!}

        <label for="name-project">{{trans('account.t_billing_position_chief')}}</label>
        {!! Form::text('company_principal_post', null, ['required']) !!}

        <input type="submit" value="{{trans('account.t_billing_complete')}}">
        {!! Form::close() !!}
    </div>
@stop