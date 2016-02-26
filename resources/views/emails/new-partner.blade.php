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
                            <img src="{{asset('assets/img/logo-mail.png')}}" width="110" height="28" alt="getLock">
                        </a>

                    </td>
                </tr>
                <!--/header-->

                <!--content-->
                <tr>
                    <td style="height: 200px; vertical-align: middle; text-align: center;" height="200">
                        <img src="{{asset('assets/img/head-pic.jpg')}}" width="600" height="200" alt="getLock">
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
                                    <h2 style="text-align: center; font-size: 24px; color: #333;">Привет!</h2>
                                    <p style="text-align: left; font-size: 14px; line-height: 22px; color: #333; padding-top: 20px;">
                                        Спасибо за проявленный интерес к нашему сервису локализации и переводов. Мы будем держать вас в курсе важных новостей и оповестим вас о запуске сервиса в первую очередь.
                                    </p>		
                                    <p style="text-align: left; font-size: 14px; line-height: 22px; color: #333; padding-top: 20px;">
                                        Ваш пароль для входа в кабинет партнера: {{$v_password}}<br>
                                        Ваша ссылка для привлечения клиентов: {{url('?tracker='.$partner_link)}}
                                    </p>
                                    <p style="text-align: left; font-size: 14px; line-height: 22px; color: #333; padding-top: 20px;">
                                        -<br />
                                        Команда getLoc
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
                <!--footer-->
                <tr>
                    <td>

                        <table cellpadding="0" cellspacing="0" width="100%" bgcolor="#506876" style="background:
                        #506876;">
							<tr>
						        <td height="20" style="height: 20px"></td>
						    </tr>
                            <tr>
                                <td height="44" style="height: 44px; vertical-align: top;">
                                    <table cellpadding="0" cellspacing="0" width="100%" style="text-align: center">
                                        <tr>
                                            <td width="300" style="width: 300px; text-align: center; font-size: 11px; line-height: 22px; color: #fff;">
                                                &copy;2016 getLoc. Все права защищены.
                                            </td>

                                            <td width="300" style="width: 300px; text-align: center; font-size: 11px; line-height: 22px;">
	                                            <a style=" text-decoration: none; color: #a6bcc9;" href="#">Отписать от рассылки</a>
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