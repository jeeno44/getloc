<p>{{trans('account.t_subtotal_text1')}} {{$baseCost}} {{trans('phrases.rubles')}}</p>
@if($couponShow)
    <p>{{trans('account.t_subtotal_text2')}} {{$couponShow}}</p>
@endif
@if($timeDiscount)
    <p>{{trans('account.t_subtotal_text3')}} {{getDurationsByKey($time)}} ({{$timeDiscount}})%: {{$timeDiscountSum}} {{trans('phrases.rubles')}}</p>
@endif
<p><strong>{{trans('account.t_subtotal_total')}} {{$subtotal}} {{trans('phrases.rubles')}}</strong></p>