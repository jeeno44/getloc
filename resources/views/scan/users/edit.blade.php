@extends('admin.layouts.master')

@section('title')
    @if($user->hasRole('partner'))
        Редактирование партнера "{{$user->name}}"
    @else
        Редактирование пользователя "{{$user->name}}"
    @endif

@stop

@section('content')
{!! Form::model($user, ['url' => 'users/'.$user->id, 'method' => 'PUT']) !!}
<div class="block block-bordered">
    <div class="block-header">
        <h3 class="block-title">Основная информация</h3>
    </div>
    <div class="block-content">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="form-group col-sm-12 clearfix">
            <div class="col-sm-3 right-align for-label">
                <label class="form-label">Email</label>
            </div>
            <div class="col-sm-6">
                {!! Form::text('email', $user->email, ['class' => 'form-control required', 'required']) !!}
            </div>
        </div>
            <div class="form-group col-sm-12 clearfix">
                <div class="col-sm-3 right-align for-label">
                    <label class="form-label">Кол-во демо сайтов</label>
                </div>
                <div class="col-sm-6">
                    {!! Form::number('max_sites', $user->max_sites, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group col-sm-12 clearfix">
                <div class="col-sm-3 right-align for-label">
                    <label class="form-label">Контрагент?</label>
                </div>
                <div class="col-sm-6">
                    {!! Form::checkbox('is_contragent', !$user->is_contragent) !!}
                </div>
            </div>
            <div class="block-header">
                <h3 class="block-title">Реквизиты</h3>
            </div>
            <div class="block-content">
                <div class="form-group">
                    <label for="name-project">{{trans('account.t_billing_fio')}}</label>
                    {!! Form::text('contact_name', $detail->contact_name, ['class' => 'form-control']) !!}
                </div>

               <label for="name-project">{{trans('account.t_billing_con_phone')}}</label>
                {!! Form::text('contact_phone', $detail->contact_phone, ['class' => 'form-control']) !!}

                <label for="name-project">{{trans('account.t_billing_con_email')}}</label>
                {!! Form::text('contact_email', $detail->contact_email, ['class' => 'form-control']) !!}

                <label for="name-project">{{trans('account.t_billing_ur_address')}}</label>
                {!! Form::text('company_law_address', $detail->company_law_address, ['class' => 'form-control']) !!}

                <label for="name-project">{{trans('account.t_billing_post_address')}}</label>
                {!! Form::text('company_post_address', $detail->company_post_address, ['class' => 'form-control']) !!}

                <label for="name-project">{{trans('account.t_billing_name_org')}}</label>
                {!! Form::text('company_name', $detail->company_name, ['class' => 'form-control']) !!}

                <label for="name-project">{{trans('account.t_billing_inn')}}</label>
                {!! Form::text('company_inn', $detail->company_inn, ['class' => 'form-control']) !!}

                <label for="name-project">{{trans('account.t_billing_ogrn')}}</label>
                {!! Form::text('company_ogrn', $detail->company_ogrn, ['class' => 'form-control']) !!}

                <label for="name-project">{{trans('account.t_billing_name_bank')}}</label>
                {!! Form::text('company_bank_name', $detail->company_bank_name, ['class' => 'form-control']) !!}

                <label for="name-project">{{trans('account.t_billing_rs')}}</label>
                {!! Form::text('company_bank_account', $detail->company_bank_account, ['class' => 'form-control']) !!}

                <label class="site__label" for="name-project">Корреспондентский счет</label>
                {!! Form::text('company_bank_account_ks', $detail->company_bank_account_ks, ['class' => 'form-control','required']) !!}

                <label for="name-project">{{trans('account.t_billing_bik')}}</label>
                {!! Form::text('company_bank_bik', $detail->company_bank_bik, ['class' => 'form-control']) !!}

                <label for="name-project">{{trans('account.t_billing_fio_chief')}}</label>
                {!! Form::text('company_principal_name', $detail->company_principal_name, ['class' => 'form-control']) !!}

                <label for="name-project">{{trans('account.t_billing_position_chief')}}</label>
                {!! Form::text('company_principal_post', $detail->company_principal_post, ['class' => 'form-control']) !!}
            </div>
    </div>

    <div class="block-header">
        <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-check"></i> Сохранить</button>
    </div>
</div>
{!! Form::close() !!}
@stop