@extends('layouts.account')
@section('title') {{Session::get('status', '')}} @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <p>{{Session::get('status', '')}}</p>
    </div>
@stop