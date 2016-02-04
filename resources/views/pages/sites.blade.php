@extends('layouts.index')

@section('title') Аналитика @stop

@section('content')

    <div class="site__content site_inner">

        <!-- site__wrap -->
        <div class="site__wrap">

            <!-- site__title -->
            <h1 class="site__title">Аналитика</h1>
            <!-- /site__title -->

            <!-- site__introduction -->
            <div class="site__introduction">
                <p>Здесь вы можете посмотреть статистику по всем проектам, которые учавствуют в тестировании сервиса.</p>
            </div>
            <!-- /site__introduction -->

            <!-- statistic -->
            <ul class="statistic">
                <li>

                    <!-- statistic__title -->
                    <span class="statistic__title">Добавлено</span>
                    <!-- /statistic__title -->

                    <!-- statistic__num -->
                    <span class="statistic__num">{{$countSites}}</span>
                    <!-- /statistic__num -->

                    <span>сайтов</span>
                </li>
                <li>

                    <!-- statistic__title -->
                    <span class="statistic__title">Проверено</span>
                    <!-- /statistic__title -->

                    <!-- statistic__num -->
                    <span class="statistic__num">{{$countPages}}</span>
                    <!-- /statistic__num -->

                    <span>страниц</span>
                </li>
                <li>

                    <!-- statistic__title -->
                    <span class="statistic__title">Найдено</span>
                    <!-- /statistic__title -->

                    <!-- statistic__num -->
                    <span class="statistic__num">{{$countBlocks}}</span>
                    <!-- /statistic__num -->

                    <span>блоков</span>
                </li>
            </ul>
            <!-- /statistic -->

            <!-- site__panel -->
            <div class="site__panel">

                <!-- btn -->
                <a class="btn btn_add popup__open" data-popup="order">
                    <span>Добавить свой сайт</span>
                </a>
                <!-- /btn -->

                <!-- search -->
                <div class="search">
                    <form method="get" action="#">
                        <input type="search" name="search" id="quick-search" placeholder="Найти сайт"/>
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
                    <td>Последние проекты</td>
                    <td class="projects__status">
                        <span>Статус</span>
                    </td>
                    <td>Страниц</td>
                    <td>Блоков</td>
                    <td>Слов</td>
                    <td>Символов</td>
                </tr>
                </thead>
                <tbody>
                @foreach($sites as $site)
                    <tr>
                        @if ($site->pages()->where('visited', 0)->count() > 0)
                            <td>{{beautyUrl($site->url)}}</td>
                            <td class="projects__status">
                                <span class="projects__picking">Построение структуры</span>
                            </td>
                        @elseif ($site->pages()->where('collected', 0)->count() > 0)
                            <td>{{beautyUrl($site->url)}}</td>
                            <td class="projects__status">
                                <span class="projects__picking">Сбор текста</span>
                            </td>
                        @else
                            <td><a href="{{route('scan.site', ['id' => $site->id])}}">{{beautyUrl($site->url)}}</a></td>
                            <td class="projects__status">
                                <span class="projects__done">Обработан</span>
                            </td>
                        @endif
                        <td>{{$site->pages()->count()}}</td>
                        <td>{{$site->count_blocks}}</td>
                        <td>{{$site->count_words}}</td>
                        <td>{{$site->count_symbols}}</td>
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
