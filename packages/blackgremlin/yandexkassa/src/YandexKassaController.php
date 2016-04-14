<?php

namespace Blackgremlin\Yandexkassa;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class YandexKassaController extends Controller
{
    /**
     * Показать платежную форму
     * @return \Illuminate\Http\Response
     */
    public function showForm($orderId, $customerId, $sum)
    {
        $config = \Config::get('yakassa');
        return view('yakassa::form', compact('orderId', 'customerId', 'sum', 'config'));
    }

    /**
     * Проверка данных заказа яндексом
     * Вывод xml для яшки
     * @return void
     */
    public function check(Request $request)
    {
        $code = 1;
        $shopId = \Config::get('yakassa.shopId');
        $params = $request->only([
            'action', 'md5', 'orderSumAmount', 'orderSumCurrencyPaycash', 'orderSumBankPaycash', 'invoiceId', 'customerNumber'
        ]);
        $invId = $request->get('invoiceId');
        $date = $request->get('requestDatetime');
        if (checkYandexSign($params)) {
            $code = 0;
        }
        $xml = '<?xml version="1.0" encoding="UTF-8"?><checkOrderResponse performedDatetime="'.$date.'" code="'.$code.'" invoiceId="'.$invId.'" shopId="'.$shopId.'"/>';
        header('Content-type:text/xml;');
        echo $xml;
    }

    /**
     * Уведомление о платеже от яндекса
     * @return \Illuminate\Http\Response
     */
    public function aviso(Request $request)
    {
        $code = 1;
        $shopId = \Config::get('yakassa.shopId');
        $params = $request->only([
            'action', 'md5', 'orderSumAmount', 'orderSumCurrencyPaycash', 'orderSumBankPaycash', 'invoiceId', 'customerNumber'
        ]);
        $invId = $request->get('invoiceId');
        $date = $request->get('requestDatetime');
        if (checkYandexSign($params)) {
            $code = 0;
        }
        $xml = '<?xml version="1.0" encoding="UTF-8"?><paymentAvisoResponse performedDatetime="'.$date.'" code="'.$code.'" invoiceId="'.$invId.'" shopId="'.$shopId.'"/>';
        header('Content-type:text/xml;');
        echo $xml;
        $payment = \App\Payment::find($invId);
        if (!empty($payment)) {
            $payment->is_draft = 0;
            $payment->status = 'confirmed';
            $payment->save();
            if ($payment->relation == 'App\Subscription') {
                $subscription = \App\Subscription::find($payment->outer_id);
                if ($subscription) {
                    $subscription->deposit = $subscription->deposit + $payment->original_sum;
                    $subscription->save();
                    \Event::fire('blocks.changed', $subscription);
                }
            }
            if ($payment->relation == 'App\Order') {
                $order = \App\Order::find($payment->outer_id);
                if ($order) {
                    $order->status = 'process';
                    $order->save();
                    \Event::fire('order.payed', $order);
                }
            }
        }
        // TODO начисления партнеру
    }

}
