<form action="https://money.yandex.ru/eshop.xml" class="validate" method="post" style="opacity: 0">
    <div class="clear">
        <input type="hidden" name="sum" value="{{$sum}}"/>
        <input type="hidden" name="customerNumber" value="{{$customerId}}"/>
        <input type="hidden" name="orderNumber" value="{{$orderId}}" />
        <input name="paymentType" value="" type="hidden">
        <input name="shopId" value="{{$config['shopId']}}" type="hidden"/>
        <input name="scid" value="{{$config['scId']}}" type="hidden"/>
    </div>
    <div class="button wallet">
        <input type="submit" value="Оплатить" />
    </div>
</form>
<script>
    document.forms[0].submit();
</script>