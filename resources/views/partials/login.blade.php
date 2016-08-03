@if (Auth::check())
    @if(strpos(url('/'), 'scan'))

    @else
        <a class="btn btn_header btn_header-login" href="{{route('main.account')}}">{{trans('account.t_main_cabinet')}}</a>
    @endif
@else
    <a class="btn btn_header btn_header-login popup__open" data-popup="login">{{trans('phrases.login')}}</a>
@endif