@extends('layouts.index')
@section('title') {{trans('account.t_forgetpass_title')}} @stop
<!-- Main Content -->
@section('content')
    <div class="site__content  site_inner" style="margin-bottom: 400px;">
        <section class="site__wrap">
            <div class="forgot-pass">
                <h2 class="forgot-pass__title">{{trans('account.t_forgetpass_title')}}</h2>
                @if (session('status'))
                    <div class="forgot-password__message">
                        <p>{{trans('account.t_forgetpass_link_pass')}}</p>
                        <p>{{trans('account.t_forgetpass_send_email')}} <a href="mailto:{{ old('email') }}">{{ old('email') }}</a></p>
                    </div>
                @endif
                <form class="forgot-pass__form" action="{{ url('/password/email') }}" novalidate method="post">
                    <!-- forgot-pass__field -->
                    <div class="forgot-pass__field">
                        <label class="site__label" for="forgot-pass__email">{{trans('account.t_forgetpass_email')}}</label>
                        <input type="email" class="site__input" name="email" id="forgot-pass__email" required/>
                    </div>
                    <button type="submit" name="forgot-pass__send" class="btn btn_4 btn_blue btn_full-width">{{trans('account.t_forgetpass_restore')}}</button>
                </form>
            </div>
        </section>
    </div>
@endsection
