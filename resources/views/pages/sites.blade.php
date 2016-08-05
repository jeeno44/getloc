@extends('layouts.index')

@section('title') {{trans('phrases.analytics')}} @stop

@section('content')

    <div class="site__content site_inner">
        <!-- site__wrap -->
        <div class="site__wrap">
            <div class="warn_panel">{{trans('phrases.limit_warning')}}</div>

            <!-- site__title -->
            <h1 class="site__title">{{trans('phrases.analytics')}}</h1>
            <!-- /site__title -->

            <!-- site__introduction -->
            <div class="site__introduction">
                <p>{{trans('phrases.here_see_testing')}}</p>
            </div>
            <!-- /site__introduction -->

            <!-- statistic -->
            <ul class="statistic">
                <li>

                    <!-- statistic__title -->
                    <span class="statistic__title">{{trans('phrases.added')}}</span>
                    <!-- /statistic__title -->

                    <!-- statistic__num -->
                    <span class="statistic__num">{{$countSites}}</span>
                    <!-- /statistic__num -->

                    <span>{{trans('phrases.sites')}}</span>
                </li>
                <li>

                    <!-- statistic__title -->
                    <span class="statistic__title">{{trans('phrases.validated')}}</span>
                    <!-- /statistic__title -->

                    <!-- statistic__num -->
                    <span class="statistic__num">{{number_format($countPages, 0, '.', ' ')}}</span>
                    <!-- /statistic__num -->

                    <span>{{trans('phrases.pages')}}</span>
                </li>
                <li>

                    <!-- statistic__title -->
                    <span class="statistic__title">{{trans('phrases.found')}}</span>
                    <!-- /statistic__title -->

                    <!-- statistic__num -->
                    <span class="statistic__num">{{number_format($countBlocks, 0, '.', ' ')}}</span>
                    <!-- /statistic__num -->

                    <span>{{trans('phrases.blocks')}}</span>
                </li>
            </ul>
            <!-- /statistic -->

            <!-- site__panel -->
            <div class="site__panel">

                @if(!\Auth::user()->is_contragent)
                    <a class="btn btn_add_disabled"><span>{{trans('phrases.add_your_site')}}</span></a>
                    <a class="btn btn_add" href="/contragent">Регистрация как контрагент</a>
                @else
                    @if(Auth::user()->sites()->count() > Auth::user()->max_sites)
                        <a class="btn btn_add_disabled"><span>{{trans('phrases.add_your_site')}}</span></a>
                        <a class="btn btn_add" href="/contragent">Регистрация как контрагент</a>
                    @else
                        <a class="btn btn_add popup__open" data-popup="order">
                            <span>{{trans('phrases.add_your_site')}}</span>
                        </a>
                    @endif

                @endif

                <!-- search -->
                <div class="search">
                    <form method="get" action="#">
                        <input type="search" name="search" id="quick-search" placeholder="{{trans('phrases.find_site')}}"/>
                        <button name="find"></button>
                    </form>
                </div>
                <!-- /search -->

            </div>
            <!-- /site__panel -->

            <!-- projects -->
            <table class="projects projects_list">
                <thead>
                <tr>
                    <td>{{trans('phrases.last_projects')}}</td>
                    <td class="projects__status">
                        <span>{{trans('phrases.status')}}</span>
                    </td>
                    <td>{{ucfirst(trans('phrases.pages'))}}</td>
                    <td>{{ucfirst(trans('phrases.blocks'))}}</td>
                    <td>{{ucfirst(trans('phrases.words'))}}</td>
                    <td>{{ucfirst(trans('phrases.symbols'))}}</td>
                    <td>Экспорт</td>
                </tr>
                </thead>
                <tbody>
                @foreach($sites as $site)
                    <tr>
                        @if ($site->pages()->count() == 0)
                            <td>{{beautyUrl($site->url)}}</td>
                            <td class="projects__status">
                                <span class="projects__picking">
                                    {{trans('phrases.building_structure')}}
                                </span>

                            </td>
                        @elseif ($site->pages()->where('visited', 0)->count() > 0)
                            <td>{{beautyUrl($site->url)}}</td>
                            <td class="projects__status">
                                <span class="projects__picking">
                                    {{trans('phrases.building_structure')}}
                                    ({{number_format($site->pages()->where('visited', 1)->count(), 0, '.', ' ')}} / {{number_format($site->pages()->count(), 0, '.', ' ')}})
                                </span>

                            </td>
                        @elseif ($site->pages()->where('collected', 0)->where('code', '<', 400)->count() > 0)
                            <td>{{beautyUrl($site->url)}}</td>
                            <td class="projects__status">
                                <span class="projects__picking">
                                    {{trans('phrases.collect_text')}}
                                    ({{number_format($site->pages()->where('collected', 1)->count(), 0, '.', ' ')}} / {{number_format($site->pages()->count(), 0, '.', ' ')}})
                                </span>
                            </td>
                        @else
                            <td><a href="{{route('scan.site', ['id' => $site->id])}}">{{beautyUrl($site->url)}}</a></td>
                            <td class="projects__status">
                                <span class="projects__done">{{trans('phrases.site_done')}}</span>
                            </td>
                        @endif
                        <td>{{$site->pages()->count()}}</td>
                        <td>{{number_format($site->count_blocks, 0, '.', ' ')}}</td>
                        <td>{{number_format($site->count_words, 0, '.', ' ')}}</td>
                        <td>{{number_format($site->count_symbols, 0, '.', ' ')}}</td>
                        <td>
                            @if($site->count_words)<a href="/export/{{$site->id}}">скачать</a>@endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <!-- /projects -->
            @if($newSite != null)
                <script>
                    var row = document.getElementsByTagName("table")[0].rows[1];
                    row.style.backgroundColor = "#D93600";
                    setTimeout(function () {
                        row.style.backgroundColor = "#FFFFFF";
                    }, 3000);
                </script>
            @endif
            <!-- paginator -->
            {!! $sites->render() !!}
            <!-- /paginator -->

        </div>
        <!-- /site__wrap -->

    </div>

@stop
