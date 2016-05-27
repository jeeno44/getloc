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
	        <a href="{{URL::route('main.account.selectProject')}}">Все проекты</a>
			<a href="{{route('main.account.personal')}}">Мой профиль</a>
            <a href="{{route('main.account.payments')}}">Мои платежи</a>
        </div>
        <!-- /footer-menu -->

    </div>
    <!-- /site__footer-layout -->

</footer>