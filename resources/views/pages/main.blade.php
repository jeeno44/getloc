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
                    <h2 class="promo__title">{{trans('phrases.multi_site')}} <span>{{trans('phrases.it_easy')}}</span></h2>
                    <!-- /promo__title -->

                    <!-- promo__text -->
                    <div class="promo__text">
                        {!!trans('phrases.good_solution')!!}
                    </div>
                    <!-- /promo__text -->

                    <!-- promo__more -->
                    <a class="promo__more anchor" data-href="#advantages">{{trans('phrases.know_more')}}</a>
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
                    <div class="gallery__prev">{{trans('phrases.prev')}}</div>
                    <!-- /gallery__prev -->

                    <!-- gallery__next -->
                    <div class="gallery__next">{{trans('phrases.next')}}</div>
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
                    <p>{{trans('phrases.now_doing_tests')}} <b>{{$sites}}</b> {{trans_choice('phrases.count_sites', $sites)}}</p>
                    <a data-href="#discount" class="anchor">{{trans('phrases.request_to_testing')}}</a>
                    <span class="enroll__start">{{trans('phrases.start_date')}} – {{trans('phrases.march_2016')}}</span>
                </div>
                <!-- /enroll__content -->

                <!-- enroll__form -->
                <div class="enroll__form">
                    {!! Form::open(['route' => 'main.call-me']) !!}
                            <!-- enroll__email-box -->
                    <fieldset class="enroll__email-box">
                        <input type="email" id="enroll__email" placeholder="{{trans('phrases.your_email')}}" class="enroll__email" required/>
                    </fieldset>
                    <!-- /enroll__email-box -->

                    <!-- btn -->
                    <button class="btn btn_enroll">
                        <span>{{trans('phrases.call_me_about_start')}}</span>
                    </button>
                    <!-- /btn -->
                    {!! Form::close() !!}
                </div>
                <!-- /enroll__form -->

                <!-- enroll__thanks -->
                <div class="enroll__thanks">
                    <span class="enroll__thanks-title"></span>
                    <p>{{trans('phrases.we_assure_you')}}</p>
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
                <h2 class="site__title"><strong>getLoc</strong> {{trans('phrases.help_to_translate')}}</h2>
                <!-- site__title -->

                <!-- advantages__introduction -->
                <div class="advantages__introduction">
                    {!!trans('phrases.great_need_for')!!}
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
                        <h3 class="advantages__title">{!!trans('phrases.full_auto')!!}</h3>
                        <!-- /advantages__title -->

                        <p>{!!trans('phrases.process_build_tak')!!}</p>
                    </li>
                    <li>

                        <!-- advantages__img -->
                        <div class="advantages__img">
                            <img src="/assets/img/advantages-002.jpg" alt="img"/>
                        </div>
                        <!-- /advantages__img -->

                        <!-- advantages__title -->
                        <h3 class="advantages__title">{!!trans('phrases.easy_setting')!!}</h3>
                        <!-- /advantages__title -->

                        <p>{!!trans('phrases.for_setting_translate')!!}</p>
                    </li>
                    <li>

                        <!-- advantages__img -->
                        <div class="advantages__img">
                            <img src="/assets/img/advantages-003.jpg" alt="img"/>
                        </div>
                        <!-- /advantages__img -->

                        <!-- advantages__title -->
                        <h3 class="advantages__title">{!!trans('phrases.important_views')!!}</h3>
                        <!-- /advantages__title -->

                        <p>{!!trans('phrases.you_have_change')!!}</p>
                    </li>
                </ul>
                <!-- /advantages__items -->

                <!-- btn -->
                <a href="{{route('main.feature')}}"  class="btn btn_1"><span>{{trans('phrases.all_capabilities')}}</span></a>
                <!-- /btn -->

                <!-- next-step -->
                <div class="next-step"></div>
                <!-- /next-step -->

            </div>
            <!-- /advantages -->

            <!-- application -->
            <div class="application">

                <!-- site__title -->
                <h2 class="site__title">{{trans('phrases.where_use')}}</h2>
                <!-- site__title -->

                <!-- application__introduction -->
                <div class="application__introduction">
                    <p>{!!trans('phrases.has_many_departments')!!}
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

                        <span>{{trans('phrases.culture')}}</span>
                    </li>
                    <li>

                        <!-- application-icon -->
                        <div class="application-icon">
                            <div>
                                <img src="/assets/img/application-002.jpg" alt="icon"/>
                            </div>
                        </div>
                        <!-- /application-icon -->

                        <span>{{trans('phrases.business')}}</span>
                    </li>
                    <li>

                        <!-- application-icon -->
                        <div class="application-icon">
                            <div>
                                <img src="/assets/img/application-003.jpg" alt="icon"/>
                            </div>
                        </div>
                        <!-- /application-icon -->

                        <span>{{trans('phrases.technologies')}}</span>
                    </li>
                    <li>

                        <!-- application-icon -->
                        <div class="application-icon">
                            <div>
                                <img src="/assets/img/application-004.jpg" alt="icon"/>
                            </div>
                        </div>
                        <!-- /application-icon -->

                        <span>{{trans('phrases.marketing')}}</span>
                    </li>
                    <li>

                        <!-- application-icon -->
                        <div class="application-icon">
                            <div>
                                <img src="/assets/img/application-005.jpg" alt="icon"/>
                            </div>
                        </div>
                        <!-- /application-icon -->

                        <span>{{trans('phrases.science')}}</span>
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
                <h2 class="site__title">{{trans('phrases.how_it_works')}}</h2>
                <!-- site__title -->

                <!-- application__introduction -->
                <div class="work__introduction">
                    <p>{{trans('phrases.we_max_easy')}}</p>
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
                        <h3 class="work__title">{{trans('phrases.insert_your_code')}}</h3>
                        <!-- work__title -->

                        <!-- work__number -->
                        <span class="work__number">1</span>
                        <!-- work__number -->

                        <!-- work__content -->
                        <div class="work__content">
                            <p>{{trans('phrases.system_auto_prepare')}}</p>
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
                        <h3 class="work__title">{{trans('phrases.start_localise')}}</h3>
                        <!-- work__title -->

                        <!-- work__number -->
                        <span class="work__number">2</span>
                        <!-- work__number -->

                        <!-- work__content -->
                        <div class="work__content">
                            <p>{{trans('phrases.now_you_can_translate')}}</p>
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
                        <h3 class="work__title">{{trans('phrases.order_translate')}}</h3>
                        <!-- work__title -->

                        <!-- work__number -->
                        <span class="work__number">3</span>
                        <!-- work__number -->

                        <!-- work__content -->
                        <div class="work__content">
                            <p>{{trans('phrases.you_can_order_translate')}}</p>
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
                <h2 class="site__title">{{trans('phrases.peoples_waiting')}}</h2>
                <!-- site__title -->

                <!-- people__slider -->
                <div class="people__slider swiper-container">

                    <!-- swiper-wrapper -->
                    <div class="swiper-wrapper">

                        <!-- swiper-slide -->
                        <div class="swiper-slide">

                            <!-- people__img -->
                            <div class="people__img" style="background: url('/assets/pic/review_1.jpg')"></div>
                            <!-- /people__img -->

                            <!-- people__info -->
                            <span class="people__info"><strong>{{trans('phrases.review_1_person')}}</strong> / 36 {{trans('phrases.years_old')}}</span>
                            <!-- /people__info -->

                            <!-- people__post -->
                            <span class="people__post">{{trans('phrases.review_1_post')}}</span>
                            <!-- /people__post -->

                            <!-- people__content -->
                            <div class="people__content">
                                <p>{!!trans('phrases.review_1_text')!!}</p>
                            </div>
                            <!-- people__content -->

                        </div>
                        <!-- /swiper-slide -->

                        <!-- swiper-slide -->
                        <div class="swiper-slide">

                            <!-- people__img -->
                            <div class="people__img" style="background: url('/assets/pic/review_2.jpg')"></div>
                            <!-- /people__img -->

                            <!-- people__info -->
                            <span class="people__info"><strong>{{trans('phrases.review_2_person')}}</strong></span>
                            <!-- /people__info -->

                            <!-- people__post -->
                            <span class="people__post">{{trans('phrases.review_2_post')}}</span>
                            <!-- /people__post -->

                            <!-- people__content -->
                            <div class="people__content">
                                <p>{!!trans('phrases.review_2_text')!!}</p>
                            </div>
                            <!-- people__content -->

                        </div>
                        <!-- /swiper-slide -->

						<!-- swiper-slide -->
                        <div class="swiper-slide">

                            <!-- people__img -->
                            <div class="people__img" style="background: url('/assets/pic/review_3.jpg')"></div>
                            <!-- /people__img -->

                            <!-- people__info -->
                            <span class="people__info"><strong>{{trans('phrases.review_3_person')}}</strong> / 35 {{trans('phrases.years_old')}}</span>
                            <!-- /people__info -->

                            <!-- people__post -->
                            <span class="people__post">{{trans('phrases.review_3_post')}}</span>
                            <!-- /people__post -->

                            <!-- people__content -->
                            <div class="people__content">
                                <p>{!!trans('phrases.review_3_text')!!}</p>
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
                    <h2 class="site__title">{!!trans('phrases.demo_request')!!}</h2>
                    <!-- /site__title -->

                    <!-- discount__introduction -->
                    <div class="discount__introduction">
                        <p>{!!trans('phrases.write_form')!!}</p>
                    </div>
                    <!-- /discount__introduction -->

                    <!-- /discount__form -->
                    <div class="discount__form">
                        {!! Form::open(['route' => 'main.get-demo']) !!}

                        <fieldset>
                            <label for="discount__email">{{trans('phrases.your_email')}}</label>
                            <input type="email" id="discount__email"  placeholder="yourmail@site.com" required/>
                        </fieldset>

                        <fieldset>
                            <label for="discount__name">{{trans('phrases.name_last_name')}}</label>
                            <input type="text" id="discount__name" name="name"/>
                        </fieldset>

                        <fieldset>
                            <label for="discount__address">{{trans('phrases.site_address')}}</label>
                            <input type="text" id="discount__address" placeholder="http://yoursite.com" required name="site"/>
                        </fieldset>

                        <fieldset>
                            <label for="discount__phone">{{trans('phrases.phone_number')}}</label>
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
                            <span>{{trans('phrases.get_discount')}}</span>
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
                    <h2 class="discount__thanks-title">{{trans('phrases.big_thanks_for_request')}}</h2>
                    <!-- /discount__thanks-title -->

                    <p>{{trans('phrases.we_create_project')}}</p>
                    <p>{{trans('phrases.we_send_letter')}}</p>

                    <!-- btn -->
                    <a href="{{route('scan.main')}}" class="btn btn_2">
                        <span>{{trans('phrases.show_stat')}}</span>
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