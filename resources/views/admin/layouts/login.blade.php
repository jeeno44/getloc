<!DOCTYPE html>
<!--[if IE 9]>         <html class="ie9 no-focus"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-focus"> <!--<![endif]-->
<head>
    <meta charset="utf-8">

    <title>Вход в панель управления</title>

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
    <link rel="stylesheet" id="css-main" href="/assets/admin/css/oneui.css">
</head>
<body>
<div id="page-container" class="sidebar-l sidebar-mini sidebar-o side-scroll header-navbar-fixed header-navbar-transparent">
    <!-- Main Container -->
    <main id="main-container">
        <!-- Log In Form -->
        <div class="bg-white">
            <section class="content content-boxed">
                <!-- Section Content -->
                <div class="row items-push push-50-t push-30">
                    <div class="col-md-6 col-md-offset-3">
                        <form class="form-horizontal" action="" method="post">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                @if($errors->any())
                                    <div class="alert alert-danger">{{$errors->first()}}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material form-material-primary">
                                        <input class="form-control" type="text" id="frontend-login-username" name="name" placeholder="admin">
                                        <label for="frontend-login-username">Логин</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material form-material-primary">
                                        <input class="form-control" type="password" id="frontend-login-password" name="password" placeholder="admin">
                                        <label for="frontend-login-password">Пароль</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 text-center">
                                    <label class="css-input switch switch-sm switch-primary">
                                        <input type="checkbox" id="frontend-login-remember-me" name="remember"><span></span> Запомнить?
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                                    <button class="btn btn-block btn-primary" type="submit"><i class="fa fa-arrow-right pull-right"></i> Вход</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- END Section Content -->
            </section>
        </div>
        <!-- END Log In Form -->
    </main>
    <!-- END Main Container -->
</div>
<!-- END Page Container -->
<script src="/assets/admin/js/core/jquery.min.js"></script>
<script src="/assets/admin/js/core/bootstrap.min.js"></script>
<script src="/assets/admin/js/core/jquery.slimscroll.min.js"></script>
<script src="/assets/admin/js/core/jquery.scrollLock.min.js"></script>
<script src="/assets/admin/js/core/jquery.appear.min.js"></script>
<script src="/assets/admin/js/core/jquery.countTo.min.js"></script>
<script src="/assets/admin/js/core/jquery.placeholder.min.js"></script>
<script src="/assets/admin/js/core/js.cookie.min.js"></script>
<script src="/assets/admin/js/app.js"></script>

<!-- Page JS Code -->
<script>
    $(function () {
        // Init page helpers (Appear plugin)
        App.initHelpers('appear');
    });
</script>
</body>
</html>