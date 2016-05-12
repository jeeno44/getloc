@extends('admin.layouts.master')

@section('title')
    Редакирование языка "{{$item->name}}"

@stop

@section('content')
{!! Form::model($item, ['url' => 'admin/settings/languages/'.$item->id, 'method' => 'PUT']) !!}
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
                    <label class="form-label">Название *</label>
                </div>
                <div class="col-sm-6">
                    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>
            <div class="form-group col-sm-12 clearfix">
                <div class="col-sm-3 right-align for-label">
                    <label class="form-label">Локализованное название *</label>
                </div>
                <div class="col-sm-6">
                    {!! Form::text('original_name', null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>
            <div class="form-group col-sm-12 clearfix">
                <div class="col-sm-3 right-align for-label">
                    <label class="form-label">Код *</label>
                </div>
                <div class="col-sm-6">
                    {!! Form::text('short', null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>
            <div class="form-group col-sm-12 clearfix">
                <div class="col-sm-3 right-align for-label">
                    <label class="form-label">Стоимость слова *</label>
                </div>
                <div class="col-sm-6">
                    {!! Form::text('word_cost', null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>
            <div class="form-group col-sm-12 clearfix">
                <div class="col-sm-3 right-align for-label">
                    <label class="form-label">Иконка (файл в папке icons) *</label>
                </div>
                <div class="col-sm-6">
                    {!! Form::text('icon_file', null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>
    </div>
    <div class="block-header">
        <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-check"></i> Сохранить</button>
    </div>
</div>
{!! Form::close() !!}
@stop