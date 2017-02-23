@extends('layouts.account')

@section('title') Добавить проекты на локализацию @stop

@section('content')
    <aside class="site__aside">
        {!! accountMenu() !!}
    </aside>
    <div class="inside-content">

        <form class="site__wrap_2" method="post">
            {!! csrf_field() !!}
            <div class="site__panel">
                <h2 class="site__title">Выбрать проекты для локализации</h2>
            </div>
            <table class="projects">
                <thead>
                <tr>
                    <td></td>
                    <td>Проект</td>
                </tr>
                </thead>
                @foreach($sites as $site)
                    <tr>
                        <td>
                            <input type="checkbox" name="sites[]" value="{{$site->id}}">
                        </td>
                        <td>
                            {!! $site->name !!}
                        </td>
                    </tr>
                @endforeach
            </table>
            <button type="submit" class="btn btn_7 btn_blue account-data__save">Добавить проекты</button>
        </form>

    </div>

@stop
