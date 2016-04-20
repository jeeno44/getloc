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
            <div class="tabs__content">
                <div class="active" style="display: block;" class="phrases__tab" id="renderPhrases">


                    @foreach ($blocks as $t)

                        @if($t->blocks_enabled)

                            @if ( $viewType == 2)
                                <div class="phrases__item @if ($t->type_translate_id)phrases__item_mark-{{$filter['colors'][$t->type_translate_id]['block']}} @endif" id="phrase_{{$t->tid}}">
                                <div class="phrases__item-col">
                                    <label for="order_{{$t->tid}}">{!! $t->original !!}</label>
                                </div>
                                <form class="phrases__item-col phrases__item-col_translate">
                                    <textarea onkeyup="$(this).attr('data-type', 2)" id="order_{{$t->tid}}">{{$t->text}}</textarea>
                                    <div class="phrases__item-col-btns">
                                        <button class="save save_translate" object-id="{{$t->tid}}" type="submit">{{trans('account.save')}}</button>
                                        <button class="cancel">{{trans('account.cancel')}}</button>
                                        @if ( $tab_name != 'tab_not_translated' )
                                        <div>
                                            <a class="phrases__item-btn-translate go_robot" data-id="{{$t->tid}}">{{trans('account.useRobotTrans')}}</a>
                                        </div>
                                        @endif
                                    </div>
                                    @if (empty($t->text)) <button class="phrases__item-btn-translate go_robot isLinkMoreMenu" data-id="{{$t->tid}}">{{trans('account.useRobotTrans')}}</button> @endif
                                </form>

                                <div class="phrases__item-controls">
                                    <div class="nice-check">
                                        <input type="checkbox" name="blocks[]" value="{{$t->tid}}" class="checkbox_ordering_translation" id="ordering_translation_{{$t->tid}}" @if ($t->is_ordered) checked @endif>
                                        <label for="ordering_translation_{{$t->tid}}"></label>
                                        {{--<label for="ordering_translation_{{$t->tid}}">@if ($t->is_ordered) {{ trans('account.deselectPhraseInOrder') }} @else {{ trans('account.selectPhraseInOrder') }} @endif</label>--}}
                                    </div>
                                    {{--<div class="nice-check">--}}
                                        {{--<input type="checkbox" name="blocks[]" value="{{$t->tid}}" class="checkboxPhrase" id="publish_{{$t->tid}}">--}}
                                        {{--<label for="publish_{{$t->tid}}">@if ($t->enabled){{trans('account.cancelPublishing')}}@else{{trans('account.publishing')}}@endif</label>--}}
                                    {{--</div>--}}
                                    @include('partials.account-menu-phrase', ['ob' => $t])
                                </div>
                            </div>
                            @else
                                <div class="phrases__item @if ($t->type_translate_id)phrases__item_mark-{{$filter['colors'][$t->type_translate_id]['block']}} @endif" id="phrase_{{$t->tid}}">
                                <div class="phrases__item-col phrases__item-col_block">
                                    <label for="order_{{$t->tid}}">{{$t->original}}</label>
                                </div>
                                <div class="phrases__item-col phrases__item-col_block phrases__item-col_translate">
                                    <textarea onkeyup="$(this).attr('data-type', 2)" id="order_{{$t->tid}}" readonly>{{$t->text}}</textarea>
                                    <div class="phrases__item-col-btns">
                                        <button class="save save_translate" object-id="{{$t->tid}}" type="submit">{{trans('account.save')}}</button>
                                        <button class="cancel">{{trans('account.cancel')}}</button>
                                        @if ( $tab_name != 'tab_not_translated' )
                                        <div>
                                            <a class="phrases__item-btn-translate go_robot" data-id="{{$t->tid}}">{{trans('account.useRobotTrans')}}</a>
                                        </div>
                                        @endif
                                    </div>
                                    @if (empty($t->text)) <button class="phrases__item-btn-translate go_robot isLinkMoreMenu" data-id="{{$t->tid}}">{{trans('account.useRobotTrans')}}</button> @endif
                                </div>
                                <div class="phrases__item-controls">
                                    <div class="nice-check">
                                        <input type="checkbox" name="blocks[]" value="{{$t->tid}}" class="checkbox_ordering_translation" id="ordering_translation_{{$t->tid}}" @if ($t->is_ordered) checked @endif>
                                        <label for="ordering_translation_{{$t->tid}}"></label>
                                        {{--<label for="ordering_translation_{{$t->tid}}">@if ($t->is_ordered) {{ trans('account.deselectPhraseInOrder') }} @else {{ trans('account.selectPhraseInOrder') }} @endif</label>--}}
                                    </div>
                                    {{--<div class="nice-check">--}}
                                        {{--<input type="checkbox" name="blocks[]" value="{{$t->tid}}" class="checkboxPhrase" id="publish_{{$t->tid}}">--}}
                                        {{--<label for="publish_{{$t->tid}}">@if ($t->enabled){{trans('account.cancelPublishing')}}@else{{trans('account.publishing')}}@endif</label>--}}
                                    {{--</div>--}}
                                    @include('partials.account-menu-phrase', ['ob' => $t])
                                </div>
                            </div>
                            @endif

                        @endif

                    @endforeach


                    @if (isset($blocks))
                    <div class="paginationAjax">
                        {!! $blocks->render() !!}
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