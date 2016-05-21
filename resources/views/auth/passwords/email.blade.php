@extends('layouts.index')
@section('title') Восстановление пароля @stop
<!-- Main Content -->
@section('content')
    <div class="forgot-pass">
        <h2 class="site__title site__title_center">Восстановление пароля</h2>
        @if (session('status'))
            <div class="forgot-password__message">
                <p>Ссылка на восстановления пароля</p>
                <p>отправлена на вашу эл. почту <a href="mailto:{{ old('email') }}">{{ old('email') }}</a></p>
            </div>
        @endif
        <form class="forgot-pass__form" novalidate method="POST" action="{{ url('/password/email') }}">
            <!-- site__data-field -->
            <div class="site__data-field">
                <label class="site__label" for="forgot-pass__email">Эл. почта</label>
                <input type="email" class="site__input" name="forgot-pass__email" id="forgot-pass__email" required/>
                @if ($errors->has('email'))
                    <div class="help-block"><strong>{{ $errors->first('email') }}</strong></div>
                @endif
            </div>
            <!-- /site__data-field -->
            <button type="submit" name="forgot-pass__send" class="btn btn_9 btn_blue btn_full-width">Восстановить</button>
        </form>
    </div>
@endsection
