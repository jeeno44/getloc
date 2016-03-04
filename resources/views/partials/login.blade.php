@if (Auth::check())
    <a class="btn btn_header btn_header-login" href="{{route('main.account')}}">Кабинет</a>
@else
    <a class="btn btn_header btn_header-login popup__open" data-popup="login">{{trans('phrases.login')}}</a>
@endif