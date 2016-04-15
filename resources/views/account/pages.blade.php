@extends('layouts.account')
@section('title') Страницы проекта @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu', ['id' => $siteId])
    </aside>
    <div class="inside-content">
        <div class="phrases">
                <h1 class="site__title">Страницы проекта</h1>

            <div class="magic_tabs"{{-- class="tabs"--}}>

                @if(request()->is('account/phrase'))

                    <div class="tabs__links">
                        @if($filter['stats']['not_translate'] > 0)
                            <a id="tab_not_translated" @if (Request::is('account/phrase') or Request::is('account/phrase/not_translated'))class="active" @endif href="#">{{trans('account.noTranslate')}}<span id="stNotTranslate">{{$filter['stats']['not_translate']}}</span></a>
                            <a id="tab_translated" @if (Request::is('account/phrase/translated'))class="active" @endif href="#">{{trans('account.inTranslate')}}<span id="stInTranslate">{{$filter['stats']['in_translate']}}</span></a>
                        @else
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
                            <button class="phrases__control-attached"></button>
                        </div>
                        <button id="setViewTypeID_1" class="phrases__control-horizontal @if ($viewType == 1) active @endif"></button>
                        <button id="setViewTypeID_2" class="phrases__control-column @if ($viewType == 2) active @endif"></button>
                        <a href="{{route('main.billing.make-order')}}" class="btn btn_3">{{trans('account.orderTranslate')}}</a>
                    </div>
                    <div class="phrases__control">

                        <div class="phrases__control-inner">
                            <div id="phrases_in_order"  style="min-height: 35px; line-height: 35px;"class="phrases_in_order">{{trans('account.phrasesInOrder')}} <span class="phrasesCount">{{ $phrasesInOrder }}</span></div>
                        </div>
                        <div class="phrases__control-inner">
                            <div id="cost_order" style="min-height: 35px; line-height: 35px;" class="cost_order">{{trans('account.costOrder')}} <span class="costCount">{{ $costOrder }}</span> &#8381</div>
                            {{--&#8381 - знак рубль--}}
                        </div>
                        {{--<a href="/orders/create?phrasesInOrder=&costOrder=" style="margin-top: 10px;" class="btn btn_3">{{trans('account.pay')}}</a>--}}
                    </div>
                @endif
                <div class="tabs__content">
                    <div class="active" style="display: block;" class="phrases__tab" id="renderPhrases">

                        @if(request()->is('account/pages'))
{{--{{ dd($blocks) }}--}}
                            @foreach ($blocks as $t)

                                <div class="pages_block_wrap">
                                    <input type="checkbox" data-id="{{ $t->id }}" class="pages_disable" @if($t->enabled) checked @endif>
                                    <a href="account/phrase?url={{ urlencode($t->url) }}" class="link_pages">{{ $t->url }}</a>
                                </div>

                            @endforeach

                        @endif


                        @if (isset($blocks))
                            <div class="paginationAjax">
                                {!! $blocks->appends(['site_id' => request()->get('site_id')])->links() !!}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- tabs__content -->

            </div>
            <!--/tabs__wrap-->
        </div>
    </div>
@stop