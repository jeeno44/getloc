@extends('layouts.account')
@section('title') Языки проекта @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <h1 class="site__title">{{trans('account.langManagement')}}</h1>
        <a href="{{URL::route('main.account.addlanguages')}}" class="language__btn-add popup__open" data-popup="choice"><span>{{trans('account.addLang')}}</span></a>
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
                            <a href="{{route('main.billing.make-order', ['id' => $data['langID']])}}" class="order_translation">{{trans('account.orderTrans')}}</a>
                            {{--
                                <a href="#" class="download_file">{{trans('account.downloadFile')}}</a>
                            --}}
                        </div>
                        <div class="language_line statistic__line">
                            @foreach ($data['lines'] as $graph)
                                <div class="statistic__line-0{{$graph['i']}}" style="width: {{$graph['per']}}%">
                                    <span class="statistic__line-number">@if ($graph['cc'] != 0){{$graph['cc']}}@endif</span>
                                    <span class="statistic__line-popup">{{trans('account.'.$graph['name'])}}</span>
                                </div>
                            @endforeach
                        </div>
                        @if($site->languages()->count() > 1)
                            <a class="language__item-delete" href="/account/language/delete/{{$site->id}}/{{$data['langID']}}">Удалить</a>
                        @endif
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
                        @if($site->languages()->count() > 1)
                            <a class="language__item-delete" href="/account/language/delete/{{$site->id}}/{{$data['langID']}}">Удалить</a>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <div class="popup">
        <div class="popup__wrap">
            <div class="popup__content popup__choice">
                <a href="#" class="popup__close">close</a>
                <form action="#" class="selecting-language">
                    <h2 class="site__title site__title_center">Добавление языков</h2>
                    <div class="selecting-language__items">
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang1" id="check-lang1">
                            <label for="check-lang1">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-ru.png')"></span>
                                <!-- /flag -->

                                Русский

                            </label>
                        </div>
                    </div>
                    <button class="btn btn_8 btn_blue" type="submit">
                        Добавить
                    </button>
                </form>
            </div>
        </div>
    </div>
@stop