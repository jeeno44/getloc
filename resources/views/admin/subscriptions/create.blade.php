@extends('admin.layouts.master')

@section('title')
    Новая подписка
@stop

@section('content')
{!! Form::open(['url' => 'admin/billing/subscriptions']) !!}
<div class="block block-bordered">
    <div class="block-header">
        <h3 class="block-title">Новая подписка</h3>
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
                    <label class="form-label">Сайт *</label>
                </div>
                <div class="col-sm-6">
                    {!! Form::select('site_id', $sites, null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>

            <div class="form-group col-sm-12 clearfix">
                <div class="col-sm-3 right-align for-label">
                    <label class="form-label">Тарифный план *</label>
                </div>
                <div class="col-sm-6">
                    {!! Form::select('plan_id', $plans, null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>

            <div class="form-group col-sm-12 clearfix">
                <div class="col-sm-3 right-align for-label">
                    <label class="form-label">Стоимость (в месяц) *</label>
                </div>
                <div class="col-sm-6">
                    {!! Form::number('month_cost', null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>

            <div class="form-group col-sm-12 clearfix">
                <div class="col-sm-3 right-align for-label">
                    <label class="form-label">Депозит</label>
                </div>
                <div class="col-sm-6">
                    {!! Form::number('deposit', 0.00, ['class' => 'form-control', 'required']) !!}
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

    </div>
    <div class="block-header">
        <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-check"></i> Сохранить</button>
    </div>
</div>
{!! Form::close() !!}
@stop