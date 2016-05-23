@extends('layouts.account')
@section('title') Языки проекта @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <h1 class="site__title">{{trans('account.langManagement')}}</h1>
        <a href="{{URL::route('main.account.addlanguages')}}" class="language__btn-add popup__open"><span>{{trans('account.addLang')}}</span></a>
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

        <!-- popup__wrap -->
        <div class="popup__wrap">

            <!-- popup__content -->
            <div class="popup__content popup__choice">

                <!-- popup__close -->
                <a href="#" class="popup__close">close</a>
                <!-- /popup__close -->

                <!-- selecting-language -->
                <form action="#" class="selecting-language">
                    <h2 class="site__title site__title_center">Добавление языков</h2>

                    <!-- selecting-language__items -->
                    <div class="selecting-language__items">

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang1" id="check-lang1">
                            <label for="check-lang1">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-ru.png')"></span>
                                <!-- /flag -->

                                Русский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang2" id="check-lang2">
                            <label for="check-lang2">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-us.png')"></span>
                                <!-- /flag -->

                                Английский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang3" id="check-lang3">
                            <label for="check-lang3">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-fr.png')"></span>
                                <!-- /flag -->

                                Французский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang4" id="check-lang4">
                            <label for="check-lang4">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-it.png')"></span>
                                <!-- /flag -->

                                Итальянский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang5" id="check-lang5">
                            <label for="check-lang5">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-ru.png')"></span>
                                <!-- /flag -->

                                Русский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang6" id="check-lang6">
                            <label for="check-lang6">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-us.png')"></span>
                                <!-- /flag -->

                                Английский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang7" id="check-lang7">
                            <label for="check-lang7">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-fr.png')"></span>
                                <!-- /flag -->

                                Французский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang8" id="check-lang8">
                            <label for="check-lang8">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-it.png')"></span>
                                <!-- /flag -->

                                Итальянский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang9" id="check-lang9">
                            <label for="check-lang9">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-ru.png')"></span>
                                <!-- /flag -->

                                Русский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang10" id="check-lang10">
                            <label for="check-lang10">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-us.png')"></span>
                                <!-- /flag -->

                                Английский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang11" id="check-lang11">
                            <label for="check-lang11">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-fr.png')"></span>
                                <!-- /flag -->

                                Французский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang12" id="check-lang12">
                            <label for="check-lang12">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-it.png')"></span>
                                <!-- /flag -->

                                Итальянский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang13" id="check-lang13">
                            <label for="check-lang13">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-ru.png')"></span>
                                <!-- /flag -->

                                Русский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang14" id="check-lang14">
                            <label for="check-lang14">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-us.png')"></span>
                                <!-- /flag -->

                                Английский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang15" id="check-lang15">
                            <label for="check-lang15">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-fr.png')"></span>
                                <!-- /flag -->

                                Французский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang16" id="check-lang16">
                            <label for="check-lang16">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-it.png')"></span>
                                <!-- /flag -->

                                Итальянский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang17" id="check-lang17">
                            <label for="check-lang17">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-ru.png')"></span>
                                <!-- /flag -->

                                Русский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang18" id="check-lang18">
                            <label for="check-lang18">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-us.png')"></span>
                                <!-- /flag -->

                                Английский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang19" id="check-lang19">
                            <label for="check-lang19">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-fr.png')"></span>
                                <!-- /flag -->

                                Французский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang20" id="check-lang20">
                            <label for="check-lang20">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-it.png')"></span>
                                <!-- /flag -->

                                Итальянский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang21" id="check-lang21">
                            <label for="check-lang21">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-ru.png')"></span>
                                <!-- /flag -->

                                Русский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang22" id="check-lang22">
                            <label for="check-lang22">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-us.png')"></span>
                                <!-- /flag -->

                                Английский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang23" id="check-lang23">
                            <label for="check-lang23">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-fr.png')"></span>
                                <!-- /flag -->

                                Французский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang24" id="check-lang24">
                            <label for="check-lang24">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-it.png')"></span>
                                <!-- /flag -->

                                Итальянский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang25" id="check-lang25">
                            <label for="check-lang25">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-ru.png')"></span>
                                <!-- /flag -->

                                Русский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang26" id="check-lang26">
                            <label for="check-lang26">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-us.png')"></span>
                                <!-- /flag -->

                                Английский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang27" id="check-lang27">
                            <label for="check-lang27">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-fr.png')"></span>
                                <!-- /flag -->

                                Французский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang28" id="check-lang28">
                            <label for="check-lang28">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-it.png')"></span>
                                <!-- /flag -->

                                Итальянский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang29" id="check-lang29">
                            <label for="check-lang29">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-ru.png')"></span>
                                <!-- /flag -->

                                Русский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang30" id="check-lang30">
                            <label for="check-lang30">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-us.png')"></span>
                                <!-- /flag -->

                                Английский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang31" id="check-lang31">
                            <label for="check-lang31">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-fr.png')"></span>
                                <!-- /flag -->

                                Французский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang32" id="check-lang32">
                            <label for="check-lang32">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-it.png')"></span>
                                <!-- /flag -->

                                Итальянский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang33" id="check-lang33">
                            <label for="check-lang33">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-ru.png')"></span>
                                <!-- /flag -->

                                Русский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang34" id="check-lang34">
                            <label for="check-lang34">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-us.png')"></span>
                                <!-- /flag -->

                                Английский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang35" id="check-lang35">
                            <label for="check-lang35">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-fr.png')"></span>
                                <!-- /flag -->

                                Французский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang36" id="check-lang36">
                            <label for="check-lang36">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-it.png')"></span>
                                <!-- /flag -->

                                Итальянский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang37" id="check-lang37">
                            <label for="check-lang37">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-ru.png')"></span>
                                <!-- /flag -->

                                Русский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang38" id="check-lang38">
                            <label for="check-lang38">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-us.png')"></span>
                                <!-- /flag -->

                                Английский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang39" id="check-lang39">
                            <label for="check-lang39">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-fr.png')"></span>
                                <!-- /flag -->

                                Французский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                        <!-- nice-check-language -->
                        <div class="nice-check-language">
                            <input type="checkbox" name="check-lang40" id="check-lang40">
                            <label for="check-lang40">

                                <!-- flag -->
                                <span class="flag" style="background-image: url('assets/img/account/icons-it.png')"></span>
                                <!-- /flag -->

                                Итальянский

                            </label>
                        </div>
                        <!-- /nice-check-language -->

                    </div>
                    <!-- /selecting-language__items -->

                    <!-- selecting-language__items -->
                    <button class="btn btn_8 btn_blue" type="submit">
                        Добавить
                    </button>
                    <!-- selecting-language__items -->

                </form>
                <!-- /selecting-language -->

            </div>
            <!-- /popup__content -->

        </div>
        <!-- /popup__wrap -->

    </div>
@stop