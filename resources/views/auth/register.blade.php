@extends('layouts.index')

@section('content')

    <div class="site__content site_inner">
        <div class="site__wrap">
            <div class="forgot-password">
                <h1 class="site__title">Регистрация</h1>
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                    {!! csrf_field() !!}
                    <fieldset class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label>Эл. почта</label>
                        <input type="email" class="form-control" name="email" id="forgot-password__email" value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                        @endif
                    </fieldset>
                    <fieldset class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Password</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </fieldset>
                    <fieldset class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Confirm Password</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password_confirmation">
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </fieldset>
                    <button type="submit" name="forgot-password__send" class="btn btn_3">Восстановить</button>
                </form>
            </div>
        </div>
    </div>
@endsection
