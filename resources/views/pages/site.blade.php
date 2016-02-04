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
                <h1 class="site__title">{{beautyUrl($site->url)}}</h1>
                <!-- /site__title -->

                <span class="projects__done">Обработан</span>

            </div>
            <!-- /site__panel -->

            <!-- statistic -->
            <ul class="statistic statistic_col-4">
                <li>
                    <!-- statistic__num -->
                    <span class="statistic__num">{{$site->pages()->count()}}</span>
                    <!-- /statistic__num -->
                    <span>страниц</span>
                </li>
                <li>

                    <!-- statistic__num -->
                    <span class="statistic__num">{{$site->count_blocks}}</span>
                    <!-- /statistic__num -->

                    <span>блоков</span>
                </li>
                <li>

                    <!-- statistic__num -->
                    <span class="statistic__num">{{$site->count_words}}</span>
                    <!-- /statistic__num -->

                    <span>слов</span>
                </li>
                <li>

                    <!-- statistic__num -->
                    <span class="statistic__num">{{$site->count_symbols}}</span>
                    <!-- /statistic__num -->

                    <span>символов</span>
                </li>
            </ul>
            <!-- /statistic -->

            <div class="breadcrumbs">
                <span>Все страницы проекта</span>
            </div>

            <!-- projects -->
            <table class="projects">
                <thead>
                <tr>
                    <td>Страница</td>
                    <td class="projects__status">
                        <span>Статус</span>
                    </td>
                    <td>Блоков</td>
                    <td>Слов</td>
                    <td>Символов</td>
                </tr>
                </thead>
                <tbody>
                @foreach($pages as $page)
                    <tr>
                        <td>
                            <a href="{{route('scan.page', ['id' => $page->id])}}">{{beautyUrl($page->url)}}</a>
                        </td>
                        <td class="projects__status">
                            @if ($page->collected == 1)
                                <span class="projects__done">Обработана</span>
                            @else
                                <span class="projects__picking">Сбор текста</span>
                            @endif
                            @if ($page->code >= 400)
                                <span class="label label-danger pull-right">Ошибка сервера: {{$page->code}}</span>
                            @endif
                        </td>
                        <td>
                            {{$page->blocks()->count()}}
                        </td>
                        <td>
                            {{$page->blocks()->sum('count_words')}}
                        </td>
                        <td>
                            {{$page->blocks()->sum('count_symbols')}}
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
