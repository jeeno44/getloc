<div class="phrases__item-controls-right" @if(!empty($tab) && $tab == 'tab_acrhive') style="display: none" @endif>
    <div class="phrases__item-controls-menu">
        <div>
            <ul>
                <li>
                    <a href="#" class="show-history" data-id="{{$ob->tid}}">{{trans('account.history')}}</a>
                </li>
                <li>
                    <a class="go_robot isLinkMoreMenu" data-id="{{$ob->tid}}" href="javascript:void(0);">{{trans('account.useRobotTrans')}}</a>
                </li>
                <li>
                    <a onclick="markHandTranslate({{$ob->tid}}); return false;" href="#">{{trans('account.markHand')}}</a>
                </li>
                <li>
                    <a href="#">{{trans('account.addComment')}}</a>
                </li>
                <li>
                    <a href="#">{{trans('account.more')}}</a>
                </li>
                {{--<li>--}}
                    {{--@if($ob->blocks_enabled)--}}
                        {{--<a href="#" class="disable_display_phrase">{{trans('account.offOutputPhrase')}}</a>--}}
                    {{--@else--}}
                        {{--<a href="#" class="enabled_display_phrase">{{trans('account.onOutputPhrase')}}</a>--}}
                    {{--@endif--}}

                {{--</li>--}}

                <li>
                    @if(!$ob->is_ordered)
                        <a href="" data-id="{{ $ob->tid }}" class="addOrder">{{trans('account.addOrder')}}</a>
                        @else
                        <a href="" data-id="{{ $ob->tid }}" class="delOrder">{{trans('account.delOrder')}}</a>
                    @endif
                </li>
            </ul>
            @if($ob->translates_enabled)
                <a onclick="setArchive({{$ob->tid}}); return false;" href="#">{{trans('account.cancelPublishing')}}</a>
            @else
                <a onclick="setArchive({{$ob->tid}}); return false;" href="#">{{trans('account.addPublishing')}}</a>
            @endif

        </div>
    </div>
    @if ( $ob->name_translate )
    <button id="typeTranslate_{{$ob->id}}" class="phrases__item-controls-type phrases__item-controls-type_machine">
        {{$ob->name_translate}}
    </button>
    @else
    <button id="typeTranslate_{{$ob->tid}}" style="display: none" class=""></button>
    @endif
    <time id="dDatetime_{{$ob->tid}}" datetime="{{$ob->date}}">
        <span id="dTime_{{$ob->tid}}">{{$ob->time}}</span>
        <?php
        // TODO: i18n
        $monthes = array(
            1 => trans('account.yan'), 2 => trans('account.feb'), 3 => trans('account.mar'), 4 => trans('account.apr'),
            5 => trans('account.may'), 6 => trans('account.iun'), 7 => trans('account.iul'), 8 => trans('account.avg'),
            9 => trans('account.sem'), 10 => trans('account.okt'), 11 => trans('account.noy'), 12 => trans('account.dec')
        );
        $month = date('d', strtotime($ob->date)) . ' ' .$monthes[(date('n', strtotime($ob->date)))] . ' ' . date('Y', strtotime($ob->date));
        echo $month;
        ?>
    </time>
</div>