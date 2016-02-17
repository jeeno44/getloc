@extends('layouts.index')
@section('title') GETLOC @stop
@section('content')
    <div class="site__content">
        <div class="promo">
            <div class="site__wrap">
                <div class="promo__content">
                    <h2 class="promo__title">{{trans('phrases.multi_site')}} <span>{{trans('phrases.it_easy')}}</span></h2>
                    <div class="promo__text">
                        {!!trans('phrases.good_solution')!!}
                    </div>
                    <a class="promo__more anchor" data-href="#advantages">{{trans('phrases.know_more')}}</a>
                </div>
                <div class="gallery" data-duration="3000">
                    <div class="gallery__item">
                        <img class="gallery__item_2nd" src="/assets/pic/gallery__pic-2.png" width="500" height="256">
                        <img class="gallery__item_1st" src="/assets/pic/gallery__pic-1.png" width="554" height="399">
                    </div>
                    <div class="gallery__item">
                        <img class="gallery__item_3rd" src="/assets/pic/gallery__pic-5.png" width="500" height="265">
                        <img class="gallery__item_2nd" src="/assets/pic/gallery__pic-4.png" width="500" height="269">
                        <img class="gallery__item_1st gallery__item_1st_right" src="/assets/pic/gallery__pic-3.png" width="468" height="398">
                    </div>
                    <div class="gallery__prev">{{trans('phrases.prev')}}</div>
                    <div class="gallery__next">{{trans('phrases.next')}}</div>
                </div>
            </div>
        </div>
        <div class="enroll">
            <div class="site__wrap">
                <div class="enroll__content">
                    <p>{{trans('phrases.now_doing_tests')}} <b>{{$sites}}</b> {{trans_choice('phrases.count_sites', $sites)}}</p>
                    <a data-href="#discount" class="anchor">{{trans('phrases.request_to_testing')}}</a>
                    <span class="enroll__start">{{trans('phrases.start_date')}} – {{trans('phrases.march_2016')}}</span>
                </div>
                <div class="enroll__form">
                    {!! Form::open(['route' => 'main.call-me']) !!}
                    <fieldset class="enroll__email-box">
                        <input type="email" id="enroll__email" placeholder="{{trans('phrases.your_email')}}" class="enroll__email" required/>
                    </fieldset>
                    <button class="btn btn_enroll">
                        <span>{{trans('phrases.call_me_about_start')}}</span>
                    </button>
                    {!! Form::close() !!}
                </div>
                <div class="enroll__thanks">
                    <span class="enroll__thanks-title"></span>
                    <p>{{trans('phrases.we_assure_you')}}</p>
                </div>
            </div>
        </div>
        <div class="site__wrap">
            <div class="advantages" id="advantages">
                <h2 class="site__title"><strong>getLoc</strong> {{trans('phrases.help_to_translate')}}</h2>
                <div class="advantages__introduction">
                    {!!trans('phrases.great_need_for')!!}
                </div>
                <ul class="advantages__items">
                    <li>
                        <div class="advantages__img">
                            <img src="/assets/img/advantages-001.jpg" alt="img"/>
                        </div>
                        <h3 class="advantages__title">{!!trans('phrases.full_auto')!!}</h3>
                        <p>{!!trans('phrases.process_build_tak')!!}</p>
                    </li>
                    <li>
                        <div class="advantages__img">
                            <img src="/assets/img/advantages-002.jpg" alt="img"/>
                        </div>
                        <h3 class="advantages__title">{!!trans('phrases.easy_setting')!!}</h3>
                        <p>{!!trans('phrases.for_setting_translate')!!}</p>
                    </li>
                    <li>
                        <div class="advantages__img">
                            <img src="/assets/img/advantages-003.jpg" alt="img"/>
                        </div>
                        <h3 class="advantages__title">{!!trans('phrases.important_views')!!}</h3>
                        <p>{!!trans('phrases.you_have_change')!!}</p>
                    </li>
                </ul>
                <a href="{{route('main.feature')}}"  class="btn btn_1"><span>{{trans('phrases.all_capabilities')}}</span></a>
                <div class="next-step"></div>
            </div>
            <div class="application">
                <h2 class="site__title">{{trans('phrases.where_use')}}</h2>
                <div class="application__introduction">
                    <p>{!!trans('phrases.has_many_departments')!!}
                </div>
                <ul class="application-list">
                    <li>
                        <div class="application-icon">
                            <div>
                                <img src="/assets/img/application-001.jpg" alt="icon"/>
                            </div>
                        </div>
                        <span>{{trans('phrases.culture')}}</span>
                    </li>
                    <li>
                        <div class="application-icon">
                            <div>
                                <img src="/assets/img/application-002.jpg" alt="icon"/>
                            </div>
                        </div>
                        <span>{{trans('phrases.business')}}</span>
                    </li>
                    <li>
                        <div class="application-icon">
                            <div>
                                <img src="/assets/img/application-003.jpg" alt="icon"/>
                            </div>
                        </div>
                        <span>{{trans('phrases.technologies')}}</span>
                    </li>
                    <li>
                        <div class="application-icon">
                            <div>
                                <img src="/assets/img/application-004.jpg" alt="icon"/>
                            </div>
                        </div>
                        <span>{{trans('phrases.marketing')}}</span>
                    </li>
                    <li>
                        <div class="application-icon">
                            <div>
                                <img src="/assets/img/application-005.jpg" alt="icon"/>
                            </div>
                        </div>
                        <span>{{trans('phrases.science')}}</span>
                    </li>
                </ul>
                <div class="next-step"></div>
            </div>
            <div class="work">
                <h2 class="site__title">{{trans('phrases.how_it_works')}}</h2>
                <div class="work__introduction">
                    <p>{{trans('phrases.we_max_easy')}}</p>
                </div>
                <ul class="work__map">
                    <li>
                        <div class="work__img">
                            <div>
                                <img src="/assets/img/work-001.jpg" alt="img"/>
                            </div>
                        </div>
                        <h3 class="work__title">{{trans('phrases.insert_your_code')}}</h3>
                        <span class="work__number">1</span>
                        <div class="work__content">
                            <p>{{trans('phrases.system_auto_prepare')}}</p>
                        </div>
                    </li>
                    <li>
                        <div class="work__img">
                            <div>
                                <img src="/assets/img/work-002.jpg" alt="img"/>
                            </div>
                        </div>
                        <h3 class="work__title">{{trans('phrases.start_localise')}}</h3>
                        <span class="work__number">2</span>
                        <div class="work__content">
                            <p>{{trans('phrases.now_you_can_translate')}}</p>
                        </div>
                    </li>
                    <li>
                        <div class="work__img">
                            <div>
                                <img src="/assets/img/work-003.jpg" alt="img"/>
                            </div>
                        </div>
                        <h3 class="work__title">{{trans('phrases.order_translate')}}</h3>
                        <span class="work__number">3</span>
                        <div class="work__content">
                            <p>{{trans('phrases.you_can_order_translate')}}</p>
                        </div>
                    </li>
                </ul>
                <div class="next-step"></div>
            </div>
            <div class="people">
                <h2 class="site__title">{{trans('phrases.peoples_waiting')}}</h2>
                <div class="people__slider swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="people__img" style="background: url('/assets/pic/review_1.jpg')"></div>
                            <span class="people__info"><strong>{{trans('phrases.review_1_person')}}</strong> / 36 {{trans('phrases.years_old')}}</span>
                            <span class="people__post">{{trans('phrases.review_1_post')}}</span>
                            <div class="people__content">
                                <p>{!!trans('phrases.review_1_text')!!}</p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="people__img" style="background: url('/assets/pic/review_2.jpg')"></div>
                            <span class="people__info"><strong>{{trans('phrases.review_2_person')}}</strong></span>
                            <span class="people__post">{{trans('phrases.review_2_post')}}</span>
                            <div class="people__content">
                                <p>{!!trans('phrases.review_2_text')!!}</p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="people__img" style="background: url('/assets/pic/review_3.jpg')"></div>
                            <span class="people__info"><strong>{{trans('phrases.review_3_person')}}</strong> / 35 {{trans('phrases.years_old')}}</span>
                            <span class="people__post">{{trans('phrases.review_3_post')}}</span>
                            <div class="people__content">
                                <p>{!!trans('phrases.review_3_text')!!}</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-button-prev button_prev"></div>
                    <div class="swiper-button-next button_next"></div>
                </div>
            </div>
        </div>
        <div class="discount" id="discount">
            <div class="site__wrap">
                <div class="discount__layout">
                    <h2 class="site__title">Получите <span>скидку</span> на локализацию вашего сайта</h2>
                    <div class="discount__introduction">
                        <p>Заполните форму и когда проект запуститься, у вас будет возможность пользоваться услугами сервиса со скидкой.</p>
                    </div>
                    <div class="discount__form">
                        {!! Form::open(['route' => 'main.get-demo', 'novalidate']) !!}
                            <fieldset>
                                <label for="discount__email">Ваша эл. почта *</label>
                                <input type="email" id="discount__email"  placeholder="yourmail@gmai" required/>
                            </fieldset>
                            <fieldset>
                                <label for="discount__name">Имя, фамилия</label>
                                <input type="text" id="discount__name"/>
                            </fieldset>
                            <fieldset>
                                <label for="discount__address">Адрес вашего сайта *</label>
                                <input type="text" id="discount__address" placeholder="http://yoursite.ru" required/>
                            </fieldset>
                            <fieldset>
                                <label for="discount__phone">Номер телефона</label>
                                <input type="tel" id="discount__phone"/>
                            </fieldset>
                            <fieldset class="discount__language">
                                <label>Язык перевода *</label>
                                <div class="discount__selects-language" data-language='{
                                        "languages": [
                                            {
                                                "id": 1,
                                                "name": "Английский",
                                                "src": "/assets/img/icons-en.png"
                                            },
                                            {
                                                "id": 2,
                                                "name": "Русский",
                                                "src": "/assets/img/icons-en.png"
                                            },
                                            {
                                                "id": 3,
                                                "name": "Украинский",
                                                "src": "/assets/img/icons-ua.png"
                                            }
                                        ]
                                        }'>
                                    <div class="discount__language-wrapper">
                                        <select name="lang_1" id="lang_1" required>
                                            <option value="0">Выберите язык</option>
                                        </select>
                                        <a href="#" class="discount__languadge-add">Добавить язык перевода</a>
                                    </div>
                                </div>
                            </fieldset>
                            <button class="btn btn_discount">
                                <span>Получить скидку</span>
                            </button>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="discount__thanks">
                    <img src="/assets/img/img-thanks.png" alt="img"/>
                    <h2 class="discount__thanks-title">Спасибо большое за вашу заявку</h2>
                    <p>Мы добавили ваш сайт на просчёт текста. Мы можете посмотреть сколько там страниц, символов, слов и т.д.</p>
                    <p>Мы также выслали вам письмо ссылкой на статистику по вашему сайту.</p>
                    <a href="#" class="btn btn_2">
                        <span>Посмотреть статистику</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop