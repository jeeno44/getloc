@extends('admin.layouts.master')

@section('title')
    Новый купон
@stop

@section('content')
{!! Form::open(['url' => 'admin/billing/coupons']) !!}
<div class="block block-bordered">
    <div class="block-header">
        <h3 class="block-title">Новый купон</h3>
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
                    <label class="form-label">Код</label>
                </div>
                <div class="col-sm-6">
                    {!! Form::text('code', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group col-sm-12 clearfix">
                <div class="col-sm-3 right-align for-label">
                    <label class="form-label">Скидка *</label>
                </div>
                <div class="col-sm-6">
                    {!! Form::number('discount', null, ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="col-sm-2">
                    {!! Form::radio('is_percent', 1, null, ['required']) !!}
                    <label>процентов</label>
                    <br>
                    {!! Form::radio('is_percent', 0, null, ['required']) !!}
                    <label>рублей</label>
                </div>
            </div>
            <div class="form-group col-sm-12 clearfix">
                <div class="col-sm-3 right-align for-label">
                    <label class="form-label">Тип</label>
                </div>
                <div class="col-sm-6">
                    {!! Form::select('type', getCouponTypes(), null, ['class' => 'form-control']) !!}
                    <script>
                        $(function () {
                            $('select').change(function () {
                                if ($(this).val() == 'fixed') {
                                    $('.date').removeClass('hidden');
                                } else {
                                    $('.date').addClass('hidden');
                                }
                            })
                        });
                    </script>
                    <div class="hidden date">
                        <br>
                        {!! Form::text('ends_at', null, ['class' => 'js-datepicker form-control', 'id' => 'example-datetimepicker1']) !!}
                    </div>
                </div>
            </div>

    </div>
    <div class="block-header">
        <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-check"></i> Сохранить</button>
    </div>
</div>
{!! Form::close() !!}
@stop