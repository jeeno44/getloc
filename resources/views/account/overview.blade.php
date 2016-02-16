@extends('layouts.account')
@section('title') Обзор проекта @stop
@section('content')
<!-- statistic -->
                    <div class="statistic inside-content__wrap">

                        <!-- statistic__numbers -->
                        <ul class="statistic__numbers">
                            <li>
                                <span>{{$stats['ccPages']}}</span>
                                {{trans('account.searchPages')}}
                            </li>
                            <li>
                                <span>{{$stats['ccBlocks']}}</span>
                                {{Lang::choice('account.phrases', $stats['ccBlocks'])}}
                            </li>
                        </ul>
                        <!-- /statistic__numbers -->

                        <!--tabs-->
                        <div class="tabs">

                            <!-- statistic__tabs -->
                            <div class="statistic__tabs tabs__content">

                                <!-- statistic__line -->
                                <div class="statistic__line">

                                    <!-- statistic__line-01 -->
                                    <div class="statistic__line-01" style="width: 28%">
                                        <span class="statistic__line-number">4928</span>
                                        <span class="statistic__line-popup">Переведено машиной</span>
                                    </div>
                                    <!-- /statistic__line-01 -->

                                    <!-- statistic__line-02 -->
                                    <div class="statistic__line-02" style="width: 8%">
                                        <span class="statistic__line-number">129</span>
                                        <span class="statistic__line-popup">Переведено машиной</span>
                                    </div>
                                    <!-- /statistic__line-02 -->

                                    <!-- statistic__line-03 -->
                                    <div class="statistic__line-03" style="width: 11%">
                                        <span class="statistic__line-number">1291</span>
                                        <span class="statistic__line-popup">Переведено машиной</span>
                                    </div>
                                    <!-- /statistic__line-03 -->

                                    <!-- statistic__line-04 -->
                                    <div class="statistic__line-04" style="width: 53%">
                                        <span class="statistic__line-number">1390</span>
                                        <span class="statistic__line-popup">Переведено машиной</span>
                                    </div>
                                    <!-- /statistic__line-04 -->

                                </div>
                                <!-- /statistic__line -->

                                <!-- statistic__line -->
                                <div class="statistic__line">

                                    <!-- statistic__line-01 -->
                                    <div class="statistic__line-01" style="width: 28%">
                                        <span class="statistic__line-number">4928</span>
                                        <span class="statistic__line-popup">Переведено машиной</span>
                                    </div>
                                    <!-- /statistic__line-01 -->

                                    <!-- statistic__line-02 -->
                                    <div class="statistic__line-02" style="width: 8%">
                                        <span class="statistic__line-number">129</span>
                                        <span class="statistic__line-popup">Переведено машиной</span>
                                    </div>
                                    <!-- /statistic__line-02 -->

                                    <!-- statistic__line-03 -->
                                    <div class="statistic__line-03" style="width: 11%">
                                        <span class="statistic__line-number">1291</span>
                                        <span class="statistic__line-popup">Переведено машиной</span>
                                    </div>
                                    <!-- /statistic__line-03 -->

                                    <!-- statistic__line-04 -->
                                    <div class="statistic__line-04" style="width: 53%">
                                        <span class="statistic__line-number">1390</span>
                                        <span class="statistic__line-popup">Переведено машиной</span>
                                    </div>
                                    <!-- /statistic__line-04 -->

                                </div>
                                <!-- /statistic__line -->

                            </div>
                            <!-- statistic__tabs -->

                            <!-- statistic__tabs -->
                            <div class="statistic__tabs-links tabs__links">
                                <a href="#">Русский</a>
                                <a href="#">Английский</a>
                            </div>
                            <!-- statistic__tabs -->

                        </div>
                        <!--/tabs-->

                    </div>
                    <!-- /statistic -->

                    <!-- project -->
                    <div class="project inside-content__wrap">

                        <!-- inside-content__title -->
                        <div class="inside-content__title">

                            <h2>
                                Проект –

                                <!-- inside-content__name -->
                                <span class="inside-content__name">itbFirst</span>
                                <!-- /inside-content__name -->

                            </h2>

                            <!-- inside-content__tune -->
                            <a href="#" class="inside-content__tune">Настроить</a>
                            <!-- /inside-content__tune -->

                        </div>
                        <!-- /inside-content__title -->

                        <!-- project__item -->
                        <div class="project__item">

                            <!-- btn-lock -->
                            <div class="btn-lock"></div>
                            <!-- /btn-lock -->

                            <!-- project__topic -->
                            <span class="project__topic">Автоматический перевод</span>
                            <!-- /project__topic -->

                            <!-- project__status -->
                            <span class="project__status">Перевод новых страниц будет осуществляться автоматически</span>
                            <!-- /project__status -->

                        </div>
                        <!-- /project__item -->

                        <!-- project__item -->
                        <div class="project__item">

                            <!-- btn-lock -->
                            <div class="btn-lock btn-lock_on"></div>
                            <!-- /btn-lock -->

                            <!-- project__topic -->
                            <span class="project__topic">Автопубликация</span>
                            <!-- /project__topic -->

                            <!-- project__status -->
                            <span class="project__status">Новые переведенные фразы сразу публикуются</span>
                            <!-- /project__status -->

                        </div>
                        <!-- /project__item -->

                    </div>
                    <!-- /project -->

                    <!-- tariff  -->
                    <div class="tariff inside-content__wrap">

                        <!-- inside-content__title -->
                        <div class="inside-content__title">

                            <h2>Тарифный план</h2>

                            <!-- inside-content__tune -->
                            <a href="#" class="inside-content__tune">Изменить</a>
                            <!-- /inside-content__tune -->

                        </div>
                        <!-- /inside-content__title -->

                        <!-- tariff__info -->
                        <div class="tariff__info">
                            Простечковый совсем –
                                <!-- tariff__sum -->
                                <span class="tariff__sum">500</span>
                                <!-- /tariff__sum -->
                            р/мес
                        </div>
                        <!-- /tariff__info -->

                        <!-- tariff__period -->
                        <div class="tariff__period">
                            <p>Осталось
                                <!-- tariff__days -->
                                <span class="tariff__days">13 дней</span>
                                <!-- /tariff__days -->
                                до истечения оплаченного периода</p>
                            <p><a href="#">Информация об оплате</a></p>
                        </div>
                        <!-- /tariff__period -->

                    </div>
                    <!-- /tariff  -->

                    <!-- translation  -->
                    <div class="translation inside-content__wrap">

                        <!-- inside-content__title -->
                        <div class="inside-content__title">

                            <h2>Направления перевода</h2>

                            <!-- inside-content__tune -->
                            <a href="#" class="inside-content__tune">Управление языками</a>
                            <!-- /inside-content__tune -->

                        </div>
                        <!-- /inside-content__title -->

                        <!-- translation__item -->
                        <div class="translation__item">

                            <!-- translation__language -->
                            <div class="translation__language">

                                <!-- translation__language-flag -->
                                <span class="translation__language-flag" style="background-image: url('/assets/img/account/icons-en.png')"></span>
                                <!-- /translation__language-flag -->

                                Немецкий
                            </div>
                            <!-- /translation__language -->

                            <!-- translation__info -->
                            <div class="translation__info">
                                Переведено

                                <!-- translation__info -->
                                <span class="translation__num">200 / 3298</span>
                                <!-- /translation__info -->

                                фраз
                            </div>
                            <!-- /translation__info -->

                            <!-- translation__status -->
                            <div class="translation__status">
                                <div style="width: 62%"></div>
                            </div>
                            <!-- /translation__status -->

                        </div>
                        <!-- /translation__item -->

                        <!-- translation__item -->
                        <div class="translation__item">

                            <!-- translation__language -->
                            <div class="translation__language">

                                <!-- translation__language-flag -->
                                <span class="translation__language-flag" style="background-image: url('/assets/img/account/icons-en.png')"></span>
                                <!-- /translation__language-flag -->

                                Японский
                            </div>
                            <!-- /translation__language -->

                            <!-- translation__info -->
                            <div class="translation__info">
                                Переведено

                                <!-- translation__info -->
                                <span class="translation__num">17263 / 17263</span>
                                <!-- /translation__info -->

                                фраз
                            </div>
                            <!-- /translation__info -->

                            <!-- translation__status -->
                            <div class="translation__status status-done">
                                <div style="width: 100%"></div>
                            </div>
                            <!-- /translation__status -->

                        </div>
                        <!-- /translation__item -->

                    </div>
                    <!-- /translation  -->
@stop