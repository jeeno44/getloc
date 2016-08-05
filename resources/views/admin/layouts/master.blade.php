<!DOCTYPE html>
<!--[if IE 9]>         <html class="ie9 no-focus"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-focus"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <title>Панель управления</title>
    <meta name="description" content="OneUI - Admin Dashboard Template & UI Framework created by pixelcave and published on Themeforest">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">
    <link rel="shortcut icon" href="/assets/admin/img/favicons/favicon.png">
    <link rel="icon" type="image/png" href="/assets/admin/img/favicons/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="/assets/admin/img/favicons/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/assets/admin/img/favicons/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="/assets/admin/img/favicons/favicon-160x160.png" sizes="160x160">
    <link rel="icon" type="image/png" href="/assets/admin/img/favicons/favicon-192x192.png" sizes="192x192">
    <link rel="apple-touch-icon" sizes="57x57" href="/assets/admin/img/favicons/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/assets/admin/img/favicons/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/assets/admin/img/favicons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/admin/img/favicons/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/assets/admin/img/favicons/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/assets/admin/img/favicons/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/assets/admin/img/favicons/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/assets/admin/img/favicons/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/admin/img/favicons/apple-touch-icon-180x180.png">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700%7COpen+Sans:300,400,400italic,600,700">
    <link rel="stylesheet" href="/assets/admin/js/plugins/slick/slick.min.css">
    <link rel="stylesheet" href="/assets/admin/js/plugins/slick/slick-theme.min.css">
    <link rel="stylesheet" href="/assets/admin/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css">
    <link rel="stylesheet" id="css-main" href="/assets/admin/css/oneui.css">
    <script src="/assets/admin/js/core/jquery.min.js"></script>
</head>
<body>
<div id="page-container" class="sidebar-l sidebar-o side-scroll header-navbar-fixed">
    <!-- Sidebar -->
    <nav id="sidebar">
        <!-- Sidebar Scroll Container -->
        <div id="sidebar-scroll">
            <!-- Sidebar Content -->
            <!-- Adding .sidebar-mini-hide to an element will hide it when the sidebar is in mini mode -->
            <div class="sidebar-content">
                <!-- Side Header -->
                <div class="side-header side-content bg-white-op">
                    <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
                    <button class="btn btn-link text-gray pull-right hidden-md hidden-lg" type="button" data-toggle="layout" data-action="sidebar_close">
                        <i class="fa fa-times"></i>
                    </button>
                    <!-- Themes functionality initialized in App() -> uiHandleTheme() -->
                    <div class="btn-group pull-right">
                        <button class="btn btn-link text-gray dropdown-toggle" data-toggle="dropdown" type="button">
                            <i class="si si-drop"></i>
                        </button>
                    </div>
                    <a class="h5 text-white" href="/admin">
                        <i class="fa fa-circle-o-notch text-primary"></i> <span class="h4 font-w600 sidebar-mini-hide">ne</span>
                    </a>
                </div>
                <!-- END Side Header -->

                <!-- Side Content -->
                @if(!strpos(url('/'), 'scan'))
                    <div class="side-content">
                        {!! widget('AdminLeftMenu') !!}
                    </div>
                @endif

                <!-- END Side Content -->
            </div>
            <!-- Sidebar Content -->
        </div>
        <!-- END Sidebar Scroll Container -->
    </nav>
    <!-- END Sidebar -->

    <!-- Header -->
    <header id="header-navbar" class="content-mini content-mini-full">
        <!-- Header Navigation Right -->
        <ul class="nav-header pull-right">
            <li>
                <div class="btn-group">
                    <button class="btn btn-default btn-image dropdown-toggle" data-toggle="dropdown" type="button">
                        <img src="/assets/admin/img/avatars/avatar10.jpg" alt="Avatar">
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="dropdown-header">Профиль</li>
                        <li>
                            <a tabindex="-1" href="/admin/settings">
                                <i class="si si-settings pull-right"></i>Настройки
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Actions</li>
                        <li>
                            <a tabindex="-1" href="/">
                                <i class="si si-home pull-right"></i>На сайт
                            </a>
                        </li>
                        <li>
                            <a tabindex="-1" href="/logout">
                                <i class="si si-logout pull-right"></i>Выход
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

        </ul>
        <!-- END Header Navigation Right -->

        <!-- Header Navigation Left -->
        <ul class="nav-header pull-left">
            <li class="hidden-md hidden-lg">
                <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
                <button class="btn btn-default" data-toggle="layout" data-action="sidebar_toggle" type="button">
                    <i class="fa fa-navicon"></i>
                </button>
            </li>
            <li class="hidden-xs hidden-sm">
                <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
                <button class="btn btn-default" data-toggle="layout" data-action="sidebar_mini_toggle" type="button">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
            </li>
        </ul>
        <!-- END Header Navigation Left -->
    </header>
    <!-- END Header -->

    <!-- Main Container -->
    <main id="main-container">
        <div class="content bg-image" style="background-image: url('/assets/admin/img/photos/photo{{rand(1,19)}}@2x.jpg');">
            <div class="row items-push">
                <div class="col-sm-7">
                    <h1 class="page-heading text-white">
                        @yield('title')
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    {!! widget('AdminBreadcrumbs') !!}
                </div>
            </div>
        </div>
        <div class="content">
            @yield('content')
        </div>

    </main>
    <!-- END Main Container -->
</div>
<!-- END Page Container -->

<!-- OneUI Core JS: jQuery, Bootstrap, slimScroll, scrollLock, Appear, CountTo, Placeholder, Cookie and App.js -->
<script src="/assets/admin/js/core/bootstrap.min.js"></script>
<script src="/assets/admin/js/core/jquery.slimscroll.min.js"></script>
<script src="/assets/admin/js/core/jquery.scrollLock.min.js"></script>
<script src="/assets/admin/js/core/jquery.appear.min.js"></script>
<script src="/assets/admin/js/core/jquery.countTo.min.js"></script>
<script src="/assets/admin/js/core/jquery.placeholder.min.js"></script>
<script src="/assets/admin/js/core/js.cookie.min.js"></script>
<script src="/assets/admin/js/app.js"></script>
<script src="/assets/admin/js/plugins/slick/slick.min.js"></script>
<script src="/assets/admin/js/plugins/chartjs/Chart.min.js"></script>
<script src="/assets/admin/js/pages/base_pages_dashboard.js"></script>
<script src="/assets/admin/js/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script>
    $(function () {
        // Init page helpers (Slick Slider plugin)
        App.initHelpers(['slick', 'datepicker']);
    });
</script>
</body>
</html>