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
                <h1 class="site__title">{{beautyUrl($page->site->url)}}</h1>
                <!-- /site__title -->

                <span class="projects__done">{{trans('phrases.site_done')}}</span>

            </div>
            <!-- /site__panel -->

            <!-- statistic -->
            <ul class="statistic statistic_col-4">
                <li>
                    <!-- statistic__num -->
                    <span class="statistic__num">{{number_format($page->site->pages()->count(), 0, '.', ' ')}}</span>
                    <!-- /statistic__num -->
                    <span>{{trans('phrases.pages')}}</span>
                </li>
                <li>

                    <!-- statistic__num -->
                    <span class="statistic__num">{{number_format($page->site->count_blocks, 0, '.', ' ')}}</span>
                    <!-- /statistic__num -->

                    <span>{{trans('phrases.blocks')}}</span>
                </li>
                <li>

                    <!-- statistic__num -->
                    <span class="statistic__num">{{number_format($page->site->count_words, 0, '.', ' ')}}</span>
                    <!-- /statistic__num -->

                    <span>{{trans('phrases.words')}}</span>
                </li>
                <li>

                    <!-- statistic__num -->
                    <span class="statistic__num">{{number_format($page->site->count_symbols, 0, '.', ' ')}}</span>
                    <!-- /statistic__num -->

                    <span>{{trans('phrases.symbols')}}</span>
                </li>
            </ul>
            <!-- /statistic -->

            <div class="breadcrumbs">
                <a href="{{route('scan.site', ['id' => $page->site_id])}}">{{trans('phrases.all_project_pages')}}</a>
                <span>{{trans('phrases.list_of_texts')}} {{beautyUrl(trimStrLen($page->url, 80))}}</span>
            </div>

            <table class="projects">
                <thead>
                    <tr>
                        <th>{{trans('phrases.text')}}</th>
                        <td>{{ucfirst(trans('phrases.words'))}}</td>
                        <td>{{ucfirst(trans('phrases.symbols'))}}</td>
                    </tr>
                </thead>
                @foreach($page->blocks as $block)
                    <tr>
                        <td>
                            {!! $block->text !!}
                        </td>
                        <td>
                            {!! $block->count_words !!}
                        </td>
                        <td>
                            {!! $block->count_symbols !!}
                        </td>
                    </tr>
                @endforeach
            </table>

        </div>

    </div>

@stop
