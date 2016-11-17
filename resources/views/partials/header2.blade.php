{{--<header class="site__header">--}}
    {{--<div class="site__header-layout">--}}
        {{--<h1 class="logo">--}}
            {{--<img src="assets/new/img/logo.png" alt="getloc"/>--}}
        {{--</h1>--}}
        {{--<div class="site__control">--}}
            {{--<div class="mobile-menu-btn">--}}
                {{--<span></span>--}}
            {{--</div>--}}
            {{--<div class="mobile-menu">--}}
                {{--<nav class="menu">--}}
                    {{--<a href="#" class="menu__item">Возможности</a>--}}
                    {{--<a href="#" class="menu__item">Цены</a>--}}
                {{--</nav>--}}
                {{--<a href="#" class="btn btn_2">Войти</a>--}}
            {{--</div>--}}
            {{--<div class="language">--}}
                {{--<span class="language__active">RU</span>--}}
                {{--<ul class="language__popup">--}}
                    {{--<li><a href="#" class="language__item">Русский</a></li>--}}
                    {{--<li><a href="#" class="language__item active">English</a></li>--}}
                    {{--<li><a href="#" class="language__item">Deutch</a></li>--}}
                {{--</ul>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</header>--}}



@if (!empty($route) && $route == 'main')
    <header class="site__header">
        <div class="site__header-layout">
            <h1 class="logo">
                <img src="assets/new/img/logo.png" alt="getloc"/>
            </h1>
            <div class="site__control">
                <div class="mobile-menu-btn">
                    <span></span>
                </div>
                <div class="mobile-menu">
                    <nav class="menu">
                        <a href="{{route('main.feature')}}" class="menu__item">{{trans('phrases.capabilities')}}</a>
                        @if (\Auth::check() && \App\User::find(\Auth::user()->id)->hasRole('show_stat') )
                            <a href="{{route('scan.main')}}" class="menu__item">{{trans('phrases.analytics')}}</a>
                        @endif
                    </nav>
                    {{--<a href="#" class="btn btn_2">Войти</a>--}}
                    @include('partials.login2')
                </div>
                <div class="language">
                    <span class="language__active">{{strtoupper($locale)}}</span>
                    <ul class="language__popup">
                        <li><a href="/ru" class="language__item">Русский</a></li>
                        <li><a href="/en" class="language__item">English</a></li>
                        {{--<li><a href="#" class="language__item">Deutch</a></li>--}}
                    </ul>
                </div>
            </div>
        </div>
    </header>


    {{--<header class="site__header">--}}
        {{--<div class="site__header-layout">--}}
            {{--<h1 class="logo anchor" data-href="#up">--}}
                {{--<img src="/assets/new/img/logo.png" width="90" height="26" alt="getLoc">--}}
            {{--</h1>--}}
            {{--<div class="site__header-inner">--}}
                {{--<nav class="header__menu">--}}
                    {{--<a href="{{route('main.feature')}}">{{trans('phrases.capabilities')}}</a>--}}
                    {{--@if (\Auth::check() && \App\User::find(\Auth::user()->id)->hasRole('show_stat') )--}}
                    {{--<a href="{{route('scan.main')}}">{{trans('phrases.analytics')}}</a>--}}
                    {{--@endif--}}
                {{--</nav>--}}
                {{--@include('partials.login')--}}
                {{--<div class="language">--}}
                    {{--<button class="language__btn">{{strtoupper($locale)}}</button>--}}
                    {{--<ul class="language__list">--}}
                        {{--<li><a href="/ru">Русский</a></li>--}}
                        {{--<li><a href="/en">English</a></li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</header>--}}
@elseif (!empty($route) && $route == 'main.feature')
    <header class="site__header ">
        <div class="site__header-layout">
            <a href="{{route('main')}}" class="logo">
                <img src="/assets/img/logo.png" width="90" height="26" alt="getLoc">
            </a>
            <div class="site__header-inner">
                <nav class="header__menu">
                    <a href="{{route('main.feature')}}" class="active">{{trans('phrases.capabilities')}}</a>
                    @if (\Auth::check() && \App\User::find(\Auth::user()->id)->hasRole('show_stat') )
                    <a href="{{route('scan.main')}}">{{trans('phrases.analytics')}}</a>
                    @endif
                </nav>
                @include('partials.login')
                <div class="language">
                    <button class="language__btn">{{strtoupper($locale)}}</button>
                    <ul class="language__list">
                        <li><a href="/ru">Русский</a></li>
                        <li><a href="/en">English</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
@else
    <header class="site__header site__header_not-logged">
        <div class="site__header-layout">
            @if(strpos(url('/'), 'scan'))
                <a href="{{route('scan.main')}}" class="logo">
                    <img src="/assets/img/logo.png" width="90" height="26" alt="getLoc">
                </a>
            @else
                <a href="{{route('main')}}" class="logo">
                    <img src="/assets/img/logo.png" width="90" height="26" alt="getLoc">
                </a>
            @endif

            <div class="site__header-inner">
	            @if(!strpos(url('/'), 'scan'))
                	<nav class="header__menu">
                    
                        <a href="{{route('main.feature')}}">{{trans('phrases.capabilities')}}</a>
                        @if (\Auth::check() && \App\User::find(\Auth::user()->id)->hasRole('show_stat') )
                            <a href="{{route('scan.main')}}">{{trans('phrases.analytics')}}</a>
                        @endif
                   
                	</nav>
                @endif
                @include('partials.login')
                @if(!strpos(url('/'), 'scan'))
	                <div class="language">
	                    <button class="language__btn">{{strtoupper($locale)}}</button>
	                    <ul class="language__list">
	                        <li><a href="/ru">Русский</a></li>
	                        <li><a href="/en">English</a></li>
	                    </ul>
	                </div>
	            @endif
            </div>
        </div>
    </header>
@endif
