@extends('admin.layouts.master')

@section('title')
    Настройки
@stop

@section('content')
    {!! Form::open(['url' => 'admin/settings']) !!}
    <div class="block block-bordered">
        <div class="block-header">
            <h3 class="block-title">Основные настройки</h3>
        </div>
        <div class="block-content">
            @foreach($options as $opt)
                @if ($opt->key != 'stop_words')
                    <div class="form-group col-sm-12 clearfix">
                        <div class="col-sm-3 right-align for-label">
                            <label class="form-label">{{$opt->name}}</label>
                        </div>
                        <div class="col-sm-6">
                            {!! Form::text($opt->key, $opt->val, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                @endif

            @endforeach
        </div>
        <div class="block-header">
            <h3 class="block-title">Безопасность</h3>
        </div>
        <div class="block-content">
            <div class="form-group col-sm-12 clearfix clearfix">
                <div class="col-sm-3 right-align for-label">
                    <label class="form-label">Новый пароль администратора</label>
                </div>
                <div class="col-sm-6">
                    {!! Form::password('password', ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group col-sm-12 clearfix clearfix">
                <div class="col-sm-3 right-align for-label">
                    <label class="form-label">Подтверждение пароля</label>
                </div>
                <div class="col-sm-6">
                    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="block-header">
            <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-check"></i> Сохранить</button>
        </div>
    </div>

    {!! Form::close() !!}
@stop