@if (!empty($route) && $route == 'main')
    <header class="site__header">
        <div class="site__header-layout">
            <h1 class="logo anchor" data-href="#up">
                <img src="/assets/img/logo.png" width="90" height="26" alt="getLoc">
            </h1>
            <nav class="header__menu">
                <a href="{{route('main.feature')}}">{{trans('phrases.capabilities')}}</a>
                <a href="{{route('scan.main')}}">{{trans('phrases.analytics')}}</a>
            </nav>
            <a class="btn btn_header anchor" data-href="#discount">{{trans('phrases.get_demo')}}</a>
        </div>
    </header>
@elseif (!empty($route) && $route == 'main.feature')
    <header class="site__header header_platform">
        <div class="site__header-layout">
            <a href="{{route('main')}}" class="logo">
                <img src="/assets/img/logo.png" width="90" height="26" alt="getLoc">
            </a>
            <nav class="header__menu">
                <a href="{{route('main.feature')}}" class="active">{{trans('phrases.capabilities')}}</a>
                <a href="{{route('scan.main')}}">{{trans('phrases.analytics')}}</a>
            </nav>
            <a class="btn btn_header popup__open" data-popup="order">{{trans('phrases.get_demo')}}</a>
        </div>
    </header>
@else
    <header class="site__header">
        <div class="site__header-layout">
            <a href="{{route('main')}}" class="logo">
                <img src="/assets/img/logo.png" width="90" height="26" alt="getLoc">
            </a>
            <nav class="header__menu">
                <a href="{{route('main.feature')}}">{{trans('phrases.capabilities')}}</a>
                <a href="{{route('scan.main')}}" class="active">{{trans('phrases.analytics')}}</a>
            </nav>
            <a class="btn btn_header popup__open" data-popup="order">{{trans('phrases.get_demo')}}</a>
        </div>
    </header>
@endif
