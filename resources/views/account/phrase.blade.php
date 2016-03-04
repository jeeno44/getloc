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
        @if (isset($languages_enabled))
        <div style="margin: 10px 0;">
            <p>Выберите язык: 
            @foreach ($languages_enabled as $lang)
            <a href="{{URL::route('main.account.showPhrase', $lang->id)}}">{{$lang->name}}</a>, 
            @endforeach
            </p>
        </div>
        @endif
        <div class="tabs">
            <div class="tabs__links">
                <a href="#tab-1">{{trans('account.noTranslate')}}<span>{{$stats['not_translate']}}</span></a>
                <a href="#tab-2">{{trans('account.inTranslate')}}<span>{{$stats['in_translate']}}</span></a>
                <a href="#">{{trans('account.inPublish')}}<span>{{$stats['publish']}} </span></a>
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
                    <button class="phrases__control-check"></button>
                    <button class="phrases__control-delete"></button>
                    <button class="phrases__control-attached"></button>
                </div>
                <button class="phrases__control-horizontal"></button>
                <button class="phrases__control-column"></button>
                <a href="#" class="btn btn_3">{{trans('account.orderTranslate')}}</a>
            </div>
            <div class="tabs__content">
                <div class="phrases__tab">
                    @foreach ($translates as $t)
                    <div class="phrases__item">
                        <div class="phrases__item-col">
                            {{$t->original}}
                        </div>
                        <form class="phrases__item-col phrases__item-col_translate">
                            <textarea id="order_{{$t->tid}}">{{$t->text}}</textarea>
                            <div class="phrases__item-col-btns">
                                <button class="save save_translate" object-id="{{$t->tid}}" type="submit">{{trans('account.save')}}</button>
                                <button class="cancel">{{trans('account.cancel')}}</button>
                            </div>
                            <!--phrases__item-btn-translate-->
                            <button class="phrases__item-btn-translate go_robot" data-id="{{$t->tid}}">Использовать машинный перевод</button>
                            <!--/phrases__item-btn-translate-->
                        </form>
                        
                        <div class="phrases__item-controls">
                            @if ($t->enabled)
                            <div class="nice-check">
                                <input type="checkbox" id="publish_{{$t->tid}}">
                                <label for="publish_{{$t->tid}}">{{trans('account.cancelPublishing')}}</label>
                            </div>
                            @endif
                            @include('partials.account-menu-phrase', ['ob' => $t])
                        </div>
                    </div>
                    @endforeach
                    @if (isset($translates))
                        {!! $translates->render() !!}
                    @endif
                </div>
                <!--/phrases__tab-->
                <div>
                    dsadsa
                </div>
            </div>
            <!-- tabs__content -->

        </div>
            <!--/tabs__wrap-->
        </div>
    </div>
@stop