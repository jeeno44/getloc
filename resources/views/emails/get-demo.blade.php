<style>
    *{
        padding:0;
        margin:0;
    }
</style>

<table cellpadding="0" cellspacing="0"   align="center"
       style="font-family: Arial, sans-serif;background:#3e4f59;border-collapse:collapse; width: 100%; height: 100%; vertical-align: middle; text-align: center; border: none;">
    {{--
    <tr>
        <td height="42px" style="height: 42px; text-align: center; vertical-align: middle; font-size: 11px; line-height: 18px;">
            <a href="#" style="color: #6d8695; text-decoration: none;">Открыть письмо в браузере</a>
        </td>
    </tr>
    --}}
    <tr>
        <td>
            <table cellpadding="0" cellspacing="0"  align="center" width="660"
                   style="background: #fff; font-family: Arial, sans-serif;border-collapse:collapse; width: 600px; min-width: 600px; margin: 0 auto; border: none;
                   text-align: left;">
                <!--header-->
                <tr>

                    <td style="height: 130px; vertical-align: middle; text-align: center;"
                        height="130">

                        <a href="{{route('main')}}">
                            <img src="{{asset('assets/img/logo-mail.png')}}" width="110" height="28" alt="getLock">
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
                    <td height="45" style="height:45px;"></td>
                </tr>
                <tr>
                    <td>
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="width: 20px;" width="20"></td>
                                <td style="width: 560px;" width="560">
                                    <h2 style="text-align: center; font-size: 24px; color: #333; margin-bottom: 12px;">{{trans('account.t_email_call_me_hello')}}</h2>
                                    <p style="text-align: left; font-size: 14px; line-height: 22px; color: #333;">
                                        {{trans('account.t_email_get_demo_text1')}}

                                        {{trans('account.t_email_get_demo_text2')}}

                                        {{trans('account.t_email_get_demo_text3')}} {{$site}}. {{trans('account.t_email_get_demo_text4')}}

                                        {{trans('account.t_email_get_demo_text5')}}

                                        {{trans('account.t_email_call_me_try')}} <a href="{{route('scan.main')}}">{{trans('account.t_email_call_me_analy')}}</a>, {{trans('account.t_email_call_me_text2')}}

                                            -
                                        {{trans('account.t_email_get_demo_text6')}}
                                        {{trans('account.t_email_get_demo_text7')}}
                                        П{{trans('account.t_email_get_demo_text8')}}
                                            -
                                        {{trans('account.t_email_call_me_dream_team')}}
                                    </p>
                                </td>
                                <td style="width: 20px;" width="20"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td height="74px" style="height: 74px;"></td>
                </tr>
                <tr>
                    <td>
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="width: 20px;" width="20"></td>
                                <td style="width: 560px;" width="560">
                                    <h3 style="text-align: center; font-size: 24px; color: #333; margin-bottom: 13px;">{{trans('account.t_email_get_demo_text9')}}</h3>
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
                                        {{trans('account.t_email_get_demo_text10')}}
                                        {{trans('account.t_email_get_demo_text11')}}
                                        {{trans('account.t_email_get_demo_text12')}}
                                        {{trans('account.t_email_get_demo_text13')}}
                                        <a style="color: #18baea;" href="#">{{trans('account.more')}}</a> {{trans('account.t_email_get_demo_text14')}}
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
                                        {{trans('account.t_email_get_demo_text15')}}
                                        {{trans('account.t_email_get_demo_text16')}}
                                        {{trans('account.t_email_get_demo_text17')}}
                                        {{trans('account.t_email_get_demo_text18')}}
                                        {{trans('account.t_email_get_demo_text19')}}
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
                                        {{trans('account.t_email_get_demo_text20')}}
                                        {{trans('account.t_email_get_demo_text21')}}
                                        {{trans('account.t_email_get_demo_text22')}}
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
                <!--/content-->

                <!--footer-->
                <tr>
                    <td>

                        <table cellpadding="0" cellspacing="0" width="100%" bgcolor="#506876" style="background:
                        #506876;">
                            <tr>
                                <td>
                                    <table cellpadding="0" cellspacing="0" width="100%" bgcolor="#506876" style="background:
                                     #506876;">
                                        <tr>
                                            <td height="24" style="height: 24px;"></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; font-size: 11px; line-height: 22px; color: #fff;">
                                                © {{trans('account.t_email_get_demo_copyright')}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="13" style="height: 13px;"></td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td height="44" style="height: 44px; vertical-align: top;">
                                    <table cellpadding="0" cellspacing="0" width="100%" style="text-align: center">
                                        <tr>
                                            <td width="300" style="width: 300px; text-align: center; font-size: 11px; line-height: 22px;">
                                                <a style=" text-decoration: none; color: #a6bcc9;" href="#">{{trans('account.t_email_call_me_otpiska')}}</a>
                                            </td>

                                            <td width="300" style="width: 300px; text-align: center; font-size: 11px; line-height: 22px;">
                                                <a style=" text-decoration: none; color: #a6bcc9;" href="#">{{trans('account.t_email_get_demo_update_profile')}}</a>
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
</table>';