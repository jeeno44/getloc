@extends('layouts.account')
@section('title') {{Session::get('status', '')}} @stop
@section('content')
    <p>{{Session::get('status', '')}}</p>
@stop