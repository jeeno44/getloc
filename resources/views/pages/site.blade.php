@extends('layouts.index')

@section('title') {{trans('phrases.analytics')}} @stop

@section('content')

    <div class="site__content site_inner">

        <div class="site__wrap">

            <!-- site__panel -->
            <div class="site__panel">

                <!-- site__back -->
                <a href="{{route('scan.main')}}" class="site__back">{{trans('phrases.all_sites')}}</a>
                <!-- /site__back -->

                <!-- site__title -->
                <h1 class="site__title">{{beautyUrl($site->url)}}</h1>
                <!-- /site__title -->
                <a href="/export/{{$site->id}}" class="btn btn_discount">Экспорт в TMX</a>

            </div>
            <!-- /site__panel -->

            <!-- statistic -->
            <ul class="statistic statistic_col-4">
                <li>
                    <!-- statistic__num -->
                    <span class="statistic__num">{{number_format($site->pages()->count(), 0, '.', ' ')}}</span>
                    <!-- /statistic__num -->
                    <span>{{trans('phrases.pages')}}</span>
                </li>
                <li>

                    <!-- statistic__num -->
                    <span class="statistic__num">{{number_format($site->count_blocks, 0, '.', ' ')}}</span>
                    <!-- /statistic__num -->

                    <span>{{trans('phrases.blocks')}}</span>
                </li>
                <li>

                    <!-- statistic__num -->
                    <span class="statistic__num">{{number_format($site->count_words, 0, '.', ' ')}}</span>
                    <!-- /statistic__num -->

                    <span>{{trans('phrases.words')}}</span>
                </li>
                <li>

                    <!-- statistic__num -->
                    <span class="statistic__num">{{number_format($site->count_symbols, 0, '.', ' ')}}</span>
                    <!-- /statistic__num -->

                    <span>{{trans('phrases.symbols')}}</span>
                </li>
            </ul>
            <!-- /statistic -->

            <div class="breadcrumbs">
                <span>{{trans('phrases.all_project_pages')}}</span>
            </div>

            <!-- projects -->
            <table class="projects">
                <thead>
                <tr>
                    <td>{{trans('phrases.page')}}</td>
                    <td class="projects__status">
                        <span>{{trans('phrases.status')}}</span>
                    </td>
                    <td>{{ucfirst(trans('phrases.blocks'))}}</td>
                    <td>{{ucfirst(trans('phrases.words'))}}</td>
                    <td>{{ucfirst(trans('phrases.symbols'))}}</td>
                </tr>
                </thead>
                <tbody>
                @foreach($pages as $page)
                    <tr>
                        <td>
                            <a href="{{route('scan.page', ['id' => $page->id])}}">{{beautyUrl(trimStrLen($page->url, 80))}}</a>
                        </td>
                        <td class="projects__status">
                            @if ($page->collected == 1)
                                <span class="projects__done">{{trans('phrases.page_done')}}</span>
                            @else
                                <span class="projects__picking">{{trans('phrases.collect_text')}}</span>
                            @endif
                            @if ($page->code >= 400)
                                <span class="label label-danger pull-right">{{trans('phrases.server_error')}} {{$page->code}}</span>
                            @endif
                        </td>
                        <td class="text_right">
                            {{number_format($page->count_blocks, 0, '.', ' ')}}
                        </td>
                        <td class="text_right">
                            {{number_format($page->count_words, 0, '.', ' ')}}
                        </td>
                        <td class="text_right">
                            {{number_format($page->count_symbs, 0, '.', ' ')}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <!-- /projects -->
            {{$pages->render()}}

        </div>

    </div>

@stop
