@extends('layouts.account')
@section('title') Выберите проект @stop
@section('content')
    <h4>{{trans('account.plsselproject')}}:</h4>
    <ul>
        @foreach ($mySites as $site)
            <li>
                @if($site->count_words == 0)
                    {{$site->url}} (сайт в обработке)
                @else
                    <a href='{{URL::route('main.account.setProject', $site->id)}}'>{{$site->url}}</a>
                    <a class="" href="{{route('main.account.project-remove', ['id' => $site->id])}}">Удалить проект</a>
                @endif
            </li>
        @endforeach
    </ul>

@stop