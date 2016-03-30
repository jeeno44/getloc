/**
 * Created by andy on 30.03.16.
 * billing scripts
 */
$(function(){
    if($('#subtotal').length > 0) {
        getSubTotal();
        $('.billing-inp').bind('change keyup', getSubTotal);
    }
});

function getSubTotal() {
    var data = {};
    $('.billing-inp').each(function () {
        data[$(this).attr('name')] = $(this).val();
    });
    $.ajax({
        url: "/account/billing/subtotal",
        type: 'post',
        data: data,
        dataType: 'json',
        success: function (answer) {
            $('#subtotal').html(answer.html);
            $('#coupon_validate').html(answer.coupon)
        }
    });
}