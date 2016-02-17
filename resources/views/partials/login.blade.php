@if (Auth::check())
    <div class="header__person btn btn_header" style="background-image: url('/assets/img/iocns-ava.png');">
        <ul class="header__person-list">
            <li><a href="#">Персональные данные</a></li>
            <li><a href="#">Настройка аккаунта</a></li>
            <li><a href="#">Настройка команды</a></li>
            <li><a href="{{route('logout')}}">Выйти</a></li>
        </ul>
    </div>
@else
    <a class="btn btn_header btn_header-login popup__open" data-popup="login">{{trans('phrases.login')}}</a>
@endif