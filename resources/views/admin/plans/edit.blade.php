@extends('admin.layouts.master')

@section('title')
    Редакирование тарифного плана "{{$item->name}}"

@stop

@section('content')
{!! Form::model($item, ['url' => 'admin/billing/plans/'.$item->id, 'method' => 'PUT']) !!}
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
                <label class="form-label">Стоимость *</label>
            </div>
            <div class="col-sm-6">
                {!! Form::number('cost', null, ['class' => 'form-control', 'required']) !!}
            </div>
        </div>
        <div class="form-group col-sm-12 clearfix">
            <div class="col-sm-3 right-align for-label">
                <label class="form-label">Макс. слов *</label>
            </div>
            <div class="col-sm-6">
                {!! Form::number('count_words', null, ['class' => 'form-control', 'required']) !!}
            </div>
        </div>
        <div class="form-group col-sm-12 clearfix">
            <div class="col-sm-3 right-align for-label">
                <label class="form-label">Макс. языков *</label>
            </div>
            <div class="col-sm-6">
                {!! Form::number('count_languages', null, ['class' => 'form-control', 'required']) !!}
            </div>
        </div>
        <div class="form-group col-sm-12 clearfix">
            <div class="col-sm-3 right-align for-label">
                <label class="form-label">Whitelabel виджета</label>
            </div>
            <div class="col-sm-6">
                {!! Form::checkbox('white_label', 1) !!}
            </div>
        </div>
    </div>
    <div class="block-header">
        <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-check"></i> Сохранить</button>
    </div>
</div>
{!! Form::close() !!}
@stop