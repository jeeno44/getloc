@extends('layouts.index')
@section('title') {{trans('account.t_login_title')}} @stop
@section('content')

    <form action="{{route('login.post')}}" class="site__form" novalidate method="post" style="margin: 0 auto; width: 400px;">
        {!! csrf_field() !!}
        <span class="site__form-title">{{trans('account.t_login_title')}}</span>
        <fieldset>
            <label for="email">{{trans('account.t_login_email')}}</label>
            <input type="email" id="email" required name="email">
            @if ($errors->has('email'))
                <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
            @endif
        </fieldset>
        <fieldset>
            <label>{{trans('account.t_login_pass')}}</label>
            <input type="password" required name="password">
            @if ($errors->has('password'))
                <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
            @endif
        </fieldset>
        <button type="submit" class="btn btn_enroll">{{trans('account.t_login_enter')}}</button>
        <a href="{{route('password.reset.form')}}" class="site__form-forgot">{{trans('account.t_login_forget_pass')}}</a>
    </form>
    <div class="popup__social"  style="margin: 0 auto; width: 400px;">
        {{trans('account.t_login_social')}}
        <div class="social-2">
            <a href="{{route('facebook.redirect')}}" class="social-2__fb">facebook</a>
            <a href="{{route('twitter.redirect')}}" class="social-2__tw">twitter</a>
            <a href="{{route('google.redirect')}}" class="social-2__google">google</a>
        </div>
    </div>

@endsection
