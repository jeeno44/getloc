@if (Auth::check())
    @if(strpos(url('/'), 'scan'))
        
        <div class="header__person header__person_scan">
            <span>{{\Auth::user()->email}}</span>
            <ul class="header__person-list">
                <li><a href="/profile">{{trans('account.t_my_profile')}}</a></li>
                {{-- @if(\App\UserDetail::where('user_id', Auth::user()->id)->count() > 0) --}}
                	<li><a href="/contragent">{{trans('account.t_contra')}}</a></li>
				{{-- @endif --}}
                <li><a href="{{URL::route('logout')}}">{{trans('account.t_exit')}}</a></li>
            </ul>
        </div>
        
    @else
        <a class="btn btn_2 btn_header btn_header-login" href="{{route('main.account')}}">{{trans('account.t_main_cabinet')}}</a>
    @endif
@else
    @if(strpos(url('/'), 'scan'))
        <a class="btn btn_2 btn_header btn_header-login" href="/login">{{trans('phrases.login')}}</a>
    @else
        <a class="btn btn_2 btn_header btn_header-login" href="/login">{{trans('phrases.login')}}</a>
    @endif
@endif