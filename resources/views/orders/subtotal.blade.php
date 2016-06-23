<p>{{trans('account.t_prepare_price_order')}} {{$baseCost}} {{trans('phrases.rubles')}}</p>
@if($couponShow)
    <p>{{trans('account.t_subtotal_text2')}} {{$couponShow}}</p>
@endif
<p><strong>{{trans('account.t_subtotal_total')}} {{$subtotal}} {{trans('phrases.rubles')}}</strong></p>