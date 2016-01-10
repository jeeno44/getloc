@extends('layouts.app')

@section('content')

    {!! Form::open() !!}
    <label>Добавить сайт (http://example.com) *</label>
        {!! Form::text('url', null, ['class' => 'form-control', 'required', 'placeholder' => 'Добавить сайт']) !!}
        <br>
    {!! Form::submit('Добавить', ['class' => 'btn btn-default']) !!}
    {!! Form::close() !!}
    <br>
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
                    <a href="/home/sites/delete/{{$site->id}}" class="btn btn-sm pull-right btn-danger">Удалить</a>
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

@stop