@extends('layouts.account')
@section('title') Фразы проекта @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
        @if(request()->is('account/phrase'))
            @include('partials.account-filter-phrase')
        @endif
    </aside>
    <div class="inside-content">
        <div class="phrases">

        <h1 class="site__title">Фразы проекта</h1>
        <div class="magic_tabs"{{-- class="tabs"--}}>

            <div class="tabs__links">
                @if($filter['stats']['not_translate'] > 0)
                <a id="tab_not_translated" @if (Request::is('account/phrase') or Request::is('account/phrase/not_translated'))class="active" @endif href="#">{{trans('account.noTranslate')}}<span id="stNotTranslate">{{$filter['stats']['not_translate']}}</span></a>
                <a id="tab_translated" @if (Request::is('account/phrase/translated'))class="active" @endif href="#">{{trans('account.inTranslate')}}<span id="stInTranslate">{{$filter['stats']['in_translate']}}</span></a>
                @else
                    <a id="tab_not_translated" href="#">{{trans('account.noTranslate')}}<span id="stNotTranslate">{{$filter['stats']['not_translate']}}</span></a>
                    <a id="tab_translated" class="active" href="#">{{trans('account.inTranslate')}}<span id="stInTranslate">{{$filter['stats']['in_translate']}}</span></a>
                @endif
                <a id="tab_published" @if (Request::is('account/phrase/published'))class="active" @endif href="#">{{trans('account.inPublish')}}<span id="stPublish">{{$filter['stats']['publish']}} </span></a>
                <div class="tabs__links-archive">
                    <a id="tab_acrhive" href="#">{{trans('account.unpublished')}}</a>
                </div>
            </div>

            <div class="phrases__control">
                <div class="nice-check">
                    <input type="checkbox" id="check" class="select_all">
                    <label for="check"></label>
                </div>
                <div class="phrases__control-inner">
                    <button id="check-all-phrases" class="phrases__control-check"></button>
                    <button id="nopublishing" class="phrases__control-delete"></button>
                    <button id="to-archive" class="phrases__control-attached"></button>
                    <button id="from-archive" class="phrases__control-detached" style="display: none"></button>
                </div>
                <button id="setViewTypeID_2" class="phrases__control-column @if ($viewType == 2) active @endif"></button>
                <button id="setViewTypeID_1" class="phrases__control-horizontal @if ($viewType == 1) active @endif"></button>
                <a href="#" class="phrases__control-send" id="order-selected-phrases">Отправить в заказ</a>
            </div>

            <div class="find-phrase">
                <form action="#">
                    <input class="site__input search-phrase search_text" type="search" name="search-phrase" placeholder="Найти фразу...">
                    <button class="find-phrase__go button_search_text" type="submit"></button>
                    <a class="find-phrase__clean" href="#"></a>
                </form>
            </div>

            <div class="tabs__content">
                <div class="active" style="display: block;" class="phrases__tab" id="renderPhrases">
                    @include('account.phraseAjax')
                </div>
            </div>
            
            <!-- tabs__content -->

        </div>
            <!--/tabs__wrap-->
        </div>
    </div>
@stop