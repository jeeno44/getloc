@foreach ($blocks as $t)
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
            <input type="checkbox" name="blocks[]" value="{{$t->tid}}" class="checkboxPhrase" id="publish_{{$t->tid}}">
            <label for="publish_{{$t->tid}}">@if ($t->enabled){{trans('account.cancelPublishing')}}@else{{trans('account.publishing')}}@endif</label>
        </div>
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
            <input type="checkbox" name="blocks[]" value="{{$t->tid}}" class="checkboxPhrase" id="publish_{{$t->tid}}">
            <label for="publish_{{$t->tid}}">@if ($t->enabled){{trans('account.cancelPublishing')}}@else{{trans('account.publishing')}}@endif</label>
        </div>
        @include('partials.account-menu-phrase', ['ob' => $t])
    </div>
</div>

@endif

@endforeach
@if (isset($blocks))
    <div class="paginationAjax">
    {!! $blocks->render() !!}
    </div>
@endif
