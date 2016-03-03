@extends('layouts.account')
@section('title') Добавить язык @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
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
    </div>
@stop