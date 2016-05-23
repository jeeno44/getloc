@extends('layouts.index')
@section('title') Восстановление пароля @stop
<!-- Main Content -->
@section('content')
    <div class="site__content">
        <section class="site__wrap">
            <div class="forgot-pass">
                <h2 class="forgot-pass__title">Восстановление пароля</h2>
                @if (session('status'))
                    <div class="forgot-password__message">
                        <p>Ссылка на восстановления пароля</p>
                        <p>отправлена на вашу эл. почту <a href="mailto:{{ old('email') }}">{{ old('email') }}</a></p>
                    </div>
                @endif
                <form class="forgot-pass__form" action="{{ url('/password/email') }}" novalidate method="post">
                    <!-- forgot-pass__field -->
                    <div class="forgot-pass__field">
                        <label class="site__label" for="forgot-pass__email">Эл. почта</label>
                        <input type="email" class="site__input" name="email" id="forgot-pass__email" required/>
                    </div>
                    <button type="submit" name="forgot-pass__send" class="btn btn_4 btn_blue btn_full-width">Восстановить</button>
                </form>
            </div>
        </section>
    </div>
@endsection
