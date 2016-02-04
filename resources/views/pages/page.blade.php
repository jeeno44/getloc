@extends('layouts.index')

@section('title') Аналитика @stop

@section('content')

    <div class="site__content site_inner">

        <div class="site__wrap">

            <!-- site__panel -->
            <div class="site__panel">

                <!-- site__back -->
                <a href="{{route('scan.main')}}" class="site__back">Все сайты</a>
                <!-- /site__back -->

                <!-- site__title -->
                <h1 class="site__title">{{beautyUrl($page->site->url)}}</h1>
                <!-- /site__title -->

                <span class="projects__done">Обработан</span>

            </div>
            <!-- /site__panel -->

            <!-- statistic -->
            <ul class="statistic statistic_col-4">
                <li>
                    <!-- statistic__num -->
                    <span class="statistic__num">{{$page->site->pages()->count()}}</span>
                    <!-- /statistic__num -->
                    <span>страниц</span>
                </li>
                <li>

                    <!-- statistic__num -->
                    <span class="statistic__num">{{$page->site->count_blocks}}</span>
                    <!-- /statistic__num -->

                    <span>блоков</span>
                </li>
                <li>

                    <!-- statistic__num -->
                    <span class="statistic__num">{{$page->site->count_words}}</span>
                    <!-- /statistic__num -->

                    <span>слов</span>
                </li>
                <li>

                    <!-- statistic__num -->
                    <span class="statistic__num">{{$page->site->count_symbols}}</span>
                    <!-- /statistic__num -->

                    <span>символов</span>
                </li>
            </ul>
            <!-- /statistic -->

            <div class="breadcrumbs">
                <a href="{{route('scan.site', ['id' => $page->site_id])}}">Все страницы проекта</a>
                <span>Список текстов страницы {{beautyUrl($page->url)}}</span>
            </div>

            <table class="projects">
                <thead>
                    <tr>
                        <th>Текст</th>
                        <th>Слов</th>
                        <th>Символов</th>
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
