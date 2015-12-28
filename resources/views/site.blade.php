@extends('layout')

@section('content')
    <ol class="breadcrumb">
        <li><a href="/">Главная</a></li>
        <li class="active">Страницы сайта {{$site->url}}</li>
    </ol>
    @if ($site->pages()->where('visited', 0)->count() > 0)
        <div class="alert alert-info">Построение структуры</div>
    @elseif ($site->pages()->where('collected', 0)->count() > 0)
        <div class="alert alert-info">Сбор текста</div>
    @else
        <div class="alert alert-success">Обработан</div>
    @endif
    <h3>Страницы</h3>
    <table class="table table-bordered table-responsive table-hovered">
        <thead>
        <tr>
            <th>УРЛ</th>
            <th>Статус</th>
            <th>Блоков</th>
            <th>Слов</th>
            <th>Символов</th>
        </tr>
        </thead>
        @foreach($pages as $page)
            <tr>
                <td>
                    <a href="/page/{{$page->id}}">{{$page->url}}</a>
                </td>
                <td>
                    @if ($page->collected == 1)
                        Обработана
                    @else
                        В обработке
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
    </table>
    {!! $pages->render() !!}

@stop