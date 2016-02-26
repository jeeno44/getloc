@extends('layouts.index')
@section('title') Восстановление пароля @stop
<!-- Main Content -->
@section('content')
    <div class="site__content site_inner">
        <div class="site__wrap">
            <div class="forgot-password">
                <h1 class="site__title">Восстановление пароля</h1>
                @if (session('status'))
                    <div class="forgot-password__message">
                        <p>Ссылка на восстановления пароля</p>
                        <p>отправлена на вашу эл. почту <a href="mailto:{{ old('email') }}">{{ old('email') }}</a></p>
                    </div>
                @endif
                <form role="form" method="POST" action="{{ url('/password/email') }}" novalidate="" class="site__form" _lpchecked="1">
                    {!! csrf_field() !!}
                    <fieldset class="{{ $errors->has('email') ? ' has-error invalid' : '' }}">
                        <label for="forgot-password__email">Эл. почта</label>
                        <input type="email" name="email" id="forgot-password__email" required="" value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <div class="help-block"><strong>{{ $errors->first('email') }}</strong></div>
                        @endif
                    </fieldset>
                    <button type="submit" name="forgot-password__send" class="btn btn_3">Восстановить</button>
                </form>
            </div>
        </div>
    </div>
@endsection
