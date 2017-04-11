@extends('admin.layouts.master')

@section('title')
    Пользователь "{{$user->name}}"

@stop

@section('content')
{!! Form::model($user, ['url' => 'admin/users/'.$user->id, 'method' => 'PUT']) !!}
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
                {{$user->email}}
            </div>
        </div>
        <div class="form-group col-sm-12 clearfix">
            <div class="col-sm-3 right-align for-label">
                <label class="form-label">Имя</label>
            </div>
            <div class="col-sm-6">
                {{$user->visibility_name}}
            </div>
        </div>
        <div class="form-group col-sm-12 clearfix">
            <div class="col-sm-3 right-align for-label">
                <label class="form-label">Телефон</label>
            </div>
            <div class="col-sm-6">
                {{$user->phone}}
            </div>
        </div>
        <div class="form-group col-sm-12 clearfix">
            <div class="col-sm-3 right-align for-label">
                <label class="form-label">Сайт</label>
            </div>
            <div class="col-sm-6">
                {{$user->site}}
            </div>
        </div>
        <div class="form-group col-sm-12 clearfix">
            <div class="col-sm-3 right-align for-label">
                <label class="form-label">Организация</label>
            </div>
            <div class="col-sm-6">
                {{$user->company}}
            </div>
        </div>
    </div>
    @if(!empty($user->detail))
    <div class="block-header">
        <h3 class="block-title">Информация контрагента</h3>
    </div>
        <div class="block-content">
            <div class="form-group col-sm-12 clearfix">
                <div class="col-sm-3 right-align for-label">
                    <label class="form-label">{{trans('account.t_billing_fio')}}</label>
                </div>
                <div class="col-sm-6">
                    {{$user->detail->contact_name}}
                </div>
            </div>

            <div class="form-group col-sm-12 clearfix">
                <div class="col-sm-3 right-align for-label">
                    <label class="form-label">{{trans('account.t_billing_con_phone')}}</label>
                </div>
                <div class="col-sm-6">
                    {{$user->detail->contact_phone}}
                </div>
            </div>

            <div class="form-group col-sm-12 clearfix">
                <div class="col-sm-3 right-align for-label">
                    <label class="form-label">{{trans('account.t_billing_con_email')}}</label>
                </div>
                <div class="col-sm-6">
                    {{$user->detail->contact_email}}
                </div>
            </div>

            <div class="form-group col-sm-12 clearfix">
                <div class="col-sm-3 right-align for-label">
                    <label class="form-label">{{trans('account.t_billing_ur_address')}}</label>
                </div>
                <div class="col-sm-6">
                    {{$user->detail->company_post_address}}
                </div>
            </div>

            <div class="form-group col-sm-12 clearfix">
                <div class="col-sm-3 right-align for-label">
                    <label class="form-label">Юридический адрес</label>
                </div>
                <div class="col-sm-6">
                    {{$user->detail->company_law_address}}
                </div>
            </div>

            <div class="form-group col-sm-12 clearfix">
                <div class="col-sm-3 right-align for-label">
                    <label class="form-label">Наименование компании</label>
                </div>
                <div class="col-sm-6">
                    {{$user->detail->company_name}}
                </div>
            </div>

            <div class="form-group col-sm-12 clearfix">
                <div class="col-sm-3 right-align for-label">
                    <label class="form-label">Банковский счет</label>
                </div>
                <div class="col-sm-6">
                    {{$user->detail->company_bank_account}}
                </div>
            </div>

            <div class="form-group col-sm-12 clearfix">
                <div class="col-sm-3 right-align for-label">
                    <label class="form-label">Бик банка</label>
                </div>
                <div class="col-sm-6">
                    {{$user->detail->company_bank_bik}}
                </div>
            </div>

            <div class="form-group col-sm-12 clearfix">
                <div class="col-sm-3 right-align for-label">
                    <label class="form-label">ОГРН компании</label>
                </div>
                <div class="col-sm-6">
                    {{$user->detail->company_ogrn}}
                </div>
            </div>

            <div class="form-group col-sm-12 clearfix">
                <div class="col-sm-3 right-align for-label">
                    <label class="form-label">Должность директора</label>
                </div>
                <div class="col-sm-6">
                    {{$user->detail->company_principal_post}}
                </div>
            </div>

            <div class="form-group col-sm-12 clearfix">
                <div class="col-sm-3 right-align for-label">
                    <label class="form-label">ФИО Директора</label>
                </div>
                <div class="col-sm-6">
                    {{$user->detail->company_principal_name}}
                </div>
            </div>

            <div class="form-group col-sm-12 clearfix">
                <div class="col-sm-3 right-align for-label">
                    <label class="form-label">Наименование банка</label>
                </div>
                <div class="col-sm-6">
                    {{$user->detail->company_bank_name}}
                </div>
            </div>

            <div class="form-group col-sm-12 clearfix">
                <div class="col-sm-3 right-align for-label">
                    <label class="form-label">ИНН Компании</label>
                </div>
                <div class="col-sm-6">
                    {{$user->detail->company_inn}}
                </div>
            </div>

            <div class="form-group col-sm-12 clearfix">
                <div class="col-sm-3 right-align for-label">
                    <label class="form-label">Корреспонденсткий счет</label>
                </div>
                <div class="col-sm-6">
                    {{$user->detail->company_bank_account_ks}}
                </div>
            </div>


        </div>
    @endif
    <div class="block-header">

    </div>
</div>
{!! Form::close() !!}
@stop