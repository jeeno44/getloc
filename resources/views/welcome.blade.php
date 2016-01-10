@extends('layouts.app')

@section('content')

    <div class="row">
        <h3 class="col-sm-4">
            Всего сайтов {{\App\Site::count()}}
        </h3>
        <h3 class="col-sm-4">
            Всего страниц {{\App\Page::count()}}
        </h3>
        <h3 class="col-sm-4">
            Всего блоков {{\App\Block::count()}}
        </h3>
    </div>
    <hr>
    <div class="row">
        <h3 class="col-sm-12">Последние 30 проектов</h3>
        <div class="col-sm-12">
            <table class="table table-bordered table-responsive table-hovered">
                <thead>
                <tr>
                    <th>УРЛ</th>
                    <th>Статус</th>
                    <th>Страниц</th>
                    <th>Блоков</th>
                    <th>Слов</th>
                    <th>Символов</th>
                </tr>
                </thead>
                @foreach($sites as $site)
                    <tr>
                        <td>
                            <a href="/home/site/{{$site->id}}">{{$site->name}}</a>
                        </td>
                        <td>
                            @if ($site->pages()->where('visited', 0)->count() > 0)
                                Построение структуры
                            @elseif ($site->pages()->where('collected', 0)->count() > 0)
                                Сбор текста
                            @else
                                Обработан
                            @endif
                        </td>
                        <td>
                            {{$site->pages()->count()}}
                        </td>
                        <td>
                            {{$site->count_blocks}}
                        </td>
                        <td>
                            {{$site->count_words}}
                        </td>
                        <td>
                            {{$site->count_symbols}}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>



@stop