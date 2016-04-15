<p>Стоимость заказа: {{$baseCost}} {{trans('phrases.rubles')}}</p>
@if($couponShow)
    <p>Скидка по купону {{$couponShow}}</p>
@endif
<p><strong>Итого к оплате: {{$subtotal}} {{trans('phrases.rubles')}}</strong></p>