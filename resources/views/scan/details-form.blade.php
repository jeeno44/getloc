@extends('layouts.scan')
@section('title') {{trans('account.t_billing_title_buy')}} @stop
@section('content')
    <div class="inside-content" style="width: 600px; margin: 0 auto">
        <br><br>
        <h1 class="site__title">{{trans('account.contragent_data')}}</h1>
        {!! Form::model($detail, ['route' => ['scan.billing.details-store'], 'class' => 'new-project__form site__form input']) !!}

        <label for="name-project">{{trans('account.t_billing_fio')}}</label>
        {!! Form::text('contact_name', null, ['required']) !!}

        <label for="name-project">{{trans('account.t_billing_con_phone')}}</label>
        {!! Form::text('contact_phone', null, ['required']) !!}

        <label for="name-project">{{trans('account.t_billing_con_email')}}</label>
        {!! Form::text('contact_email', null, ['required']) !!}

        <label for="name-project">{{trans('account.t_billing_ur_address')}}</label>
        {!! Form::text('company_law_address', null, ['required']) !!}

        <label for="name-project">{{trans('account.t_billing_post_address')}}</label>
        {!! Form::text('company_post_address', null, ['required']) !!}

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

        <input type="submit" value="{{trans('account.save')}}">
        {!! Form::close() !!}
    </div>
@stop