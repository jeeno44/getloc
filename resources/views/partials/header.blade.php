@if (!empty($route) && $route == 'main')
    <header class="site__header">
        <div class="site__header-layout">
            <h1 class="logo anchor" data-href="#up">
                <img src="/assets/img/logo.png" width="90" height="26" alt="getLoc">
            </h1>
            <div class="site__header-inner">
                <nav class="header__menu">
                    <a href="{{route('main.feature')}}">{{trans('phrases.capabilities')}}</a>
                    <a href="{{route('scan.main')}}">{{trans('phrases.analytics')}}</a>
                </nav>
                @include('partials.login')
            </div>

        </div>
    </header>
@elseif (!empty($route) && $route == 'main.feature')
    <header class="site__header ">
        <div class="site__header-layout">
            <h1 class="logo anchor" data-href="#up">
                <img src="/assets/img/logo.png" width="90" height="26" alt="getLoc">
            </h1>
            <div class="site__header-inner">
                <nav class="header__menu">
                    <a href="{{route('main.feature')}}" class="active">{{trans('phrases.capabilities')}}</a>
                    <a href="{{route('scan.main')}}">{{trans('phrases.analytics')}}</a>
                </nav>
                @include('partials.login')
            </div>
        </div>
    </header>
@else
    <header class="site__header site__header_not-logged">
        <div class="site__header-layout">
            <h1 class="logo anchor" data-href="#up">
                <img src="/assets/img/logo.png" width="90" height="26" alt="getLoc">
            </h1>
            <div class="site__header-inner">
                <nav class="header__menu">
                    <a href="{{route('main.feature')}}">{{trans('phrases.capabilities')}}</a>
                    <a href="{{route('scan.main')}}" class="active">{{trans('phrases.analytics')}}</a>
                </nav>
                @include('partials.login')
            </div>
        </div>
    </header>
@endif
