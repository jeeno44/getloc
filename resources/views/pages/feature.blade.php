@extends('layouts.index')

@section('title') GETLOC @stop

@section('content')

    <div class="site__content site_inner">
        <!-- site__wrap -->
        <div class="site__wrap">
            <!-- platform -->
            <div class="platform">
                <!-- site__title -->
                <h1 class="site__title">{{trans('phrases.platform_capabilities')}}</h1>
                <!-- /site__title -->
                <!-- platform__introduction -->
                <div class="platform__introduction">
                    <p>{{trans('phrases.great_need_for')}}</p>
                </div>
                <!-- /platform__introduction -->
                <!-- platform__list -->
                <ul class="platform__list">
                    <li>
                        <!-- platform__img -->
                        <div class="platform__img">
                            <img src="/assets/img/platform-001.png" alt="img"/>
                        </div>
                        <!-- /platform__img -->

                        <!-- platform__content -->
                        <div class="platform__content">

                            <!-- platform__title -->
                            <h2 class="platform__title">{{trans('phrases.auto_site_map')}}</h2>
                            <!-- /platform__title -->

                            <p>{{trans('phrases.chatkaya-pickcha')}}</p>
                        </div>
                        <!-- /platform__content -->

                    </li>
                    <li>
                        <!-- platform__img -->
                        <div class="platform__img">
                            <img src="/assets/img/platform-002.png" alt="img"/>
                        </div>
                        <!-- /platform__img -->

                        <!-- platform__content -->
                        <div class="platform__content">

                            <!-- platform__title -->
                            <h2 class="platform__title">{{trans('phrases.calculate_phrases')}}</h2>
                            <!-- /platform__title -->
                            <p>{{trans('phrases.volume_of_work')}}</p>
                        </div>
                        <!-- /platform__content -->

                    </li>
                    <li>
                        <!-- platform__img -->
                        <div class="platform__img">
                            <img src="/assets/img/platform-003.png" alt="img"/>
                        </div>
                        <!-- /platform__img -->

                        <!-- platform__content -->
                        <div class="platform__content">

                            <!-- platform__title -->
                            <h2 class="platform__title">{{trans('phrases.translate_by_bing')}}</h2>
                            <!-- /platform__title -->
                            <p>{{trans('phrases.translate_by_bing_desc')}}</p>
                        </div>
                        <!-- /platform__content -->

                    </li>
                    <li>
                        <!-- platform__img -->
                        <div class="platform__img">
                            <img src="/assets/img/platform-004.png" alt="img"/>
                        </div>
                        <!-- /platform__img -->

                        <!-- platform__content -->
                        <div class="platform__content">

                            <!-- platform__title -->
                            <h2 class="platform__title">{{trans('phrases.professional_translate')}}</h2>
                            <!-- /platform__title -->

                            <p>{{trans('phrases.professional_translate_desc')}}</p>
                        </div>
                        <!-- /platform__content -->

                    </li>
                    <li>
                        <!-- platform__img -->
                        <div class="platform__img">
                            <img src="/assets/img/platform-005.png" alt="img"/>
                        </div>
                        <!-- /platform__img -->

                        <!-- platform__content -->
                        <div class="platform__content">

                            <!-- platform__title -->
                            <h2 class="platform__title">{{trans('phrases.auto_geolocate')}}</h2>
                            <!-- /platform__title -->

                            <p>{{trans('phrases.auto_geolocate_desc')}}</p>
                        </div>
                        <!-- /platform__content -->

                    </li>
                    <li>
                        <!-- platform__img -->
                        <div class="platform__img">
                            <img src="/assets/img/platform-006.png" alt="img"/>
                        </div>
                        <!-- /platform__img -->

                        <!-- platform__content -->
                        <div class="platform__content">

                            <!-- platform__title -->
                            <h2 class="platform__title">{{trans('phrases.translate_in_one_click')}}</h2>
                            <!-- /platform__title -->

                            <p>{{trans('phrases.translate_in_one_click_desc')}}</p>
                        </div>
                        <!-- /platform__content -->

                    </li>
                    <li>
                        <!-- platform__img -->
                        <div class="platform__img">
                            <img src="/assets/img/platform-007.png" alt="img"/>
                        </div>
                        <!-- /platform__img -->

                        <!-- platform__content -->
                        <div class="platform__content">

                            <!-- platform__title -->
                            <h2 class="platform__title">{{trans('phrases.more_hundred')}}</h2>
                            <!-- /platform__title -->

                            <p>{{trans('phrases.more_hundred_desc')}}</p>
                        </div>
                        <!-- /platform__content -->

                    </li>
                </ul>
                <!-- /platform__list -->

                <!-- next-step -->
                <div class="next-step"></div>
                <!-- /next-step -->

            </div>
            <!-- /platform -->

            <!-- function -->
            <div class="function">

                <!-- site__title -->
                <h1 class="site__title">{{trans('phrases.more_functions')}}</h1>
                <!-- /site__title -->

                <ul>
                    <li>{{trans('phrases.one_tool_for_all')}}</li>
                    <li>{{trans('phrases.easy_intuit')}}</li>
                    <li>{{trans('phrases.one_sol_many_devs')}}</li>
                    <li>{{trans('phrases.attachments')}}</li>
                    <li>{{trans('phrases.unlimited_mind_mapping')}}</li>
                    <li>{{trans('phrases.support_from_real_people')}}</li>
                </ul>

                <ul>
                    <li>{{trans('phrases.styles_and_borders')}}</li>
                    <li>{{trans('phrases.structured_information')}}</li>
                    <li>{{trans('phrases.export_maps')}}</li>
                    <li>{{trans('phrases.round_the_clock')}}</li>
                    <li>{{trans('phrases.inserting_maps')}}</li>
                    <li>{{trans('phrases.manage_tasks')}}</li>
                </ul>

            </div>
            <!-- function -->

        </div>
        <!-- /site__wrap -->

    </div>

@stop