@extends('layouts.account')
@section('title') Добавить язык @stop
@section('content') 
    {!! Form::open(array('url' => URL::route('main.account.addlang'))) !!}
        @foreach($langs as $l)
            <label>
                {{$l->name}}
                {!! Form::checkbox('languages[]', $l->id, $site->hasLanguage($l->id)) !!}
            </label>&nbsp;&nbsp;
        @endforeach
        <hr>
        <input type="submit" class="btn btn-success" value="Сохранить">
    {!! Form::close() !!}
@stop