@extends('layouts.account')
@section('title') Выберите проект @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <h4>{{trans('account.plsselproject')}}:</h4>
        <ul>
            @foreach ($mySites as $site)
                <li>
                    <a href='{{URL::route('main.account.setProject', $site->id)}}'>{{$site->url}}</a>
                </li>
            @endforeach
        </ul>
    </div>

@stop