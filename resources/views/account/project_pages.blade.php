@extends('layouts.account')
@section('title') Страницы проекта @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
        @include('partials.account-filter-phrase')
    </aside>
    <div class="inside-content">
        <div class="phrases">
            <h1 class="site__title">Страницы проекта</h1>
            <div class="magic_tabs"{{-- class="tabs"--}}>
                <div class="tabs__links">
                    <a id="tab_not_translated" @if (Request::is('account/phrase') or Request::is('account/phrase/not_translated'))class="active" @endif href="#">{{trans('account.noTranslate')}}<span id="stNotTranslate">{{$filter['stats']['not_translate']}}</span></a>
                    <a id="tab_translated" @if (Request::is('account/phrase/translated'))class="active" @endif href="#">{{trans('account.inTranslate')}}<span id="stInTranslate">{{$filter['stats']['in_translate']}}</span></a>
                    <a id="tab_published" @if (Request::is('account/phrase/published'))class="active" @endif href="#">{{trans('account.inPublish')}}<span id="stPublish">{{$filter['stats']['publish']}} </span></a>
                    <div class="tabs__links-archive">
                        <a id="tab_acrhive" href="#">{{trans('account.archive')}}</a>
                    </div>
                </div>
                <div class="phrases__control">
                    <div class="nice-check">
                        <input type="checkbox" id="check">
                        <label for="check"></label>
                    </div>
                    <div class="phrases__control-inner">
                        <button id="check-all-phrases" class="phrases__control-check"></button>
                        <button id="nopublishing" class="phrases__control-delete"></button>
                        <button class="phrases__control-attached"></button>
                    </div>
                    <button id="setViewTypeID_1" class="phrases__control-horizontal @if ($viewType == 1) active @endif"></button>
                    <button id="setViewTypeID_2" class="phrases__control-column @if ($viewType == 2) active @endif"></button>
                    <a href="#" class="btn btn_3">{{trans('account.orderTranslate')}}</a>
                </div>
                <div class="phrases__control">

                    <div class="phrases__control-inner">
                        <div id="phrases_in_order"  style="min-height: 35px; line-height: 35px;"class="phrases_in_order">{{trans('account.phrasesInOrder')}} <span class="phrasesCount">{{ $phrasesInOrder }}</span></div>
                    </div>
                    <div class="phrases__control-inner">
                        <div id="cost_order" style="min-height: 35px; line-height: 35px;" class="cost_order">{{trans('account.costOrder')}} <span class="costCount">{{ $costOrder }}</span></div>
                    </div>
                    <a href="/orders/create?phrasesInOrder=&costOrder=" style="margin-top: 10px;" class="btn btn_3">{{trans('account.pay')}}</a>
                </div>
                <div class="tabs__content">
                    <div class="active" style="display: block;" class="phrases__tab" id="renderPhrases">
                        Тут страницы
                    </div>
                </div>

                <!-- tabs__content -->

            </div>
            <!--/tabs__wrap-->
        </div>
    </div>
@stop