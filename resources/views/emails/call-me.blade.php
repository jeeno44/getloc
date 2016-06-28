<style>
    *{
        padding:0;
        margin:0;
    }
</style>

<table cellpadding="0" cellspacing="0"   align="center"
       style="font-family: Arial, sans-serif;background:#3e4f59;border-collapse:collapse; width: 100%; height: 100%; vertical-align: middle; text-align: center; border: none;">
    
    <tr>
        <td height="20px" style="height: 20px; text-align: center; vertical-align: middle; font-size: 11px; line-height: 18px;">
            {{--<a href="#" style="color: #6d8695; text-decoration: none;">Открыть письмо в браузере</a>--}}
        </td>
    </tr>
    
    <tr>
        <td>
            <table cellpadding="0" cellspacing="0"  align="center" width="660"
                   style="background: #fff; font-family: Arial, sans-serif;border-collapse:collapse; width: 600px; min-width: 600px; margin: 0 auto; border: none;
                   text-align: left;">
                <!--header-->
                <tr>

                    <td style="height: 55px; vertical-align: middle; text-align: center;"
                        height="55">

                        <a href="{{route('main')}}">
                            <img src="{{asset('assets/img/logo-mail.png')}}" width="110" height="28" alt="getLoc">
                        </a>

                    </td>
                </tr>
                <!--/header-->

                <!--content-->
                <tr>
                    <td style="height: 200px; vertical-align: middle; text-align: center;" height="200">
                        <img src="{{asset('assets/img/head-pic.jpg')}}" width="600" height="200" alt="getLoc">
                    </td>
                </tr>
                <tr>
                    <td height="20" style="height:20px;"></td>
                </tr>
                <tr>
                    <td>
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="width: 20px;" width="20"></td>
                                <td style="width: 560px;" width="560">
                                    <h2 style="text-align: center; font-size: 24px; color: #333;">{{trans('account.t_email_call_me_hello')}}</h2>
                                    <p style="text-align: left; font-size: 14px; line-height: 22px; color: #333; padding-top: 20px;">
                                        {{trans('account.t_email_call_me_text1')}}
                                    </p>		
                                    <p style="text-align: left; font-size: 14px; line-height: 22px; color: #333; padding-top: 20px;">
                                        {{trans('account.t_email_call_me_try')}} <a href="{{route('scan.main')}}">{{trans('account.t_email_call_me_analy')}}</a> , {{trans('account.t_email_call_me_text2')}}
                                    </p>
                                    <p style="text-align: left; font-size: 14px; line-height: 22px; color: #333; padding-top: 20px;">
                                        -<br />
                                        {{trans('account.t_email_call_me_dream_team')}}
                                    </p>
                                </td>
                                <td style="width: 20px;" width="20"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                
                <tr>
                    <td height="30" style="height: 30px;"></td>
                </tr>
                {{--
                <tr>
                    <td>
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="width: 20px;" width="20"></td>
                                <td style="width: 560px;" width="560">
                                    <h3 style="text-align: center; font-size: 24px; color: #333; margin-bottom: 13px;">Мы собрали самое лучшее</h3>
                                    <table cellpadding="0" cellspacing="0" width="100%">
                                        <tr style="height: 128px; text-align: center; vertical-align: middle;">
                                            <td width="200" height="128"  style="height: 128px; width: 200px;">
                                                <img src="{{asset('assets/img/pc-pic.png')}}" width="110" height="88" alt="pc-pic">
                                            </td>

                                            <td width="200" height="128"  style="height: 128px; width: 200px;">
                                                <img src="{{asset('assets/img/eq-pic.png')}}" width="91" height="88" alt="eq-pic">
                                            </td>

                                            <td width="200" height="128"  style="height: 128px; width: 200px;">
                                                <img src="{{asset('assets/img/user-pic.png')}}" width="104" height="92" alt="user-pic">
                                            </td>
                                        </tr>

                                    </table>
                                </td>
                                <td style="width: 20px;" width="20"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td height="11" style="height: 11px"></td>
                </tr>
                <tr>
                    <td>
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="width: 20px;" width="20"></td>
                                <td style="width: 560px;" width="560">
                                    <p style="font-size: 14px; line-height: 22px; color: #333;">
                                        Напоминаем вам про рестарт оффера Airbnb в нашей партнёрской
                                        сети. Уже за первые три недели работы оффера мы показали
                                        фантастические результаты по конверсии и прибыльности.
                                        Мы добавили новые баннеры (доступны в ваших личных кабинетах).
                                        <a style="color: #18baea;" href="#">Подробнее</a> об оффере на страницах нашего блога.
                                    </p>
                                </td>
                                <td style="width: 20px;" width="20"></td>
                            </tr>

                            <tr>
                                <td height="12" style="height: 12px;"></td>
                            </tr>

                            <tr>
                                <td style="width: 20px;" width="20"></td>
                                <td style="width: 560px;" width="560">
                                    <p style="font-size: 14px; line-height: 22px; color: #333;">
                                        Мы добавили в поисковые формы и White Label возможность включить
                                        отображение окна с отелями от нашего рекламодателя Clicktripz.
                                        Оплата идет за каждый уникальный клик в графу «Рекламный доход»,
                                        у некоторых партнёров доход увеличился на 50%. Хотите так же? Не
                                        забывайте включать галочку «Показывать отели» в настройках форм.
                                    </p>
                                </td>
                                <td style="width: 20px;" width="20"></td>
                            </tr>

                            <tr>
                                <td height="12" style="height: 12px;"></td>
                            </tr>

                            <tr>
                                <td style="width: 20px;" width="20"></td>
                                <td style="width: 560px;" width="560">
                                    <p style="font-size: 14px; line-height: 22px; color: #333;">
                                        На White Label это активируется автоматически. Это всплывающее
                                        окно не влияет на конверсию и позиции в поисковиках. Мы и сами
                                        используем его на главных страницах Aviasales и hotellook.
                                    </p>
                                </td>
                                <td style="width: 20px;" width="20"></td>
                            </tr>

                            <tr>
                                <td height="49" style="height: 49px;"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                --}}
                <!--/content-->

                <!--footer-->
                <tr>
                    <td>

                        <table cellpadding="0" cellspacing="0" width="100%" bgcolor="#506876" style="background:
                        #506876;">
	                        {{--
                            <tr>
                                <td>
                                    <table cellpadding="0" cellspacing="0" width="100%" bgcolor="#506876" style="background:
                                     #506876;">
                                        <tr>
                                            <td height="24" style="height: 24px;"></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; font-size: 11px; line-height: 22px; color: #fff;">
                                                &copy;2016 getLoc. Все права защищены.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="13" style="height: 13px;"></td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>
							--}}
							<tr>
						        <td height="20" style="height: 20px"></td>
						    </tr>
                            <tr>
                                <td height="44" style="height: 44px; vertical-align: top;">
                                    <table cellpadding="0" cellspacing="0" width="100%" style="text-align: center">
                                        <tr>
                                            <td width="300" style="width: 300px; text-align: center; font-size: 11px; line-height: 22px; color: #fff;">
                                                &copy;{{trans('account.t_email_call_me_copyright')}}
                                            </td>

                                            <td width="300" style="width: 300px; text-align: center; font-size: 11px; line-height: 22px;">
	                                            <a style=" text-decoration: none; color: #a6bcc9;" href="#">{{trans('account.t_email_call_me_otpiska')}}</a>
                                                {{--<a style=" text-decoration: none; color: #a6bcc9;" href="#">Обновить профиль подписчика</a>--}}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
                <!--/footer-->
            </table>
        </td>
    </tr>
    <tr>
        <th height="20" style="height: 20px"></th>
    </tr>
</table>