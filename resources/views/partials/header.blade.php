@if (!empty($route) && $route == 'main')
    <header class="site__header">
        <div class="site__header-layout">
            <h1 class="logo anchor" data-href="#up">
                <img src="/assets/img/logo.png" width="90" height="26" alt="getLoc">
            </h1>
            <div class="site__header-inner">
                <nav class="header__menu">
                    <a href="{{route('main.feature')}}">{{trans('phrases.capabilities')}}</a>
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
            <a href="{{route('main')}}" class="logo">
                <img src="/assets/img/logo.png" width="90" height="26" alt="getLoc">
            </a>
            <div class="site__header-inner">
                <nav class="header__menu">
                    @if(strpos(url('/'), 'scan'))
                    @else
                        <a href="{{route('main.feature')}}">{{trans('phrases.capabilities')}}</a>
                        @if (\Auth::check() && \App\User::find(\Auth::user()->id)->hasRole('show_stat') )
                            <a href="{{route('scan.main')}}">{{trans('phrases.analytics')}}</a>
                        @endif
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
@endif
