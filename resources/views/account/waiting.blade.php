@extends('layouts.account')
@section('title') {{trans('account.t_waiting_title')}} @stop
@section('content')
    <div class="inside-content" style="width: 100% !important; width: 100%;">
        <div class="site-analysis inside-content__wrap">
            <div class="site-analysis__status">{{trans('account.t_waiting_text1')}}</div>
            {{trans('account.t_waiting_text2')}}
        </div>
    </div>
@stop