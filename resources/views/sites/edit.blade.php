@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li><a href="/home">Главная</a></li>
        <li><a href="/home/site/{{$site->id}}">Проект {{$site->name}}</a></li>
        <li class="active">Редактирование</li>
    </ol>
    <h3>Редактирование</h3>
    <div class="row">
        <div class="alert alert-warning">Внимание, при удалении из списка существующего языка так же будут удалены и все переведенные тексты.</div>
        <div class="col-sm-12">
            {!! Form::open() !!}
            @foreach($langs as $l)
                <label>
                    {{$l->name}}
                    {!! Form::checkbox('languages[]', $l->id, $site->hasLanguage($l->id)) !!}
                </label>&nbsp;&nbsp;
            @endforeach
            <hr>
            <input type="submit" class="btn btn-success" value="Сохранить">
            {!! Form::close() !!}
        </div>
    </div>
@stop