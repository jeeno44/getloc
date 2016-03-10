<div class="phrases__item-controls-right">
    <div class="phrases__item-controls-menu">
        <div>
            <ul>
                <li>
                    <a href="#">{{trans('account.history')}}</a>
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
            </ul>
            <a href="#">{{trans('account.sendInArchive')}}</a>
        </div>
    </div>
    @if ( $ob->name_translate )
    <button class="phrases__item-controls-type phrases__item-controls-type_machine">
        {{$ob->name_translate}}
    </button>
    @endif
    <time datetime="{{$ob->date}}">
        <span>{{$ob->time}}</span>
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