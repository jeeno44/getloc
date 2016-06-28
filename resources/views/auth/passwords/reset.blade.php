@extends('layouts.index')
@section('title') {{trans('account.t_resetpass_title')}} @stop
@section('content')
    <div class="site__content site_inner">
        <div class="site__wrap">
            <div class="forgot-password">
                <h1 class="site__title">{{trans('account.t_resetpass_title')}}</h1>
                <form role="form" method="POST" action="{{ url('/password/reset') }}" novalidate="" class="site__form" _lpchecked="1">
                    {!! csrf_field() !!}
                    <input type="hidden" name="token" value="{{ $token }}">
                    <fieldset class="{{ $errors->has('email') ? ' has-error invalid' : '' }}">
                        <label for="forgot-password__email">{{trans('account.t_forgetpass_email')}}</label>
                        <input type="email" name="email" id="forgot-password__email" required="" value="{{ $email or old('email') }}">
                        @if ($errors->has('email'))
                            <div class="help-block"><strong>{{ $errors->first('email') }}</strong></div>
                        @endif
                    </fieldset>
                    <fieldset class="{{ $errors->has('password') ? ' has-error invalid' : '' }}">
                        <label>{{trans('account.t_login_pass')}}</label>
                        <input type="password" name="password" required="">
                        @if ($errors->has('password'))
                            <div class="help-block"><strong>{{ $errors->first('password') }}</strong></div>
                        @endif
                    </fieldset>
                    <fieldset class="{{ $errors->has('password') ? ' has-error invalid' : '' }}">
                        <label>{{trans('account.t_resetpass_pass2')}}</label>
                        <input type="password" name="password_confirmation" required="">
                        @if ($errors->has('password_confirmation'))
                            <div class="help-block"><strong>{{ $errors->first('password_confirmation') }}</strong></div>
                        @endif
                    </fieldset>
                    <button type="submit" name="forgot-password__send" class="btn btn_3">{{trans('account.t_resetpass_reset')}}</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
