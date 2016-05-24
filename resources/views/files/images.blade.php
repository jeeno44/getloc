@extends('layouts.account')
@section('title') Изображения проекта @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <div class="pages">
            <h2 class="site__title">Изображения проекта</h2>
            <ul class="page__wrap">
                @forelse ($files as $file)
                    <li class="page__row">
                        <a href="{{$file->full_url}}" class="pages__page" target="_blank"><img src="{{$file->full_url}}" style="max-height: 100px;"> </a>
                    </li>
                @empty
                    <li class="page__row">
                        Изображения на сайте не найдены
                    </li>
                @endforelse
            </ul>
        </div>
        @if(!empty($files->render()))
            <div class="pagination-wrap">
                {!! $files->render() !!}
            </div>
        @endif
    </div>
@stop