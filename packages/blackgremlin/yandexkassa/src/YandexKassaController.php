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
            $plan = \App\Plan::find($payment->plan_id);
            $payment->status = 'confirmed';
            $payment->save();
            $subscription = \App\Subscription::where('user_id', $payment->user_id)->first();
            if (empty($subscription)) {
                $subscription = new \App\Subscription([
                    'plan_id'       => $plan->id,
                    'user_id'       => $payment->user_id,
                    'count_words'   => $plan->count_words,
                    'ends_at'       => Carbon::now()->addMonth()->toDateTimeString(),
                    'last_id'       => 0,
                ]);
                $subscription->save();
            } else {
                if ($subscription->ends_at >= Carbon::now()->toDateTimeString()) {
                    $diff = Carbon::createFromFormat('Y-m-d H:i:s', $subscription->ends_at)->diffInSeconds(Carbon::now());
                    $subscription->ends_at = Carbon::now()->addSeconds($diff)->addMonth()->toDateTimeString();
                } else {
                    $subscription->ends_at = Carbon::now()->toDateTimeString();
                }
                $subscription->plan_id = $plan->id;
                $subscription->count_words = $plan->count_words;
                $subscription->save();
            }
        }
        // TODO начисления партнеру
        // TODO пересчет блоков и даты
    }

}
