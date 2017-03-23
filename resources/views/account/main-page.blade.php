@extends('layouts.account')
@section('title') {{trans('account.t_all_projects')}} @stop
@section('content')
    <aside class="site__aside">
        {!! accountMenu() !!}
    </aside>
    <div class="inside-content">
        <div class="site__content_2">
            <!-- site__wrap -->
            <div class="site__wrap_2">
                @if(!$details || Auth::user()->max_sites)
                <div class="warn_panel">
                    <h2 class="warn_panel__title">Вы работаете в демо-режиме</h2>
                    <p>В демо-режиме доступны еще <b>{{Auth::user()->max_sites}}</b> {{trans_choice('phrases.count_sites_available', Auth::user()->max_sites)}}. </p>
                    <p>
                        Для дальнейшей работы необходимо заполнить форму регистрации контрагента. <br />
                        Стоимость каждого расчета статистики составляет 299 рублей, оплачивается единым счетом в конце месяца.
                    </p>
                    <a class="warn_panel__change" href="/account/contragent">Заполнить форму регистрации контрагента</a>
                </div>
                @endif
                <!-- statistic -->
                <ul class="statistic">
                    <li class="stat">

                        <!-- statistic__title -->
                        <span class="statistic__title">{{trans('phrases.added')}}</span>
                        <!-- /statistic__title -->

                        <!-- statistic__num -->
                        <span class="statistic__num">{{$mySites->count()}}</span>
                        <!-- /statistic__num -->

                        <span>{{trans('phrases.sites')}}</span>
                    </li>
                    <li class="stat">

                        <!-- statistic__title -->
                        <span class="statistic__title">{{trans('phrases.validated')}}</span>
                        <!-- /statistic__title -->

                        <!-- statistic__num -->
                        <span class="statistic__num">{{number_format($pagesCount, 0, '.', ' ')}}</span>
                        <!-- /statistic__num -->

                        <span>{{trans('phrases.pages')}}</span>
                    </li>
                    <li class="stat">

                        <!-- statistic__title -->
                        <span class="statistic__title">{{trans('phrases.found')}}</span>
                        <!-- /statistic__title -->

                        <!-- statistic__num -->
                        <span class="statistic__num">{{number_format($mySites->sum('count_blocks'), 0, '.', ' ')}}</span>
                        <!-- /statistic__num -->

                        <span>{{trans('phrases.blocks')}}</span>
                    </li>
                </ul>
                <!-- /statistic -->

                <!-- projects -->
                <table class="projects projects_list">
                    <thead>
                    <tr>
                        <td>{{trans('phrases.last_projects')}}</td>
                        <td class="projects__status">
                            <span>{{trans('phrases.status')}}</span>
                        </td>
                        <td class="text_right">{{ucfirst(trans('phrases.pages'))}}</td>
                        <td class="text_right">{{ucfirst(trans('phrases.blocks'))}}</td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($mySites as $site)
                        <tr>
                            @if ($site->pages()->where('url', 'LIKE', $site->url.'%')->count() == 0)
                                <td id="site-name-{{$site->id}}">{{beautyUrl($site->url)}} @if (strpos('_'.$site->url, 'https:') > 0) (https) @endif</td>
                                <td class="projects__status">
                                <span class="projects__picking" id="site-status-{{$site->id}}">
                                    {{trans('phrases.building_structure')}}
                                </span>

                                </td>
                            @elseif ($site->pages()->where('url', 'LIKE', $site->url.'%')->where('visited', 0)->count() > 0)
                                <td>{{beautyUrl($site->url)}}</td>
                                <td class="projects__status">
                                <span class="projects__picking" id="site-status-{{$site->id}}">
                                    {{trans('phrases.building_structure')}}
                                    ({{number_format($site->pages()->where('url', 'LIKE', $site->url.'%')->where('visited', 1)->count(), 0, '.', ' ')}} / {{number_format($site->pages()->where('url', 'LIKE', $site->url.'%')->count(), 0, '.', ' ')}})
                                </span>

                                </td>
                            @elseif ($site->pages()->where('url', 'LIKE', $site->url.'%')->where('collected', 0)->where('code', '<', 400)->count() > 0)
                                <td>{{beautyUrl($site->url)}}</td>
                                <td class="projects__status">
                                <span class="projects__picking" id="site-status-{{$site->id}}">
                                    {{trans('phrases.collect_text')}}
                                    ({{number_format($site->pages()->where('url', 'LIKE', $site->url.'%')->where('collected', 1)->count(), 0, '.', ' ')}} / {{number_format($site->pages()->where('url', 'LIKE', $site->url.'%')->count(), 0, '.', ' ')}})
                                </span>
                                </td>
                            @else
                                <td><a href="/account/setProjects/{{$site->id}}">{{beautyUrl($site->url)}}</a></td>
                                <td class="projects__status">
                                    <span class="projects__done">{{trans('phrases.site_done')}}</span>
                                </td>
                            @endif
                            <td class="text_right" id="pages-count-{{$site->id}}">{{number_format($site->pages()->where('url', 'LIKE', $site->url.'%')->count(), 0, '.', ' ')}}</td>
                            <td class="text_right" id="blocks-count-{{$site->id}}">{{number_format($site->count_blocks, 0, '.', ' ')}}</td>
                            <td>
                                @if($site->count_words)
                                    <a class="btn btn-actions"><i class="fa fa-ellipsis-v"></i> </a>
                                    <div class="dropdown">
                                    <!--                                <a href="/export/{{$site->id}}" class="overlay-link">Скачать TMX</a>
                                <a href="/xliff/{{$site->id}}" class="overlay-link">Скачать XLIFF</a>-->
                                    <!-- <a class="project-list__control-tmx popup__open overlay-link" href="#" data-popup="tmx{{$site->id}}">Скачать TMX</a> -->
                                        {{--<a class="project-list__control-smcat popup__open overlay-link" href="#" data-popup="smcat{{$site->id}}">Экспорт в SmartCat</a>--}}
                                        <a class="project-list__control-xliff popup__open overlay-link" href="#" data-popup="xliff{{$site->id}}">Скачать XLIFF</a>
                                        <a class="project-list__control-delet popup__open overlay-link" href="#" data-popup="del{{$site->id}}">{{trans('account.t_sproject_remove')}}</a>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <!-- /projects -->

            </div>
        </div>
    </div>
    <div class="popup">
        <div class="popup__wrap">
            @include('scan.partials.popups')
        </div>
    </div>
@stop