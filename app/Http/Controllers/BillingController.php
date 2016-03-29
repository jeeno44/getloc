<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Subscription;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Plan;
use App\Site;

class BillingController extends Controller
{
    private $sites = [];

    public function __construct()
    {
        parent::__construct();
        $this->sites = Site::where('user_id', $this->user->id)->orderBy('url')->get();
        \View::share('sites', $this->sites);
    }

    /**
     * Вывод списка тарифов
     * @return \Illuminate\Http\Response
     */
    public function index($siteId)
    {
        $plans = Plan::where('enabled', 1)->get();
        $activity = true;
        $subscription = Subscription::where('user_id', $this->user->id)->first();
        if (empty($subscription) || $subscription->ends_at <= Carbon::now()->toDateTimeString()) {
            $activity = false;
        }
        return view('billing.index', compact('plans', 'activity', 'subscription'));
    }

    /**
     * Подготовка данных для покупки и редирект на яндекс кассу
     * @param int $planId
     * @return \Illuminate\Http\Response
     */
    public function prepare($planId)
    {
        $plan = Plan::find($planId);
        if (empty($plan)) {
            abort(404);
        }
        $payment = new Payment([
            'plan_id'   => $plan->id,
            'user_id'   => $this->user->id,
            'sum'       => $plan->cost,
            'status'    => 'new',
            'provider'  => 'Тестовый платеж',
        ]);
        $payment->save();
        if ($payment->provider == 'Яндекс.Касса') {
            return redirect()->route('yandex-kassa.form', [$payment->id, $this->user->id, intval($payment->cost)]);
        } else { //TODO удалить после подключения якассы
            $payment->status = 'confirmed';
            $payment->save();
            $subscription = Subscription::where('user_id', $this->user->id)->first();
            if (empty($subscription)) {
                $subscription = new Subscription([
                    'plan_id'       => $planId,
                    'user_id'       => $this->user->id,
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
            return redirect()->route('main.billing.success');
        }
    }

    /**
     * Апгрейд тарифного плана
     * @param int $planId
     * @return \Illuminate\Http\Response
     */
    public function upgrade($planId)
    {
        // TODO обновление тарифа, пересчет дат и блоков
    }

    /**
     * Вывод сообщения об успешной транзакции
     * @return \Illuminate\Http\Response
     */
    public function success()
    {
        // TODO вьюхи или редирект
        return "Все хорошо";
    }

    /**
     * Вывод сообщения об ошибке или отказе
     * @return \Illuminate\Http\Response
     */
    public function fail()
    {
        // TODO вьюхи или редирект
        return "Все не очень хорошо";
    }


}
