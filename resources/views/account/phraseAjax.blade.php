{{--{{ $pathName }}--}}
    @foreach ($blocks as $t)
        @if($t->blocks_enabled)
            @if ( $viewType == 2)
            <div class="phrases__item @if ($t->type_translate_id)phrases__item_mark-{{$filter['colors'][$t->type_translate_id]['block']}} @endif" id="phrase_{{$t->tid}}">
                <div class="phrases__item-col">
                    <label for="order_{{$t->tid}}">{!! $t->original !!}</label>
                </div>
                <form class="phrases__item-col phrases__item-col_translate @if (!$t->type_translate_id) active @endif">
                    <textarea onkeyup="$(this).attr('data-type', 2)" id="order_{{$t->tid}}">{{$t->text}}</textarea>
                    <div class="phrases__item-col-btns"  @if(!$t->type_translate_id) style="display: block;" @endif>
                        <button class="save save_translate btn btn_blue btn_4" object-id="{{$t->tid}}" type="submit">{{trans('account.save')}}</button>
                        <button class="cancel btn btn_5">{{trans('account.cancel')}}</button>
                        @if ( $tab != 'tab_not_translated')
                        <div>
                            <button class="phrases__item-btn-translate1 go_robot isLinkMoreMenu" data-id="{{$t->tid}}">{{trans('account.useRobotTrans')}}</button>
                        </div>
                        @endif
                    </div>
                    @if (empty($t->text) or !$t->type_translate_id) <button class="phrases__item-btn-translate1 go_robot isLinkMoreMenu" data-id="{{$t->tid}}">{{trans('account.useRobotTrans')}}</button> @endif
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
                    <label for="order_{{$t->tid}}">{!! $t->original !!}</label>
                </div>
                <div class="phrases__item-col phrases__item-col_block phrases__item-col_translate  @if (!$t->type_translate_id) active @endif">
                    <textarea onkeyup="$(this).attr('data-type', 2)" id="order_{{$t->tid}}" @if($t->type_translate_id) readonly @endif>{{$t->text}}</textarea>
                    <div class="phrases__item-col-btns" @if(!$t->type_translate_id) style="display: block;" @endif>
                        <button class="save save_translate btn btn_blue btn_4" object-id="{{$t->tid}}" type="submit">{{trans('account.save')}}</button>
                        <button class="cancel btn btn_5">{{trans('account.cancel')}}</button>
                        @if ( $tab != 'tab_not_translated' or !$t->type_translate_id )
                        <a class="phrases__item-btn-translate go_robot" data-id="{{$t->tid}}">{{trans('account.useRobotTrans')}}</a>
                        @endif
                    </div>
                </div>
                <div class="phrases__item-controls">
                    <div class="nice-check">
                        <input type="checkbox" name="blocks[]" value="{{$t->tid}}" class="checkbox_ordering_translation" id="ordering_translation_{{$t->tid}}">
                        <label for="ordering_translation_{{$t->tid}}"></label>
                    </div>
                    @include('partials.account-menu-phrase', ['ob' => $t, 'tab' => $tab])
                </div>
                <div class="history-phrase"></div>
            </div>
            @endif
        @endif
    @endforeach


@if (!empty($blocks->render()))
    <div class="paginationAjax pagination-wrap">
        {!! $blocks->render() !!}
        <div class="pagination__count site__align-right">
            <span>{{trans('account.t_phrase_show_me')}}:</span>
            <?php $countItems = Session::get('count_items', 20)?>
            <a href="#" class="count-items @if($countItems == 20) active @endif" data-value="20">20</a>
            <a class="count-items @if($countItems == 50) active @endif" href="#" data-value="50">50</a>
            <a href="#" class="count-items @if($countItems == 100) active @endif" data-value="100">100</a>
        </div>
    </div>
@endif

@if($blocks->count() == 0)
    <div class="alert alert-info">{{trans('account.t_phrase_not_find_phrases')}}</div>
@endif