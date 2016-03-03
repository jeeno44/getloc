@extends('layouts.account')
@section('title') языки проекта @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        {!! Form::open(['route' => ['main.account.post-languages', $site->id]]) !!}
        @foreach($langs as $l)
            <label>
                {{$l->name}}
                {!! Form::checkbox('languages[]', $l->id, $site->hasEnabledLanguage($l->id)) !!}
            </label>&nbsp;&nbsp;&nbsp;&nbsp;
        @endforeach
        <hr>
        <input type="submit" class="btn btn-success" value="Сохранить">
        {!! Form::close() !!}
    </div>
@stop