@extends('layouts.index')
@section('title') Партнерская программа @stop
        <!-- Main Content -->
@section('content')
    <div class="site__content site_txt">
        <section class="partners-program">
            <h1>Партнерская программа</h1>
            <div class="partners-program__question">
                <h2>Кто может стать нашим партнёром?</h2>
                @if(Session::has('status') && Session::get('status') == 'success')
                    <div class="alert alert-success">Спасибо за регистрацию, проверьте почту</div>
                @endif
                <ul>
                    <li>Владельцы сайтов (рекомендуемая тематика: туризм, путешествия, региональные порталы, женские сайты, форумы и т.д.);</li>
                    <li>Блогеры;</li>
                    <li>Владельцы групп в социальных сетях (Twitter, VK, Facebook, Одноклассники и т.д.);</li>
                    <li>SEO-специалисты (допустимые типы трафика);</li>
                    <li>Турагентства (частые вопросы от турагентств);</li>
                    <li>А также все, кто хочет зарабатывать на продаже авиабилетов.</li>
                </ul>
                <br>
                <br>
                <br>
                <h2>Как это работает?</h2>
                <p>Вы размещаете форму поиска авиабилетов у себя на сайте. Если пользователь заинтересован в покупке авиабилета, а форма отчетливо видна на странице, то он ищет билет, бронирует и покупает его. Вы получаете свою комиссию 50-70% от нашего дохода с проданного авиабилета. Кроме того, мы платим комиссию за бронирование отелей и другие полезные продукты.</p>
                <br>
                <br>
                <h2>Сколько денег можно заработать на партнерской программе getloc.ru?</h2>
                <p>Мы делимся с партнёрами 50-70% дохода, получаемого нами от агентств (в среднем наш доход составляет около 2,2% от стоимости авиабилета).</p>
                <p>Конкретный процент (50, 60 или 70%) зависит от суммы дохода, получаемого Aviasales.ru с трафика партнёра (за месяц), а также от способа выплаты комиссии:</p>
                <table>
                    <thead>
                    <tr>
                        <th rowspan="2">Доход getloc.ru (за месяц)</th>
                        <th colspan="2">Webmoney, Яндекс.Деньги</th>
                        <th colspan="2">PayPal, ePayments, банк</th>
                    </tr>
                    <tr>
                        <th>% комиссии</th>
                        <th>потенциальный заработок</th>
                        <th>% комиссии</th>
                        <th>потенциальный заработок</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>До 100 000 руб.</td>
                        <td>20</td>
                        <td>До 50 000 руб.</td>
                        <td>20</td>
                        <td>До 50 000 руб.</td>
                    </tr>
                    <tr>
                        <td>до 80 000 руб.</td>
                        <td>30</td>
                        <td>До 70 000 руб.</td>
                        <td>30</td>
                        <td>До 70 000 руб.</td>
                    </tr>
                    <tr>
                        <td>до 120 000 руб.</td>
                        <td>40</td>
                        <td>До 80 000 руб.</td>
                        <td>40</td>
                        <td>До 80 000 руб.</td>
                    </tr>
                    <tr>
                        <td>От 100 001 руб. и более</td>
                        <td>50</td>
                        <td>До 100 000 руб.</td>
                        <td>50</td>
                        <td>До 100 000 руб.</td>
                    </tr>
                    </tbody>
                </table>
                <p>Выплата комиссии производится с 11 по 20 число каждого месяца за предыдущий.</p>
                <p>Подробнее о способах выплаты комисси можно узнать
                    <a href="#">здесь.</a>
                </p>
            </div>
            <div class="partners-program__sign-up">
                <div class="partners-program__successfully">
                    <div class="partners-program__pic" style="background-image: url(/assets/img/create-s.png)"></div>
                    <span>Желаем вам приятной работы с нашим сервисом?</span>
                </div>
                <!-- /add-code__successfully -->

                <form class="site__form partners-program_form" method="post" action="{{route('partners.register')}}" novalidate="">
                    {!! csrf_field() !!}
                    <h2>Зарегистрируйтесь сейчас</h2>
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
                        <label for="organization">Организация</label>
                        <input type="text" name="company" id="organization" required="" value="{{old('company')}}">
                    </fieldset>
                    <fieldset>
                        <label for="contact-person">Контактное лицо</label>
                        <input type="text" name="visibility_name" id="contact-person" required="" value="{{old('visibility_name')}}">
                    </fieldset>
                    <fieldset>
                        <label for="site">Сайт</label>
                        <input type="text" name="site" id="site" required="" value="{{old('site')}}">
                    </fieldset>
                    <fieldset>
                        <label for="phone">Телефон</label>
                        <input type="tel" name="phone" id="phone" required=""  value="{{old('phone')}}">
                    </fieldset>
                    <fieldset>
                        <label for="email">E-mail</label>
                        <input type="email" name="email" id="email" required="" value="{{old('email')}}">
                    </fieldset>
                    <!-- partners-program__btn -->
                    <button class="partners-program__btn" type="submit">Стать партнером</button>
                    <!-- /partners-program__btn -->
                </form>

            </div>
            <!-- /partners-program__sign-up -->

        </section>
        <!-- /partners-program -->

    </div>
@endsection
