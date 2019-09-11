@extends('admin.layouts.master')

@section('title')
    Новый пользователь
@stop

@section('content')
{!! Form::open(['url' => 'admin/users/']) !!}
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
                {!! Form::text('email', null, ['class' => 'form-control required', 'required']) !!}
            </div>
        </div>
        <div class="form-group col-sm-12 clearfix">
            <div class="col-sm-3 right-align for-label">
                <label class="form-label">Имя</label>
            </div>
            <div class="col-sm-6">
                {!! Form::text('visibility_name', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group col-sm-12 clearfix">
            <div class="col-sm-3 right-align for-label">
                <label class="form-label">Телефон</label>
            </div>
            <div class="col-sm-6">
                {!! Form::text('phone', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group col-sm-12 clearfix">
            <div class="col-sm-3 right-align for-label">
                <label class="form-label">Сайт</label>
            </div>
            <div class="col-sm-6">
                {!! Form::text('site', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group col-sm-12 clearfix">
            <div class="col-sm-3 right-align for-label">
                <label class="form-label">Организация</label>
            </div>
            <div class="col-sm-6">
                {!! Form::text('company', null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="block-header">
        <h3 class="block-title">Безопасность</h3>
    </div>
    <div class="block-content">
        <div class="form-group col-sm-12 clearfix clearfix">
            <div class="col-sm-3 right-align for-label">
                <label class="form-label">Новый пароль (6+ символов) *</label>
            </div>
            <div class="col-sm-6">
                {!! Form::password('password', ['class' => 'form-control', 'required']) !!}
            </div>
        </div>

        <div class="form-group col-sm-12 clearfix clearfix">
            <div class="col-sm-3 right-align for-label">
                <label class="form-label">Подтверждение пароля *</label>
            </div>
            <div class="col-sm-6">
                {!! Form::password('password_confirmation', ['class' => 'form-control', 'required']) !!}
            </div>
        </div>
    </div>
    <div class="block-header">
        <h3 class="block-title">Роли</h3>
    </div>
    <div class="block-content">
        <div class="form-group col-sm-12 clearfix">
            <div class="col-sm-2 right-align for-label">
                <label class="form-label">Роли пользователя</label>
            </div>
            <div class="col-sm-6">
                @foreach(App\Role::all() as $role)
                    <label>
                        {!! Form::checkbox('roles[]', $role->id, false, ['class' => 'check-roles']) !!}
                        {{$role->desc}}
                    </label>
                    <br>
                @endforeach
            </div>
        </div>
    </div>
    <div class="block-header">
        <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-check"></i> Сохранить</button>
    </div>
</div>
{!! Form::close() !!}
@stop