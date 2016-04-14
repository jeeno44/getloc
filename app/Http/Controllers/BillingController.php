<?php

namespace App\Http\Controllers;

use App\Payment;
use App\PaymentDetail;
use App\PaymentType;
use App\Subscription;
use App\User;
use App\UserDetail;
use App\WebForm;
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
     * Покупка первого тарифа
     * @return \Illuminate\Http\Response
     */
    public function index($siteId)
    {
        $objPlans = Plan::where('enabled', 1)->get();
        $plans = [];
        foreach ($objPlans as $p) {
            $plans[$p->id] = $p->name.' - '.$p->cost.' '.trans('phrases.rubles');
        }
        $paymentTypes = PaymentType::lists('name', 'id')->toArray();
        $site = Site::find($siteId);
        if (!$site || $site->user_id != $this->user->id) {
            abort(404);
        }
        $detail = UserDetail::where('user_id', $this->user->id)->first();
        if (!$detail) {
            $detail = new UserDetail();
        }
        return view('billing.index', compact('plans', 'site', 'detail', 'paymentTypes'));
    }

    public function prolong($siteId)
    {
        $site = Site::find($siteId);
        if ($site && $site->user_id == $this->user->id) {
            $user = $this->user;
            $subscription = Subscription::where('user_id', $this->user->id)->where('site_id', $siteId)->first();
            if (!$subscription) {
                return redirect()->route('main.billing', ['id' => $siteId]);
            }
            $paymentTypes = PaymentType::lists('name', 'id')->toArray();
            return view('billing.prolong', compact('site', 'user', 'subscription', 'paymentTypes'));
        }
        abort(403, 'У вас нет доступа к этому сайту');
    }

    /**
     * Апгрейд тарифного плана
     * @param int $planId
     * @return \Illuminate\Http\Response
     */
    public function upgrade($siteId)
    {
        $site = Site::find($siteId);
        if (!$site || $site->user_id != $this->user->id) {
            abort(403, 'У вас нет доступа к этому сайту');
        }
        $subscription = Subscription::where('site_id', $siteId)->first();
        if (!$subscription) {
            return redirect()->route('main.billing', ['id' => $siteId]);
        }
        $objPlans = Plan::where('enabled', 1)->where('id', '!=', $subscription->plan_id)->get();
        $plans = [];
        foreach ($objPlans as $p) {
            $plans[$p->id] = $p->name.' - '.$p->cost.' '.trans('phrases.rubles');
        }
        $paymentTypes = PaymentType::lists('name', 'id')->toArray();
        return view('billing.upgrade', compact('plans', 'site', 'paymentTypes'));
    }

    public function upgradeStore(Request $request)
    {
        $plan = Plan::find($request->get('plan_id'));
        $site = Site::find($request->get('site_id'));
        $subscription = Subscription::where('site_id', $request->get('site_id'))->first();
        if (!$site || $site->user_id != $this->user->id || !$plan || !$subscription) {
            abort(403, 'У вас нет доступа к этому сайту');
        }
        $subscription->month_cost = $plan->cost;
        $subscription->count_words = $plan->count_words;
        $subscription->count_languages = $plan->count_languages;
        $subscription->plan_id = $plan->id;
        $subscription->save();
        return redirect()->route('main.account');
    }

    /**
     * Подготовка данных для покупки
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response|mixed
     */
    public function prepare(Request $request)
    {
        $plan = Plan::find($request->get('plan_id'));
        $site = Site::find($request->get('site_id'));
        $paymentType = PaymentType::find($request->get('payment_type_id'));
        if (!$plan || !$site || $site->user_id != $this->user->id || !$paymentType) {
            abort(404);
        }
        $couponId = null;
        if ($coupon = getCouponState($request->get('coupon'), $site->id)) {
            $couponId = $coupon->id;
        }
        $subtotal = getSubTotal($plan->cost, $request->get('coupon'), $request->get('site_id'), $request->get('time'));
        $subscription = Subscription::where('site_id', $request->get('site_id'))->first();
        if (!$subscription) {
            $subscription = new Subscription([
                'site_id'           => $site->id,
                'user_id'           => $this->user->id,
                'plan_id'           => $plan->id,
                'count_words'       => $plan->count_words,
                'white_label'       => $plan->white_label,
                'count_languages'   => $plan->count_languages,
                'month_cost'        => $plan->cost,
            ]);
            $subscription->save();
        } else {
            $subscription->update([
                'plan_id'           => $plan->id,
                'count_words'       => $plan->count_words,
                'white_label'       => $plan->white_label,
                'count_languages'   => $plan->count_languages,
                'month_cost'        => $plan->cost,
            ]);
        }
        $payment = new Payment([
            'outer_id'          => $subscription->id,
            'relation'          => 'App\Subscription',
            'user_id'           => $this->user->id,
            'sum'               => $subtotal,
            'original_sum'      => $subscription->month_cost * intval($request->get('time')),
            'status'            => 'new',
            'coupon_id'         => $couponId,
            'payment_type_id'   => $paymentType->id,
        ]);
        $payment->save();
        if ($paymentType->slug == 'yandex.kassa') {
            return redirect()->route('yandex-kassa.form', [$payment->id, $this->user->id, intval($payment->cost)]);
        } elseif ($paymentType->slug == 'beznal') {
            return redirect()->route('main.billing.details-form', [$payment->id]);
        }
        return redirect()->back();
    }

    public function detailsForm($id)
    {
        $payment = Payment::find($id);
        $detail = UserDetail::where('user_id', $this->user->id)->first();
        if (!$detail) {
            $detail = new UserDetail();
        }
        return view('billing.details-form', compact('detail', 'payment'));
    }

    public function detailsStore($id, Request $request)
    {
        $data = $request->all();
        $detail = UserDetail::where('user_id', $this->user->id)->first();
        if (!$detail) {
            $data['user_id'] = $this->user->id;
            $detail = new UserDetail($data);
        }
        $detail->fill($data);
        $detail->save();
        $paymentDetail = new PaymentDetail($data);
        $payment = Payment::find($id);
        $paymentDetail->payment_id = $payment->id;
        $paymentDetail->save();
        $payment->is_draft = 0;
        $payment->save();
        return redirect()->route('main.billing.status')->with(['status' => trans('phrases.vam_invoice')]);
    }

    public function individual($siteId)
    {
        $site = Site::find($siteId);
        if ($site && $site->user_id == $this->user->id) {
            $user = $this->user;
            return view('billing.individual', compact('site', 'user'));
        }
        abort(403, 'У вас нет доступа к этому сайту');
    }

    public function individualSend($siteId, Request $request)
    {
        $site = Site::find($siteId);
        if ($site && $site->user_id == $this->user->id) {
            WebForm::create([
                'site'      => $site->url,
                'name'      => $request->get('name'),
                'phone'     => $request->get('phone'),
                'email'     => $request->get('email'),
                'text'      => $request->get('text'),
                'form_name' => 'Индивидуальные условия'
            ]);
            return redirect()->route('main.billing.status')->with(['status' => 'Спасибо за обращение. Мы рассмотрим вашу заявку']);
        }
        abort(403, 'У вас нет доступа к этому сайту');
    }

    public function status()
    {
        return view('billing.status');
    }

    public function paymentsHistory()
    {

    }

    /**
     * Вывод сообщения об успешной транзакции
     * @return \Illuminate\Http\Response
     */
    public function success()
    {
        return redirect()->route('main.billing.status')->with(['status' => 'Спасибо. Ваш платеж успешно завершен']);
    }

    /**
     * Вывод сообщения об ошибке или отказе
     * @return \Illuminate\Http\Response
     */
    public function fail()
    {
        return redirect()->route('main.billing.status')->with(['status' => 'Вы отказались от платежа']);
    }

    /**
     * Проверка состояния купона
     * @param Request $request
     * @return string
     */
    public function validateCoupon(Request $request)
    {
        if ($coupon = getCouponState($request->get('coupon'), $request->get('site_id'))) {
            $end = ($coupon->is_percent == 0) ? ' '.trans('phrases.rubles') : '%';
            return '- '.$coupon->discount.$end;
        }
        return '';
    }

    /**
     * Расчет суммы к оплате
     * @param Request $request
     * @return int
     */
    public function subtotal(Request $request)
    {
        $plan = Plan::find($request->get('plan_id'));
        $time = $request->get('time');
        $subtotal = $baseCost = $plan->cost * $time;
        $couponDiscount = 0;
        $couponShow = $couponMessage = '';
        if ($request->has('coupon')) {
            $couponMessage = trans('phrases.coupon_fail');
        }
        if ($coupon = getCouponState($request->get('coupon'), $request->get('site_id'))) {
            if ($coupon->is_percent == 1) {
                $couponDiscount = $subtotal / 100 * $coupon->discount;
                $end = ' ('.$coupon->discount. '%): '.$couponDiscount.' '.trans('phrases.rubles');
            } else {
                $couponDiscount = $coupon->discount;
                $end = $couponDiscount. ': '.trans('phrases.rubles');
            }
            $couponShow = $end;
            $couponMessage = trans('phrases.coupon_accept');
            $coupon->user_id = $this->user->id;
            $coupon->save();
        }
        $subtotal = $subtotal - $couponDiscount;
        $timeDiscount = getDiscountByTime($request->get('time'));
        $timeDiscountSum = $subtotal / 100 * $timeDiscount;
        $subtotal = $subtotal - $timeDiscountSum;
        if ($subtotal < 0) {
            $subtotal = 0;
        }
        $resp['html'] = (String) view('billing.subtotal', compact('subtotal', 'timeDiscount', 'timeDiscountSum', 'couponShow', 'baseCost', 'couponDiscount', 'time'));
        $resp['coupon'] = $couponMessage;
        return json_encode($resp, JSON_HEX_QUOT | JSON_HEX_TAG);
    }


}
