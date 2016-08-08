@extends('layouts.index')
@section('title') {{trans('account.t_registr_title')}} @stop
@section('content')
    <form action="" class="site__form" novalidate method="post" style="margin: 60px auto; width: 400px;">
        <span class="site__form-title">Благодарим вас за регистрацию. Для начала работы с сервисом перейдите по ссылке и подтвердите адрес электронной почты</span>
    </form>
@endsection
