@extends('layouts.account')
@section('title') Фразы проекта @stop
@section('content') 
<aside class="site__aside">
    @include('partials.account-menu')
    @include('partials.account-filter-phrase')
</aside>
    <div class="inside-content">
        <div class="phrases">
        <h1 class="site__title">Фразы проекта</h1>
        <div class="magic_tabs"{{-- class="tabs"--}}>
            <div class="tabs__links">
                <a @if (Request::is('account/phrase') or Request::is('account/phrase/not_translated'))class="active" @endif href="{{URL::route('main.account.phrase1')}}">{{trans('account.noTranslate')}}<span>{{$filter['stats']['not_translate']}}</span></a>
                <a @if (Request::is('account/phrase/translated'))class="active" @endif href="{{URL::route('main.account.phrase2')}}">{{trans('account.inTranslate')}}<span>{{$filter['stats']['in_translate']}}</span></a>
                <a @if (Request::is('account/phrase/published'))class="active" @endif href="{{URL::route('main.account.phrase3')}}">{{trans('account.inPublish')}}<span>{{$filter['stats']['publish']}} </span></a>
                <div class="tabs__links-archive">
                    <a href="#">{{trans('account.archive')}}</a>
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
            <div class="tabs__content">
                <div class="active" style="display: block;" class="phrases__tab">
                    @foreach ($blocks as $t)
                    @if ( $viewType == 2)
                    <div class="phrases__item @if ($t->type_translate_id)phrases__item_mark-{{$filter['colors'][$t->type_translate_id]['block']}} @endif">
                        <div class="phrases__item-col">
                            {{$t->original}}
                        </div>
                        <form class="phrases__item-col phrases__item-col_translate">
                            <textarea id="order_{{$t->tid}}">{{$t->text}}</textarea>
                            <div class="phrases__item-col-btns">
                                <button class="save save_translate" object-id="{{$t->tid}}" type="submit">{{trans('account.save')}}</button>
                                <button class="cancel">{{trans('account.cancel')}}</button>
                            </div>
                            <button class="phrases__item-btn-translate go_robot" data-id="{{$t->tid}}">{{trans('account.useRobotTrans')}}</button>
                        </form>
                        
                        <div class="phrases__item-controls">
                            <div class="nice-check">
                                <input type="checkbox" name="blocks[]" value="{{$t->block_id}}" class="checkboxPhrase" id="publish_{{$t->tid}}">
                                <label for="publish_{{$t->tid}}">@if ($t->enabled){{trans('account.cancelPublishing')}}@else{{trans('account.publishing')}}@endif</label>
                            </div>
                            @include('partials.account-menu-phrase', ['ob' => $t])
                        </div>
                    </div>
                    @else
                    <div class="phrases__item @if ($t->type_translate_id)phrases__item_mark-{{$filter['colors'][$t->type_translate_id]['block']}} @endif">
                        <div class="phrases__item-col phrases__item-col_block">
                            {{$t->original}}
                        </div>
                        <div class="phrases__item-col phrases__item-col_block phrases__item-col_translate">
                            <textarea id="order_{{$t->tid}}" readonly>{{$t->text}}</textarea>
                            <div class="phrases__item-col-btns">
                                <button class="save save_translate" object-id="{{$t->tid}}" type="submit">{{trans('account.save')}}</button>
                                <button class="cancel">{{trans('account.cancel')}}</button>
                            </div>
                            <button class="phrases__item-btn-translate go_robot" data-id="{{$t->tid}}">{{trans('account.useRobotTrans')}}</button>
                        </div>
                        <div class="phrases__item-controls">
                            <div class="nice-check">
                                <input type="checkbox" name="blocks[]" value="{{$t->block_id}}" class="checkboxPhrase" id="publish_{{$t->tid}}">
                                <label for="publish_{{$t->tid}}">@if ($t->enabled){{trans('account.cancelPublishing')}}@else{{trans('account.publishing')}}@endif</label>
                            </div>
                            @include('partials.account-menu-phrase', ['ob' => $t])
                        </div>
                    </div>

                    @endif
                    
                    @endforeach
                    @if (isset($blocks))
                        {!! $blocks->render() !!}
                    @endif
                </div>
            </div>
            
            <!-- tabs__content -->

        </div>
            <!--/tabs__wrap-->
        </div>
    </div>
@stop