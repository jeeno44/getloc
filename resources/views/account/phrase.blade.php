@extends('layouts.account')
@section('title') Фразы проекта @stop
@section('content')
    @if(!empty($site->subscription))
        @if($site->subscription->count_words < $site->count_words || $site->subscription->count_languages < $site->languages()->count())
            <div class="other-tariff">
                <h2 class="other-tariff__title">Необходим более крутой тариф</h2>
                <p>Сейчас в вашем заказе {{$site->count_words}} слов и {{$site->languages()->count()}} язык(а). А ваш тариф рассчитан на {{$site->subscription->count_words}} слов и {{$site->subscription->count_languages}} язык(а).</p>
                <a href="{{route('main.billing.upgrade', ['id' => $site->id])}}" class="other-tariff__change">Сменить тарифный план</a>
            </div>
        @endif
    @endif
    <aside class="site__aside">
        @include('partials.account-menu')
        @if(request()->is('account/phrase'))
            @include('partials.account-filter-phrase')
        @endif
    </aside>
    <div class="inside-content">
        <div class="phrases">

        <h1 class="site__title">Фразы проекта</h1>
        <div class="magic_tabs tabs"{{-- class="tabs"--}}>

            <div class="tabs__links">
                @if($filter['stats']['not_translate'] > 0)
                <a id="tab_not_translated" @if (Request::is('account/phrase') or Request::is('account/phrase/not_translated'))class="active" @endif href="#">{{trans('account.noTranslate')}}<span id="stNotTranslate">{{$filter['stats']['not_translate']}}</span></a>
                <a id="tab_translated" @if (Request::is('account/phrase/translated'))class="active" @endif href="#">{{trans('account.inTranslate')}}<span id="stInTranslate">{{$filter['stats']['in_translate']}}</span></a>
                @else
                    <a id="tab_not_translated" href="#" style="display: none">{{trans('account.noTranslate')}}<span id="stNotTranslate">{{$filter['stats']['not_translate']}}</span></a>
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
                    <button id="from-archive" class="phrases__control-detached" style="display: none">Убрать из архива</button>
                </div>
                <button id="setViewTypeID_1" class="phrases__control-horizontal @if ($viewType == 1) active @endif"></button>
                <button id="setViewTypeID_2" class="phrases__control-column @if ($viewType == 2) active @endif"></button>
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
                                        <input type="checkbox" name="blocks[]" value="{{$t->tid}}" class="checkbox_ordering_translation" id="ordering_translation_{{$t->tid}}">
                                        <label for="ordering_translation_{{$t->tid}}"></label>
                                    </div>
                                    @include('partials.account-menu-phrase', ['ob' => $t])
                                </div>
                                <div class="history-phrase"></div>
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
                                        <input type="checkbox" name="blocks[]" value="{{$t->tid}}" class="checkbox_ordering_translation" id="ordering_translation_{{$t->tid}}">
                                        <label for="ordering_translation_{{$t->tid}}"></label>
                                    </div>
                                    @include('partials.account-menu-phrase', ['ob' => $t])
                                </div>
                                <div class="history-phrase"></div>
                            </div>
                            @endif

                        @endif

                    @endforeach


                    @if (isset($blocks))
                    <div class="paginationAjax">
                        {!! $blocks->render() !!}
                    </div>
                    @endif

                        @if($blocks->count() == 0)
                            <div class="alert alert-info">Не найдено фраз по заданным фильтрам</div>
                        @endif

                </div>
            </div>
            
            <!-- tabs__content -->

        </div>
            <!--/tabs__wrap-->
        </div>
    </div>
@stop