@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li><a href="/home/">Главная</a></li>
        <li><a href="/home/site/{{$page->site_id}}">Страницы сайта {{$page->site->url}}</a></li>
        <li class="active">Список текстов страницы {{$page->url}}</li>
    </ol>
    <h3>Блоки</h3>
    <table class="table table-bordered table-responsive table-hovered">
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

@stop