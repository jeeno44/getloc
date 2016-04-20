{{--{{ $pathName }}--}}

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
                        @if ( $tab != 'tab_not_translated' )
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
                    {{ dd($t) }}
                    <div class="historyPhrase">История перевода фразы</div>
                    @include('partials.account-menu-phrase', ['ob' => $t])
                </div>
            </div>
            @else
            <div class="phrases__item @if ($t->type_translate_id)phrases__item_mark-{{$filter['colors'][$t->type_translate_id]['block']}} @endif" id="phrase_{{$t->tid}}">
                <div class="phrases__item-col phrases__item-col_block">
                    <label for="order_{{$t->tid}}">{!! $t->original !!}</label>
                </div>
                <div class="phrases__item-col phrases__item-col_block phrases__item-col_translate">
                    <textarea onkeyup="$(this).attr('data-type', 2)" id="order_{{$t->tid}}" readonly>{{$t->text}}</textarea>
                    <div class="phrases__item-col-btns">
                        <button class="save save_translate" object-id="{{$t->tid}}" type="submit">{{trans('account.save')}}</button>
                        <button class="cancel">{{trans('account.cancel')}}</button>
                        @if ( $tab != 'tab_not_translated' )
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
{{--                    {{ dd($historyPhrase->groupBy('translate_id')->toArray()) }}--}}
                    @if(isset($historyPhrase->groupBy('translate_id')->toArray()[$t->tid]) && count($historyPhrase->groupBy('translate_id')->toArray()[$t->tid])>0)
                    <div class="historyPhrase">
                    <table class="">
                        <tr>
                            <th>id</th>
                            <th>текст перевода</th>
                            <th>дата перевода</th>
                        </tr>
                        @foreach($historyPhrase->groupBy('translate_id')->toArray()[$t->tid] as $history)
                        <tr>
                            <td>{{ $history['id'] }}</td>
                            <td>{{ $history['text'] }}</td>
                            <td>{{ $history['created_at'] }}</td>
                        </tr>
                        @endforeach
                    </table>
                        История перевода фразы
                    </div>
                    @else
                    <div class="historyPhrase disable">
                    <table class="">
                        <tr>
                            <th>У данной фразы пока нет истории</th>
                        </tr>
                    </table>
                    История перевода фразы
                    </div>
                    @endif

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
