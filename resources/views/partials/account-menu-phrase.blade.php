<div class="phrases__item-controls-right">
    <div class="phrases__item-controls-menu">
        <div>
            <ul>
                <li>
                    <a href="#">{{trans('account.history')}}</a>
                </li>
                <li>
                    <a class="active" href="#">{{trans('account.useRobotTrans')}}</a>
                </li>
                <li>
                    <a href="#">{{trans('account.markHand')}}</a>
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
            1 => 'января', 2 => 'февраля', 3 => 'марта', 4 => 'апреля',
            5 => 'мая', 6 => 'июня', 7 => 'июля', 8 => 'августа',
            9 => 'сентября', 10 => 'октября', 11 => 'ноября', 12 => 'декабря'
        );
        $month = date('d', strtotime($ob->date)) . ' ' .$monthes[(date('n', strtotime($ob->date)))] . ' ' . date('Y', strtotime($ob->date));
        echo $month;
        ?>
    </time>
</div>