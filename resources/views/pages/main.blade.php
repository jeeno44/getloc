@extends('layouts.index')

@section('title') GETLOC @stop

@section('content')
    <div class="site__content">

        <!-- promo -->
        <div class="promo">

            <!-- site__wrap -->
            <div class="site__wrap">

                <!-- promo__content -->
                <div class="promo__content">

                    <!-- promo__title -->
                    <h2 class="promo__title">Мультиязычный сайт <span>– это просто!</span></h2>
                    <!-- /promo__title -->

                    <!-- promo__text -->
                    <div class="promo__text">
                        Идеальное решения <br/> для быстрого перевода веб-сайтов <br/> на много языков
                    </div>
                    <!-- /promo__text -->

                    <!-- promo__more -->
                    <a class="promo__more anchor" data-href="#advantages">Узнать подробнее</a>
                    <!-- /promo__more -->

                </div>
                <!-- /promo__content -->

                <!-- gallery -->
                <div class="gallery" data-duration="3000">

                    <!-- gallery__item -->
                    <div class="gallery__item">

                        <!-- gallery__item_2nd -->
                        <img class="gallery__item_2nd" src="/assets/pic/gallery__pic-2.png" width="500" height="256">
                        <!-- /gallery__item_2nd -->

                        <!-- gallery__item_1st -->
                        <img class="gallery__item_1st" src="/assets/pic/gallery__pic-1.png" width="554" height="399">
                        <!-- /gallery__item_1st -->

                    </div>
                    <!-- /gallery__item -->

                    <!-- gallery__item -->
                    <div class="gallery__item">

                        <!-- gallery__item_3rd -->
                        <img class="gallery__item_3rd" src="/assets/pic/gallery__pic-5.png" width="500" height="265">
                        <!-- /gallery__item_3rd -->

                        <!-- gallery__item_2nd -->
                        <img class="gallery__item_2nd" src="/assets/pic/gallery__pic-4.png" width="500" height="269">
                        <!-- /gallery__item_2nd -->

                        <!-- gallery__item_1st -->
                        <img class="gallery__item_1st gallery__item_1st_right" src="/assets/pic/gallery__pic-3.png" width="468" height="398">
                        <!-- /gallery__item_1st -->

                    </div>
                    <!-- /gallery__item -->

                    <!-- gallery__prev -->
                    <div class="gallery__prev">prev</div>
                    <!-- /gallery__prev -->

                    <!-- gallery__next -->
                    <div class="gallery__next">next</div>
                    <!-- /gallery__next -->

                </div>
                <!-- /gallery -->

            </div>
            <!-- site__wrap -->

        </div>
        <!-- /promo -->

        <!-- enroll -->
        <div class="enroll">

            <!-- site__wrap -->
            <div class="site__wrap">

                <!-- enroll__content -->
                <div class="enroll__content">
                    <p>Сейчас проводится тестирование на <b>{{$sites}}</b> сайтах</p>
                    <a data-href="#discount" class="anchor">Записаться на тестирование</a>
                    <span class="enroll__start">Дата запуска – март 2016 года</span>
                </div>
                <!-- /enroll__content -->

                <!-- enroll__form -->
                <div class="enroll__form">
                    {!! Form::open(['route' => 'main.call-me']) !!}
                            <!-- enroll__email-box -->
                    <fieldset class="enroll__email-box">
                        <input type="email" id="enroll__email" placeholder="Ваш e-mail" class="enroll__email" required/>
                    </fieldset>
                    <!-- /enroll__email-box -->

                    <!-- btn -->
                    <button class="btn btn_enroll">
                        <span>Сообщить мне о запуске</span>
                    </button>
                    <!-- /btn -->
                    {!! Form::close() !!}
                </div>
                <!-- /enroll__form -->

                <!-- enroll__thanks -->
                <div class="enroll__thanks">
                    <span class="enroll__thanks-title">Спасибо за заявку!</span>
                    <p>Уверяем вас, вы узнаете о запуске
                        сервиса одним из первых.</p>
                </div>
                <!-- /enroll__thanks -->

            </div>
            <!-- site__wrap -->

        </div>
        <!-- /enroll -->

        <!-- site__wrap -->
        <div class="site__wrap">

            <!-- advantages -->
            <div class="advantages" id="advantages">

                <!-- site__title -->
                <h2 class="site__title"><strong>getLoc</strong> поможет вам переводить сайты легко и быстро!</h2>
                <!-- site__title -->

                <!-- advantages__introduction -->
                <div class="advantages__introduction">
                    Сейчас существует большая потребность в легком и доступном любому пользователю инструменте для создания мультиязычной версии сайт. Этот сервис даст вам возможность с минимальными навыками сделать профессиональный многоязычный сайт.
                </div>
                <!-- /advantages__introduction -->

                <!-- advantages__items -->
                <ul class="advantages__items">
                    <li>

                        <!-- advantages__img -->
                        <div class="advantages__img">
                            <img src="/assets/img/advantages-001.jpg" alt="img"/>
                        </div>
                        <!-- /advantages__img -->

                        <!-- advantages__title -->
                        <h3 class="advantages__title">Полная автоматизация <br/> процесса</h3>
                        <!-- /advantages__title -->

                        <p>Процесс построен так, что от вас требуется минимальное вмешательство. Всю работу мы берем на себя.</p>
                    </li>
                    <li>

                        <!-- advantages__img -->
                        <div class="advantages__img">
                            <img src="/assets/img/advantages-002.jpg" alt="img"/>
                        </div>
                        <!-- /advantages__img -->

                        <!-- advantages__title -->
                        <h3 class="advantages__title">Простая настройка <br/> перевода</h3>
                        <!-- /advantages__title -->

                        <p>Для того, чтобы настроить перевод не требуется специалист. Всё это займёт у вас не более 10 минут.</p>
                    </li>
                    <li>

                        <!-- advantages__img -->
                        <div class="advantages__img">
                            <img src="/assets/img/advantages-003.jpg" alt="img"/>
                        </div>
                        <!-- /advantages__img -->

                        <!-- advantages__title -->
                        <h3 class="advantages__title">Разные виды <br/> перевода</h3>
                        <!-- /advantages__title -->

                        <p>Вам предоставляется выбор между автоматическим переводом и профессиональным переводчиком.</p>
                    </li>
                </ul>
                <!-- /advantages__items -->

                <!-- btn -->
                <a href="{{route('main.futures')}}"  class="btn btn_1"><span>Все возможности</span></a>
                <!-- /btn -->

                <!-- next-step -->
                <div class="next-step"></div>
                <!-- /next-step -->

            </div>
            <!-- /advantages -->

            <!-- application -->
            <div class="application">

                <!-- site__title -->
                <h2 class="site__title">Где можно применять?</h2>
                <!-- site__title -->

                <!-- application__introduction -->
                <div class="application__introduction">
                    <p>Существует множество отраслей, где есть необходимость применения данного сервиса.
                </div>
                <!-- /application__introduction -->

                <!-- application-list -->
                <ul class="application-list">
                    <li>

                        <!-- application-icon -->
                        <div class="application-icon">
                            <div>
                                <img src="/assets/img/application-001.jpg" alt="icon"/>
                            </div>
                        </div>
                        <!-- /application-icon -->

                        <span>Культура</span>
                    </li>
                    <li>

                        <!-- application-icon -->
                        <div class="application-icon">
                            <div>
                                <img src="/assets/img/application-002.jpg" alt="icon"/>
                            </div>
                        </div>
                        <!-- /application-icon -->

                        <span>Бизнес</span>
                    </li>
                    <li>

                        <!-- application-icon -->
                        <div class="application-icon">
                            <div>
                                <img src="/assets/img/application-003.jpg" alt="icon"/>
                            </div>
                        </div>
                        <!-- /application-icon -->

                        <span>Технологии</span>
                    </li>
                    <li>

                        <!-- application-icon -->
                        <div class="application-icon">
                            <div>
                                <img src="/assets/img/application-004.jpg" alt="icon"/>
                            </div>
                        </div>
                        <!-- /application-icon -->

                        <span>Маркетинг</span>
                    </li>
                    <li>

                        <!-- application-icon -->
                        <div class="application-icon">
                            <div>
                                <img src="/assets/img/application-005.jpg" alt="icon"/>
                            </div>
                        </div>
                        <!-- /application-icon -->

                        <span>Наука</span>
                    </li>
                </ul>
                <!-- /application-list -->

                <!-- next-step -->
                <div class="next-step"></div>
                <!-- /next-step -->

            </div>
            <!-- /application -->

            <!-- work -->
            <div class="work">

                <!-- site__title -->
                <h2 class="site__title">Как это работает?</h2>
                <!-- site__title -->

                <!-- application__introduction -->
                <div class="work__introduction">
                    <p>Мы максимально упростили процесс перевода сайта для того,чтобы максимально сэкономить ваше время.</p>
                </div>
                <!-- /application__introduction -->

                <!-- work__map -->
                <ul class="work__map">

                    <li>
                        <!-- work__img -->
                        <div class="work__img">
                            <div>
                                <img src="/assets/img/work-001.jpg" alt="img"/>
                            </div>
                        </div>
                        <!-- work__img -->

                        <!-- work__title -->
                        <h3 class="work__title">Добавьте код на свой сайт</h3>
                        <!-- work__title -->

                        <!-- work__number -->
                        <span class="work__number">1</span>
                        <!-- work__number -->

                        <!-- work__content -->
                        <div class="work__content">
                            <p>Система автоматически подготовить ваш сайт к переводу.</p>
                        </div>
                        <!-- /work__content -->

                    </li>

                    <li>
                        <!-- work__img -->
                        <div class="work__img">
                            <div>
                                <img src="/assets/img/work-002.jpg" alt="img"/>
                            </div>
                        </div>
                        <!-- work__img -->

                        <!-- work__title -->
                        <h3 class="work__title">Начните локализацию</h3>
                        <!-- work__title -->

                        <!-- work__number -->
                        <span class="work__number">2</span>
                        <!-- work__number -->

                        <!-- work__content -->
                        <div class="work__content">
                            <p>Теперь вы можете переводить контент вручную или автоматически</p>
                        </div>
                        <!-- /work__content -->

                    </li>

                    <li>
                        <!-- work__img -->
                        <div class="work__img">
                            <div>
                                <img src="/assets/img/work-003.jpg" alt="img"/>
                            </div>
                        </div>
                        <!-- work__img -->

                        <!-- work__title -->
                        <h3 class="work__title">Закажите перевод</h3>
                        <!-- work__title -->

                        <!-- work__number -->
                        <span class="work__number">3</span>
                        <!-- work__number -->

                        <!-- work__content -->
                        <div class="work__content">
                            <p>Вы можете заказать перевод сайта у профессиональных переводчиков нашей компании.</p>
                        </div>
                        <!-- /work__content -->

                    </li>

                </ul>
                <!-- /work__map -->

                <!-- next-step -->
                <div class="next-step"></div>
                <!-- /next-step -->

            </div>
            <!-- /work -->

            <!-- people -->
            <div class="people">

                <!-- site__title -->
                <h2 class="site__title">Люди ждут этот сервис...</h2>
                <!-- site__title -->

                <!-- people__slider -->
                <div class="people__slider swiper-container">

                    <!-- swiper-wrapper -->
                    <div class="swiper-wrapper">

                        <!-- swiper-slide -->
                        <div class="swiper-slide">

                            <!-- people__img -->
                            <div class="people__img" style="background: url('/assets/pic/ava-001.jpg')"></div>
                            <!-- /people__img -->

                            <!-- people__info -->
                            <span class="people__info"><strong>Наталья Иванова</strong>  /  28 лет</span>
                            <!-- /people__info -->

                            <!-- people__post -->
                            <span class="people__post">Руководитель проекта «Сбербанк Онлайн»</span>
                            <!-- /people__post -->

                            <!-- people__content -->
                            <div class="people__content">
                                <p>Сервис, классный! У меня повился шанс сделать свой сайт самой, и то что получилось мне нравиться, конечно есть над чем работать и что тестировать, но самое главное он есть и готов мне приводить клиентов, а значит и деньги!</p>
                            </div>
                            <!-- people__content -->

                        </div>
                        <!-- /swiper-slide -->

                        <!-- swiper-slide -->
                        <div class="swiper-slide">

                            <!-- people__img -->
                            <div class="people__img" style="background: url('/assets/pic/ava-002.jpg')"></div>
                            <!-- /people__img -->

                            <!-- people__info -->
                            <span class="people__info"><strong>Иван Сергеев</strong>  /  59 лет</span>
                            <!-- /people__info -->

                            <!-- people__post -->
                            <span class="people__post">Директор холдинг «Петрушка»</span>
                            <!-- /people__post -->

                            <!-- people__content -->
                            <div class="people__content">
                                <p>Сервис, классный! У меня повился шанс сделать свой сайт самой, и то что получилось мне нравиться, конечно есть над чем работать и что тестировать, но самое главное он есть и готов мне приводить клиентов, а значит и деньги!</p>
                            </div>
                            <!-- people__content -->

                        </div>
                        <!-- /swiper-slide -->

                        <!-- swiper-slide -->
                        <div class="swiper-slide">

                            <!-- people__img -->
                            <div class="people__img" style="background: url('/assets/pic/ava-003.jpg')"></div>
                            <!-- /people__img -->

                            <!-- people__info -->
                            <span class="people__info"><strong>Эмануил Торчовский </strong>  /  38 лет</span>
                            <!-- /people__info -->

                            <!-- people__post -->
                            <span class="people__post">Индивидуальные предприниматель </span>
                            <!-- /people__post -->

                            <!-- people__content -->
                            <div class="people__content">
                                <p>Сервис, классный! У меня повился шанс сделать свой сайт самой, и то что получилось мне нравиться, конечно есть над чем работать и что тестировать, но самое главное он есть и готов мне приводить клиентов, а значит и деньги!</p>
                            </div>
                            <!-- people__content -->

                        </div>
                        <!-- /swiper-slide -->

                    </div>
                    <!-- /swiper-wrapper -->

                    <!-- swiper-button-prev -->
                    <div class="swiper-button-prev button_prev"></div>
                    <!-- /swiper-button-prev -->

                    <!-- swiper-button-next -->
                    <div class="swiper-button-next button_next"></div>
                    <!-- /swiper-button-next -->

                </div>
                <!-- /people__slider -->

            </div>
            <!-- /people -->

        </div>
        <!-- site__wrap -->

        <!-- discount -->
        <div class="discount" id="discount">

            <!-- site__wrap -->
            <div class="site__wrap">

                <!-- discount__layout -->
                <div class="discount__layout">

                    <!-- site__title -->
                    <h2 class="site__title">Получите <span>скидку</span> на локализацию вашего сайта</h2>
                    <!-- /site__title -->

                    <!-- discount__introduction -->
                    <div class="discount__introduction">
                        <p>Заполните форму и когда проект запуститься, у вас будет возможность пользоваться услугами сервиса со скидкой.</p>
                    </div>
                    <!-- /discount__introduction -->

                    <!-- /discount__form -->
                    <div class="discount__form">
                        {!! Form::open(['route' => 'main.get-demo']) !!}

                        <fieldset>
                            <label for="discount__email">Ваша эл. почта *</label>
                            <input type="email" id="discount__email"  placeholder="yourmail@gmai" required/>
                        </fieldset>

                        <fieldset>
                            <label for="discount__name">Имя, фамилия</label>
                            <input type="text" id="discount__name" name="name"/>
                        </fieldset>

                        <fieldset>
                            <label for="discount__address">Адрес вашего сайта *</label>
                            <input type="text" id="discount__address" placeholder="http://yoursite.ru" required name="site"/>
                        </fieldset>

                        <fieldset>
                            <label for="discount__phone">Номер телефона</label>
                            <input type="tel" id="discount__phone" name="phone"/>
                        </fieldset>

                        <fieldset class="discount__language">
                            <!-- options__selects-wrap -->
                            <div class="discount__selects-language" data-language="{
                                        &quot;languages&quot;: [
                                            {
                                                &quot;id&quot;: 1,
                                                &quot;name&quot;: &quot;Английский&quot;,
                                                &quot;src&quot;: &quot;img/icons-en.png&quot;
                                            },
                                            {
                                                &quot;id&quot;: 2,
                                                &quot;name&quot;: &quot;Русский&quot;,
                                                &quot;src&quot;: &quot;img/icons-en.png&quot;
                                            },
                                            {
                                                &quot;id&quot;: 3,
                                                &quot;name&quot;: &quot;Украинский&quot;,
                                                &quot;src&quot;: &quot;img/icons-ua.png&quot;
                                            }
                                        ]
                                        }">
                            </div>
                            <!-- /discount__selects-language -->

                        </fieldset>

                        <!-- btn -->
                        <button class="btn btn_discount">
                            <span>Получить скидку</span>
                        </button>
                        <!-- /btn -->

                        {!! Form::close() !!}
                    </div>
                    <!-- discount__form -->

                </div>
                <!-- /discount__layout -->

                <!-- discount__thanks -->
                <div class="discount__thanks">

                    <img src="/assets/img/img-thanks.png" alt="img"/>

                    <!-- discount__thanks-title -->
                    <h2 class="discount__thanks-title">Спасибо большое за вашу заявку</h2>
                    <!-- /discount__thanks-title -->

                    <p>Мы добавили ваш сайт на просчёт текста. Мы можете посмотреть сколько там страниц, символов, слов и т.д.</p>
                    <p>Мы также выслали вам письмо ссылкой на статистику по вашему сайту.</p>

                    <!-- btn -->
                    <a href="{{route('scan.main')}}" class="btn btn_2">
                        <span>Посмотреть статистику</span>
                    </a>
                    <!-- /btn -->

                </div>
                <!-- /discount__thanks -->

            </div>
            <!-- site__wrap -->

        </div>
        <!-- /discount -->

    </div>
@stop