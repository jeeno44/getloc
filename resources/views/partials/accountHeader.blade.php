<!-- /site__header -->
        <header class="site__header">

            <!-- site__header-layout -->
            <div class="site__header-layout">

{{--
                <!-- menu -->
                <div class="menu">

                    <!-- menu__icon -->
                    <div class="menu__icon">
                        <span></span>
                    </div>
                    <!-- /menu__icon -->

                    <nav class="menu__wrap">
                        <a href="#">{{trans('account.ourPlatform')}}</a>
                        <a href="#" class="active">{{trans('account.translatesManagement')}}</a>
                        <a href="#">{{trans('account.orderTranslation')}}</a>
                        <a href="#">{{trans('account.integration')}}</a>
                        <a href="#">{{trans('account.developmentPlans')}}</a>
                        <a href="#">{{trans('account.help')}}</a>
                    </nav>

                </div>
                <!-- /header__menu -->
--}}
                <!-- logo -->
                <a href="{{route('main.account')}}" class="logo">
                    <img src="/assets/img/account/logo.png" width="90" height="26" alt="GETLOC">
                </a>
                <!-- /logo -->

                <!-- site-list -->
                <div class="site-list">

                    <!-- site-list__add -->
                    <form action="{{route('main.account.add-project')}}" style="display: inline">
                        <button class="site-list__add"></button>
                    </form>

                    <!-- /site-list__add -->

                    <select id="site-list">
                        @foreach ( $sites as $site )
                        <option @if (\Session::get('projectID') == $site->id) selected="selected" @endif value="{{URL::route('main.account.setProject', $site->id)}}">{{$site->name}}</option>
                        @endforeach
                        <option class="all_projects" @if (\Session::get('projectID') == "") selected="selected" @endif value="{{URL::route('main.account.selectProject')}}">{{trans('account.t_all_projects')}}</option>
                    </select>
                </div>
                <!-- /site-list -->

                <!-- header__person -->
                <div class="header__person" style="background-image: url('/assets/img/account/iocns-ava.png');">

                    <!-- header__person-list -->
                    <ul class="header__person-list">
                        <li><a href="{{route('main.account.personal')}}">{{trans('account.t_my_profile')}}</a></li>
                        <li><a href="{{route('main.account.payments')}}">{{trans('account.t_my_pays')}}</a></li>
                        <li><a href="{{URL::route('logout')}}">{{trans('account.t_exit')}}</a></li>
                    </ul>
                    <!-- /header__person-list -->

                </div>
                <!-- /header__person -->
                
               
                <div class="language">
                    <button class="language__btn">{{strtoupper($locale)}}</button>
                    <ul class="language__list">
                        <li><a href="/ru">Русский</a></li>
                        <li><a href="/en">English</a></li>
                    </ul>
                </div>
               

            </div>
            <!-- /site__header-layout -->

        </header>
        <!-- /site__header -->