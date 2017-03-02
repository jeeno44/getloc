@extends('layouts.account')

@section('title') Импорт перевода @stop

@section('content')
    <aside class="site__aside">
        {!! accountMenu() !!}
    </aside>
    <div class="inside-content">

        <form class="site__wrap_2" method="post" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="site__panel">
                <h2 class="site__title">Импорт перевода</h2>
            </div>
            <table class="projects">
                <thead>
                <tr>
                    <td>Источник</td>
                    <td>Направление</td>
                    <td>Сегментов</td>
                    <td>Файл</td>
                    <td>Дата</td>
                </tr>
                </thead>
                @foreach($imports as $item)
                    <tr>
                        <td>
                            {{$item->fromLanguage->name}}
                        </td>
                        <td>
                            {{$item->toLanguage->name}}
                        </td>
                        <td>
                            {{$item->count_blocks}}
                        </td>
                        <td>
                            <a href="/uploads/{{$siteID}}/{{$item->file_path}}">{{$item->file_name}}</a>
                        </td>
                        <td>
                            {{date('d.m.Y', strtotime($item->created_at))}}
                        </td>
                    </tr>
                @endforeach
            </table>
            <input type="file" name="xliff" required>
            <button type="submit" class="btn btn_7 btn_blue account-data__save">Импортировать</button>
        </form>

    </div>

@stop
