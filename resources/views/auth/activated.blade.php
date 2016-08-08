@extends('layouts.index')
@section('title') {{trans('account.t_registr_title')}} @stop
@section('content')

    <form action="{{route('login.post')}}" class="site__form" novalidate method="post" style="margin: 60px auto; width: 400px;">
        {!! csrf_field() !!}
        <span class="site__form-title" style="color: red">Неверный код активации</span>
    </form>

@endsection
