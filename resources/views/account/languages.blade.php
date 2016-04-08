@extends('layouts.account')
@section('title') Языки проекта @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <h1 class="site__title">{{trans('account.langManagement')}}</h1>
        <a href="{{URL::route('main.account.addlanguages')}}" class="btn_add"><span>{{trans('account.addLang')}}</span></a>
        <div class="language__wrap">
            @if (isset($lineStats['on']))
                @foreach ($lineStats['on'] as $lang => $data)
                    <div class="language__item inside-content__wrap">
                        <div class="language__control">
                            <div class="translation__language">
                                <span class="translation__language-flag" style="background-image: url('/assets/img/icons-en.png')"></span>
                                {{$lang}}
                            </div>
                            <div class="translation__info">
                                {{trans('account.inProcTranslate')}}
                                <span class="translation__num">{{$data['ccTranslates']}} / {{$ccBlocks}}</span>
                                {{Lang::choice('account.phrases', $data['ccTranslates'])}}
                            </div>
                            <div data-langid='{{$data['langID']}}' class="control__btn-lock btn-lock btn-lock_on turnLang"></div>
                        </div>
                        <div class="language__links" data-langid='{{$data['langID']}}'>
                            <a href="/account/phrase" class="search_language">{{trans('account.showTranslate')}}</a>
                            <a href="#" class="order_translation">{{trans('account.orderTrans')}}</a>
                            <a href="#" class="download_file">{{trans('account.downloadFile')}}</a>
                        </div>
                        <div class="language_line statistic__line">
                            @foreach ($data['lines'] as $graph)
                                <div class="statistic__line-0{{$graph['i']}}" style="width: {{$graph['per']}}%">
                                    <span class="statistic__line-number">@if ($graph['cc'] != 0){{$graph['cc']}}@endif</span>
                                    <span class="statistic__line-popup">{{trans('account.'.$graph['name'])}}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif

            @if (isset($lineStats['off']))
                @foreach ($lineStats['off'] as $lang => $data)
                    <div class="language__item inside-content__wrap language_inactive">
                        <div class="language__control">
                            <div class="translation__language">
                                <span class="translation__language-flag" style="background-image: url('/assets/img/icons-en.png')"></span>
                                {{$lang}}
                            </div>
                            <div class="translation__info">
                                {{trans('account.inProcTranslate')}}
                                <span class="translation__num">{{$data['ccTranslates']}} / {{$ccBlocks}}</span>
                                {{Lang::choice('account.phrases', $data['ccTranslates'])}}
                            </div>
                            <div data-langid='{{$data['langID']}}' class="control__btn-lock btn-lock turnLang"></div>
                        </div>
                        <div class="language__links">
                            <a href="#">{{trans('account.showTranslate')}}</a>
                            <a href="#">{{trans('account.orderTrans')}}</a>
                            <a href="#">{{trans('account.downloadFile')}}</a>
                        </div>
                        <div class="language_line statistic__line">
                            @foreach ($data['lines'] as $graph)
                                <div class="statistic__line-0{{$graph['i']}}" style="width: {{$graph['per']}}%">
                                    <span class="statistic__line-number">@if ($graph['cc'] != 0){{$graph['cc']}}@endif</span>
                                    <span class="statistic__line-popup">{{trans('account.'.$graph['name'])}}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif
            <h1 class="site__subtitle">{{trans('account.offLang')}}</h1>
        </div>
    </div>

@stop