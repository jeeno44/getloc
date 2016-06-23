@extends('layouts.account')
@section('title') {{trans('account.t_lang_project_title')}} @stop
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
        <input type="submit" class="btn btn-success" value="{{trans('account.save')}}">
        {!! Form::close() !!}
    </div>
@stop