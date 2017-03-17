@extends('layouts.account')

@section('title') Добавить проект на локализацию @stop

@section('content')
    <aside class="site__aside">
        {!! accountMenu() !!}
    </aside>
    <div class="inside-content">

        <form class="site__wrap_2" method="post">
            {!! csrf_field() !!}
            <div class="site__panel">
                <h2 class="site__title">Добавить проект на локализацию</h2>
            </div>
            <div class="warn_panel" style="margin-top: -40px">
                <p>Ваш проект будет добавлен в локализацию, после этого вы сможете управлять переводом сегментов и разместить виджет перевода на вашем сайте</p>
            </div>
            <input type="hidden" name="sites[]" value="{{$site->id}}">
            <button type="submit" class="btn btn_7 btn_blue account-data__save">Добавить</button>
        </form>

    </div>

@stop
