<p>Стоимость подписки по тарифу: {{$baseCost}} {{trans('phrases.rubles')}}</p>
@if($couponShow)
    <p>Скидка по купону {{$couponShow}}</p>
@endif
@if($timeDiscount)
    <p>Скидка при оплате за {{getDurationsByKey($time)}} ({{$timeDiscount}})%: {{$timeDiscountSum}} {{trans('phrases.rubles')}}</p>
@endif
<p><strong>Итого к оплате: {{$subtotal}} {{trans('phrases.rubles')}}</strong></p>