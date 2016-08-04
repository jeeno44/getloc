<footer class="site__footer">

    <!-- /site__footer-layout -->
    <div class="site__footer-layout">

        <!-- footer__logo -->
        <a href="#" class="footer__logo">
            <img src="/assets/img/account/footer-logo.png" width="90" height="26" alt="GETLOC">
        </a>
        <!-- /footer__logo -->

        <!-- footer-menu -->
        <div class="footer-menu">
	        <a href="{{URL::route('main.account.selectProject')}}">{{trans('account.t_all_projects')}}</a>
			<a href="{{route('main.account.personal')}}">{{trans('account.t_my_profile')}}</a>
            <a href="{{route('main.account.payments')}}">{{trans('account.t_my_pays')}}</a>
        </div>
        <!-- /footer-menu -->

    </div>
    <!-- /site__footer-layout -->

</footer>