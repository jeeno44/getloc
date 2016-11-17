@extends('layouts.index2')
@section('title') GETLOC @stop
@section('content')


    <!-- promo -->
    <div class="promo">

        <!-- promo__wrap -->
        <div class="promo__wrap">

            <!-- promo__content -->
            <div class="promo__content">

                <!-- promo__title -->
                <h2 class="promo__title">
                    Надежный <b>инструмент<br/>
                        для локализации</b> вашего <b>сайта</b>
                </h2>
                <!-- /promo__title -->

                <p>Сделайте ваш сайт доступным для всех прямо сейчас!</p>

            </div>
            <!-- /promo__content -->

            <!-- promo__form -->
            <form method="get" action="/" class="promo__form" novalidate>

                <!-- promo__input -->
                <fieldset class="promo__input">
                    <input type="url" placeholder="Адрес вашего сайта" id="form__url" required />
                    <label class="promo__label" for="form__url">Введите адрес вашего сайта</label>
                </fieldset>
                <!-- /promo__input -->

                <button type="submit" class="btn btn_1">
                    <span>Начать локализацию</span>
                </button>

            </form>
            <!-- /promo__form -->

        </div>
        <!-- /promo__wrap -->

    </div>
    <!-- /promo -->

    <!-- capabilities -->
    <div class="capabilities">

        <!-- capabilities__wrap -->
        <div class="capabilities__wrap">

            <!-- capabilities__item -->
            <article class="capabilities__item">

                <!-- capabilities__item-content -->
                <div class="capabilities__item-content">

                    <h2 class="capabilities__item-topic">Подсчёт количества слов</h2>

                    <p>Как только вы введете адрес сайта, платформа getLoc начнет его анализ и подсчитает объём информации для перевода</p>

                </div>
                <!-- /capabilities__item-content -->

                <!-- capabilities__item-img -->
                <div class="capabilities__item-img">
                    <img src="/assets/new/img/img-001.png" alt="img"/>
                </div>

            </article>
            <!-- /capabilities__item -->

            <!-- capabilities__item -->
            <article class="capabilities__item">

                <!-- capabilities__item-content -->
                <div class="capabilities__item-content">

                    <h2 class="capabilities__item-topic">Экспорт контента в XLIFF</h2>

                    <p>Весь текст сайта можно экспортировать в формат XLIFF для дальнейшей работы с ним в платформах для перевода</p>

                </div>
                <!-- /capabilities__item-content -->

                <!-- capabilities__item-img -->
                <div class="capabilities__item-img">
                    <img src="/assets/new/img/img-002.png" alt="img"/>
                </div>

            </article>
            <!-- /capabilities__item -->

            <!-- capabilities__item -->
            <article class="capabilities__item">

                <!-- capabilities__item-content -->
                <div class="capabilities__item-content">

                    <h2 class="capabilities__item-topic">Внедрение перевода на сайт</h2>

                    <p>Для того, чтобы настроить перевод не требуется технический специалист. Весь процесс внедрения занимает не более 10 минут</p>

                </div>
                <!-- /capabilities__item-content -->

                <!-- capabilities__item-img -->
                <div class="capabilities__item-img">
                    <img src="/assets/new/img/img-003.png" alt="img"/>
                </div>

            </article>
            <!-- /capabilities__item -->

            <!-- btn -->
            <a href="#" class="btn btn_3">Узнать все возможности</a>
            <!-- /btn -->

        </div>
        <!-- /capabilities__wrap -->

    </div>
    <!-- /capabilities -->

    <!-- form -->
    <section class="form">

        <!-- form__title -->
        <div class="form__title">
            <h2>Есть вопросы? Пишите!</h2>
            <p>Мы ответим на них как можно скорее</p>
        </div>
        <!-- /form__title -->

        <!-- form__wrap -->
        <form method="get" action="/" novalidate class="form__wrap">

            <!-- form__inputs -->
            <div class="form__inputs">

                <fieldset>
                    <input type="text" class="form__name" id="form__name" required placeholder="Как вас зовут? *"/>
                </fieldset>
                <fieldset>
                    <input type="email" class="form__email" id="form__email" required placeholder="Эл. почта *"/>
                </fieldset>
                <fieldset>
                    <input type="tel" class="form__phone" id="form__phone" placeholder="Ваш телефон"/>
                </fieldset>

            </div>
            <!-- /form__inputs -->

            <fieldset>
                <textarea class="form__message" id="form__message" required placeholder="Чем мы можем вам помочь? *"></textarea>
            </fieldset>

            <!-- form__btn-wrap -->
            <div class="form__btn-wrap">
                <button type="submit" id="form__order" class="btn btn_4">
                    <span>Отправить</span>
                </button>
            </div>
            <!-- /form__btn-wrap -->

        </form>
        <!-- /form__wrap -->

        <div class="form__thanks">

            <!-- form__title -->
            <div class="form__title">
                <h2>Спасибо большое за ваше обращение!</h2>
                <p>В ближайшее время мы с вами свяжемся!</p>
            </div>
            <!-- /form__title -->

            <a href="#" class="btn btn_4 form__more">Написать еще</a>

        </div>

    </section>
    <!-- /form -->




    {{--<div class="site__content">--}}
        {{--<div class="promo">--}}
            {{--<div class="site__wrap">--}}
                {{--<div class="promo__content">--}}
                    {{--<h2 class="promo__title">{{trans('phrases.multi_site')}} <span>{{trans('phrases.it_easy')}}</span></h2>--}}
                    {{--<div class="promo__text">--}}
                        {{--{!!trans('phrases.good_solution')!!}--}}
                    {{--</div>--}}
                    {{--<a class="promo__more anchor" data-href="#advantages">{{trans('phrases.know_more')}}</a>--}}
                {{--</div>--}}
                {{--<div class="gallery" data-duration="3000">--}}
                    {{--<div class="gallery__item">--}}
                        {{--<img class="gallery__item_2nd" src="/assets/pic/gallery__pic-2.png" width="500" height="256">--}}
                        {{--<img class="gallery__item_1st" src="/assets/pic/gallery__pic-1.png" width="554" height="399">--}}
                    {{--</div>--}}
                    {{--<div class="gallery__item">--}}
                        {{--<img class="gallery__item_3rd" src="/assets/pic/gallery__pic-5.png" width="500" height="265">--}}
                        {{--<img class="gallery__item_2nd" src="/assets/pic/gallery__pic-4.png" width="500" height="269">--}}
                        {{--<img class="gallery__item_1st gallery__item_1st_right" src="/assets/pic/gallery__pic-3.png" width="468" height="398">--}}
                    {{--</div>--}}
                    {{--<div class="gallery__prev">{{trans('phrases.prev')}}</div>--}}
                    {{--<div class="gallery__next">{{trans('phrases.next')}}</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="enroll">--}}
            {{--<div class="site__wrap">--}}
                {{--<div class="enroll__content">--}}
                    {{--<p>{{trans('phrases.now_doing_tests')}} <b>{{$sites}}</b> {{trans_choice('phrases.count_sites', $sites)}}</p>--}}
                    {{--<a data-href="#discount" class="anchor">{{trans('phrases.request_to_testing')}}</a>--}}
                    {{--<span class="enroll__start">{{trans('phrases.start_date')}} – {{trans('phrases.march_2016')}}</span>--}}
                {{--</div>--}}
                {{--<div class="enroll__form">--}}
                    {{--{!! Form::open(['route' => 'main.call-me']) !!}--}}
                    {{--<fieldset class="enroll__email-box">--}}
                        {{--<input type="email" id="enroll__email" placeholder="{{trans('phrases.your_email')}}" class="enroll__email" required/>--}}
                    {{--</fieldset>--}}
                    {{--<button class="btn btn_enroll">--}}
                        {{--<span>{{trans('phrases.call_me_about_start')}}</span>--}}
                    {{--</button>--}}
                    {{--{!! Form::close() !!}--}}
                {{--</div>--}}
                {{--<div class="enroll__thanks">--}}
                    {{--<span class="enroll__thanks-title">{{trans('phrases.thanks_for_request')}}</span>--}}
                    {{--<p>{{trans('phrases.we_assure_you')}}</p>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="site__wrap">--}}
            {{--<div class="advantages" id="advantages">--}}
                {{--<h2 class="site__title"><strong>getLoc</strong> {{trans('phrases.help_to_translate')}}</h2>--}}
                {{--<div class="advantages__introduction">--}}
                    {{--{!!trans('phrases.great_need_for')!!}--}}
                {{--</div>--}}
                {{--<ul class="advantages__items">--}}
                    {{--<li>--}}
                        {{--<div class="advantages__img">--}}
                            {{--<img src="/assets/img/advantages-001.jpg" alt="img"/>--}}
                        {{--</div>--}}
                        {{--<h3 class="advantages__title">{!!trans('phrases.full_auto')!!}</h3>--}}
                        {{--<p>{!!trans('phrases.process_build_tak')!!}</p>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<div class="advantages__img">--}}
                            {{--<img src="/assets/img/advantages-002.jpg" alt="img"/>--}}
                        {{--</div>--}}
                        {{--<h3 class="advantages__title">{!!trans('phrases.easy_setting')!!}</h3>--}}
                        {{--<p>{!!trans('phrases.for_setting_translate')!!}</p>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<div class="advantages__img">--}}
                            {{--<img src="/assets/img/advantages-003.jpg" alt="img"/>--}}
                        {{--</div>--}}
                        {{--<h3 class="advantages__title">{!!trans('phrases.important_views')!!}</h3>--}}
                        {{--<p>{!!trans('phrases.you_have_change')!!}</p>--}}
                    {{--</li>--}}
                {{--</ul>--}}
                {{--<a href="{{route('main.feature')}}"  class="btn btn_1"><span>{{trans('phrases.all_capabilities')}}</span></a>--}}
                {{--<div class="next-step"></div>--}}
            {{--</div>--}}
            {{--<div class="application">--}}
                {{--<h2 class="site__title">{{trans('phrases.where_use')}}</h2>--}}
                {{--<div class="application__introduction">--}}
                    {{--<p>{!!trans('phrases.has_many_departments')!!}--}}
                {{--</div>--}}
                {{--<ul class="application-list">--}}
                    {{--<li>--}}
                        {{--<div class="application-icon">--}}
                            {{--<div>--}}
                                {{--<img src="/assets/img/application-001.jpg" alt="icon"/>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<span>{{trans('phrases.culture')}}</span>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<div class="application-icon">--}}
                            {{--<div>--}}
                                {{--<img src="/assets/img/application-002.jpg" alt="icon"/>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<span>{{trans('phrases.business')}}</span>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<div class="application-icon">--}}
                            {{--<div>--}}
                                {{--<img src="/assets/img/application-003.jpg" alt="icon"/>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<span>{{trans('phrases.technologies')}}</span>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<div class="application-icon">--}}
                            {{--<div>--}}
                                {{--<img src="/assets/img/application-004.jpg" alt="icon"/>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<span>{{trans('phrases.marketing')}}</span>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<div class="application-icon">--}}
                            {{--<div>--}}
                                {{--<img src="/assets/img/application-005.jpg" alt="icon"/>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<span>{{trans('phrases.science')}}</span>--}}
                    {{--</li>--}}
                {{--</ul>--}}
                {{--<div class="next-step"></div>--}}
            {{--</div>--}}
            {{--<div class="work">--}}
                {{--<h2 class="site__title">{{trans('phrases.how_it_works')}}</h2>--}}
                {{--<div class="work__introduction">--}}
                    {{--<p>{!!trans('phrases.we_max_easy')!!}</p>--}}
                {{--</div>--}}
                {{--<ul class="work__map">--}}
                    {{--<li>--}}
                        {{--<div class="work__img">--}}
                            {{--<div>--}}
                                {{--<img src="/assets/img/work-001.jpg" alt="img"/>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<h3 class="work__title">{{trans('phrases.insert_your_code')}}</h3>--}}
                        {{--<span class="work__number">1</span>--}}
                        {{--<div class="work__content">--}}
                            {{--<p>{{trans('phrases.system_auto_prepare')}}</p>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<div class="work__img">--}}
                            {{--<div>--}}
                                {{--<img src="/assets/img/work-002.jpg" alt="img"/>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<h3 class="work__title">{{trans('phrases.start_localise')}}</h3>--}}
                        {{--<span class="work__number">2</span>--}}
                        {{--<div class="work__content">--}}
                            {{--<p>{{trans('phrases.now_you_can_translate')}}</p>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<div class="work__img">--}}
                            {{--<div>--}}
                                {{--<img src="/assets/img/work-003.jpg" alt="img"/>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<h3 class="work__title">{{trans('phrases.order_translate')}}</h3>--}}
                        {{--<span class="work__number">3</span>--}}
                        {{--<div class="work__content">--}}
                            {{--<p>{{trans('phrases.you_can_order_translate')}}</p>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                {{--</ul>--}}
                {{--<a class="btn btn_1 popup__open" data-popup="registry" href="#"><span>{{trans('account.t_main_reg')}}</span></a>--}}
                {{--<div class="next-step"></div>--}}
            {{--</div>--}}
            {{--<div class="people">--}}
                {{--<h2 class="site__title">{{trans('phrases.peoples_waiting')}}</h2>--}}
                {{--<div class="people__slider swiper-container">--}}
                    {{--<div class="swiper-wrapper">--}}
                        {{--<div class="swiper-slide">--}}
                            {{--<div class="people__img" style="background: url('/assets/pic/review_1.jpg')"></div>--}}
                            {{--<span class="people__info"><strong>{{trans('phrases.review_1_person')}}</strong></span>--}}
                            {{--<span class="people__post">{{trans('phrases.review_1_post')}}</span>--}}
                            {{--<div class="people__content">--}}
                                {{--<p>{!!trans('phrases.review_1_text')!!}</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="swiper-slide">--}}
                            {{--<div class="people__img" style="background: url('/assets/pic/review_2.jpg')"></div>--}}
                            {{--<span class="people__info"><strong>{{trans('phrases.review_2_person')}}</strong></span>--}}
                            {{--<span class="people__post">{{trans('phrases.review_2_post')}}</span>--}}
                            {{--<div class="people__content">--}}
                                {{--<p>{!!trans('phrases.review_2_text')!!}</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="swiper-slide">--}}
                            {{--<div class="people__img" style="background: url('/assets/pic/review_3.jpg')"></div>--}}
                            {{--<span class="people__info"><strong>{{trans('phrases.review_3_person')}}</strong></span>--}}
                            {{--<span class="people__post">{{trans('phrases.review_3_post')}}</span>--}}
                            {{--<div class="people__content">--}}
                                {{--<p>{!!trans('phrases.review_3_text')!!}</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="swiper-button-prev button_prev"></div>--}}
                    {{--<div class="swiper-button-next button_next"></div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="discount" id="discount">--}}
            {{--<div class="site__wrap">--}}
                {{--<div class="discount__layout">--}}
                    {{--<h2 class="site__title">{{trans('account.t_main_get')}} <span>{{trans('account.t_main_skidka')}}</span> {{trans('account.t_main_localize')}}</h2>--}}
                    {{--<div class="discount__introduction">--}}
                        {{--<p>{{trans('account.t_main_form')}}</p>--}}
                    {{--</div>--}}
                    {{--<div class="discount__form">--}}
                        {{--{!! Form::open(['route' => 'main.get-demo', 'novalidate']) !!}--}}
                            {{--<fieldset>--}}
                                {{--<label for="discount__email">{{trans('account.t_login_email')}}</label>--}}
                                {{--<input type="email" id="discount__email"  placeholder="yourmail@gmai" required/>--}}
                            {{--</fieldset>--}}
                            {{--<fieldset>--}}
                                {{--<label for="discount__name">{{trans('account.t_main_fio')}}</label>--}}
                                {{--<input type="text" id="discount__name"/>--}}
                            {{--</fieldset>--}}
                            {{--<fieldset>--}}
                                {{--<label for="discount__address">{{trans('account.t_main_site_link')}}</label>--}}
                                {{--<input type="text" id="discount__address" placeholder="http://yoursite.ru" required/>--}}
                            {{--</fieldset>--}}
                            {{--<fieldset>--}}
                                {{--<label for="discount__phone">{{trans('account.t_main_phone')}}</label>--}}
                                {{--<input type="tel" id="discount__phone"/>--}}
                            {{--</fieldset>--}}
                            {{--<fieldset class="discount__language">--}}
                                {{--<label>{{trans('account.t_index_lang_translate')}}</label>--}}
                                {{--<div class="discount__selects-language" data-language='{{getLanguagesJson()}}'>--}}
                                    {{--<div class="discount__language-wrapper">--}}
                                        {{--<select name="lang_1" id="lang_1" required>--}}
                                            {{--<option value="0">{{trans('account.t_create_project_select_lang')}}</option>--}}
                                        {{--</select>--}}
                                        {{--<a href="#" class="discount__languadge-add">{{trans('account.t_create_project_add_lang_trans')}}</a>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</fieldset>--}}
                            {{--<button class="btn btn_discount">--}}
                                {{--<span>{{trans('phrases.get_discount')}}</span>--}}
                            {{--</button>--}}
                        {{--{!! Form::close() !!}--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="discount__thanks">--}}
                    {{--<img src="/assets/img/img-thanks.png" alt="img"/>--}}
                    {{--<h2 class="discount__thanks-title">{{trans('account.t_main_thx')}}</h2>--}}
                    {{--<p>{{trans('account.t_main_thx_text1')}}</p>--}}
                    {{--<p>{{trans('account.t_main_thx_text2')}}</p>--}}
                    {{--<a href="{{route('scan.main')}}" class="btn btn_2">--}}
                        {{--<span>{{trans('account.t_main_stat')}}</span>--}}
                    {{--</a>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
@stop