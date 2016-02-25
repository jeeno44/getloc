@extends('admin.layouts.master')

@section('title')
    @if($user->hasRole('partner'))
        Редакирование парнера "{{$user->name}}"
    @else
        Редакирование пользователя "{{$user->name}}"
    @endif

@stop

@section('content')
{!! Form::model($user, ['url' => 'admin/users/'.$user->id, 'method' => 'PUT']) !!}

{!! Form::close() !!}
@stop