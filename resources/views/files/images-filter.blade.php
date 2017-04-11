@extends('layouts.account')
@section('title') {{trans('account.t_image_title')}} @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
        <div class="site__aside-filter accordion">
            <span class="accordion__head">{{trans('account.langs')}}</span>
            <div class="accordion__content">
                @foreach ($langs as $lang)
                    <div class="nice-radio">
                        <input type="radio" value="{{$lang['id']}}" name="lang" id="ll{{$lang['id']}}">
                        <label for="ll{{$lang['id']}}">
                            <span class="flag" style="background-image: url('/icons/{{$lang['icon_file']}}')"></span>
                            {{$lang['name']}}<span id="lang_proc_{{$lang['id']}}">{{$lang['count_trans']}}/{{$lang['count_docs']}}</span>
                        </label>
                    </div>
                @endforeach
                    <br>
                    <div class="nice-radio">
                        <input type="radio" value="arch" name="lang" id="arch-radio">
                        <label for="arch-radio">
                            <span class="flag"></span>
                            Архив<span id="arch">{{$arch}}</span>
                        </label>
                    </div>
            </div>
        </div>
        <div class="site__aside-filter accordion">

            <span class="accordion__head">{{trans('account.t_filter_pages')}}</span>
            <div class="accordion__content">
                <div class="search-pages" data-autocomplite="/account/pages/autocomplete/{{$site->id}}">
                    <div class="search-pages__fields">
                        <input class="site__input site__input_small search-pages__input" type="search" name="search-pages-field">
                    </div>
                    <div class="search-pages__chosen">

                    </div>
                </div>
            </div>

        </div>
    </aside>
    <div class="inside-content">
        <div class="pages">
            <h2 class="site__title">{{trans('account.t_image_title')}}</h2>
            <ul class="page__wrap">
                @if($files->count())
                    <input id="site-id" value="{{$site->id}}" type="hidden">
                    <div id="images-block"></div>
                @else
                    <li class="page__row">
                        {{trans('account.t_image_empty_find')}}
                    </li>
                @endforelse
            </ul>
        </div>
        @if(!empty($files->render()))
            <div class="pagination-wrap paginator-images">
                {!! $files->render() !!}
            </div>
        @endif
    </div>
@stop