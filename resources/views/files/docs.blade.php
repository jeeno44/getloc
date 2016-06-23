@extends('layouts.account')
@section('title') {{trans('account.t_docs_title')}} @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <div class="pages">
            <h2 class="site__title">{{trans('account.t_docs_title')}}</h2>
            <ul class="page__wrap">
                @forelse($files as $file)
                    <li class="page__row">
                        <a href="{{$file->full_url}}" class="pages__page" target="_blank">
                            @if(!empty($file->link_text)) {{$file->link_text}} @else {{$file->full_url}} @endif
                        </a>
                    </li>
                @empty
                    <li class="page__row">
                        {{trans('account.t_docs_empty_find')}}
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