@extends('layouts.account')
@section('title') Документы проекта @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <div class="pages">
            <h2 class="site__title">Документы проекта</h2>
            <ul class="page__wrap">
                @forelse($files as $file)
                    <li class="page__row">
                        <a href="{{$file->full_url}}" class="pages__page" target="_blank">{{$file->link_text}} </a>
                    </li>
                @empty
                    <li class="page__row">
                        Документы на сайте не найдены
                    </li>
                @endforelse
            </ul>
        </div>
        <div class="pagination">
            {!! $files->render() !!}
        </div>
    </div>
@stop