@extends('layouts.index')
@section('title') {{trans('account.t_partners_title')}} @stop
        <!-- Main Content -->
@section('content')
    <div class="site__content site_txt">
        <section class="partners-program">
            <h1>{{trans('account.t_partners_title')}}</h1>
            <div class="partners-program__question">
                <h2>{{trans('account.t_partners_who_neo')}}</h2>
                @if(Session::has('status') && Session::get('status') == 'success')
                    <div class="alert alert-success">{{trans('account.t_partners_thx_reg')}}</div>
                @endif
                <ul>
                    <li>{{trans('account.t_partners_list1')}}</li>
                    <li>{{trans('account.t_partners_list2')}}</li>
                    <li>{{trans('account.t_partners_list3')}}</li>
                    <li>{{trans('account.t_partners_list4')}}</li>
                    <li>{{trans('account.t_partners_list5')}}</li>
                    <li>{{trans('account.t_partners_list6')}}</li>
                </ul>
                <br>
                <br>
                <br>
                <h2>{{trans('account.t_partners_how_start')}}</h2>
                <p>{{trans('account.t_partners_text1')}}</p>
                <br>
                <br>
                <h2>{{trans('account.t_partners_text2')}}</h2>
                <p>{{trans('account.t_partners_text3')}}</p>
                <p>{{trans('account.t_partners_text4')}}</p>
                <table>
                    <thead>
                    <tr>
                        <th rowspan="2">{{trans('account.')}}Доход getloc.ru (за месяц)</th>
                        <th colspan="2">{{trans('account.')}}Webmoney, Яндекс.Деньги</th>
                        <th colspan="2">{{trans('account.')}}PayPal, ePayments, банк</th>
                    </tr>
                    <tr>
                        <th>{{trans('account.t_partners_pay1')}}</th>
                        <th>{{trans('account.t_partners_pay2')}}</th>
                        <th>{{trans('account.t_partners_pay3')}}</th>
                        <th>{{trans('account.t_partners_pay4')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{trans('account.t_partners_do')}} 100 000 {{trans('account.t_partners_rub')}}.</td>
                        <td>20</td>
                        <td>{{trans('account.t_partners_do')}} 50 000 {{trans('account.t_partners_rub')}}</td>
                        <td>20</td>
                        <td>{{trans('account.t_partners_do')}} 50 000 {{trans('account.t_partners_rub')}}</td>
                    </tr>
                    <tr>
                        <td>{{trans('account.t_partners_do')}} 80 000 {{trans('account.t_partners_rub')}}</td>
                        <td>30</td>
                        <td>{{trans('account.t_partners_do')}} 70 000 {{trans('account.t_partners_rub')}}</td>
                        <td>30</td>
                        <td>{{trans('account.t_partners_do')}} 70 000 {{trans('account.t_partners_rub')}}</td>
                    </tr>
                    <tr>
                        <td>{{trans('account.t_partners_do')}} 120 000 {{trans('account.t_partners_rub')}}</td>
                        <td>40</td>
                        <td>{{trans('account.t_partners_do')}} 80 000 {{trans('account.t_partners_rub')}}</td>
                        <td>40</td>
                        <td>{{trans('account.t_partners_do')}} 80 000 {{trans('account.t_partners_rub')}}</td>
                    </tr>
                    <tr>
                        <td>{{trans('account.t_partners_ot')}} 100 001 {{trans('account.t_partners_rub')}} {{trans('account.t_partners_and_more')}}</td>
                        <td>50</td>
                        <td>{{trans('account.t_partners_do')}} 100 000 {{trans('account.t_partners_rub')}}</td>
                        <td>50</td>
                        <td>{{trans('account.t_partners_do')}} 100 000 {{trans('account.t_partners_rub')}}</td>
                    </tr>
                    </tbody>
                </table>
                <p>{{trans('account.t_partners_viplate')}}</p>
                <p>{{trans('account.t_partners_viplate_more')}}
                    <a href="#">{{trans('account.t_partners_there')}}</a>
                </p>
            </div>
            <div class="partners-program__sign-up">
                <div class="partners-program__successfully">
                    <div class="partners-program__pic" style="background-image: url(/assets/img/create-s.png)"></div>
                    <span>{{trans('account.t_partners_goodluck')}}</span>
                </div>
                <!-- /add-code__successfully -->

                <form class="site__form partners-program_form" method="post" action="{{route('partners.register')}}" novalidate="">
                    {!! csrf_field() !!}
                    <h2>{{trans('account.t_partners_reg_now')}}</h2>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <fieldset>
                        <label for="organization">{{trans('account.t_partners_org')}}</label>
                        <input type="text" name="company" id="organization" required="" value="{{old('company')}}">
                    </fieldset>
                    <fieldset>
                        <label for="contact-person">{{trans('account.t_partners_face')}}</label>
                        <input type="text" name="visibility_name" id="contact-person" required="" value="{{old('visibility_name')}}">
                    </fieldset>
                    <fieldset>
                        <label for="site">{{trans('account.t_partners_site')}}</label>
                        <input type="text" name="site" id="site" required="" value="{{old('site')}}">
                    </fieldset>
                    <fieldset>
                        <label for="phone">{{trans('account.t_partners_phone')}}</label>
                        <input type="tel" name="phone" id="phone" required=""  value="{{old('phone')}}">
                    </fieldset>
                    <fieldset>
                        <label for="email">{{trans('account.t_partners_email')}}</label>
                        <input type="email" name="email" id="email" required="" value="{{old('email')}}">
                    </fieldset>
                    <!-- partners-program__btn -->
                    <button class="partners-program__btn" type="submit">{{trans('account.t_partners_part')}}</button>
                    <!-- /partners-program__btn -->
                </form>

            </div>
            <!-- /partners-program__sign-up -->

        </section>
        <!-- /partners-program -->

    </div>
@endsection
