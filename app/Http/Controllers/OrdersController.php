<?php

namespace App\Http\Controllers;

use App\Language;
use App\Order;
use App\Site;
use App\Translate;
use Illuminate\Http\Request;
use App\PaymentType;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Payment;

class OrdersController extends Controller
{
    /**
     * Все проекты юзера
     * @var array
     */
    private $sites = [];

    /**
     * Текущий проект в сессии
     * @var \App\Site
     */
    private $site;

    public function __construct()
    {
        parent::__construct();
        $site = Site::find(\Session::get('projectID'));
        $this->sites = Site::where('user_id', $this->user->id)->orderBy('url')->get();
        \View::share('sites', $this->sites);
        $this->site = $site;
    }

    /**
     * Страница Мои заказы
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index($id = null)
    {
        $site = $this->site;
        if (empty($site) || $site->user_id != $this->user->id) {
            return redirect(route('main.account.selectProject'));
        }
        $order = Order::where('site_id', $site->id)->where('status', 'new')->latest()->first();
        if (!$order) {
            $order = new Order([
                'site_id'   => $site->id,
                'status'    => 'new',
                'user_id'   => $site->user_id,
            ]);
            $order->save();
        }
        $translates = $this->getTranslatesToOrder($site);
        if (count($translates) == 0) {
            $order->delete();
        }
        $currentOrder = [];
        $allWords = $allPhrases = $fullCost = 0;
        foreach ($translates as $translate) {
            if (!empty($currentOrder[$translate->original_name])) {
                $currentOrder[$translate->original_name]['count_words'] += $translate->count_words;
                $currentOrder[$translate->original_name]['count_phrases'] += 1;
                $currentOrder[$translate->original_name]['cost'] += ($translate->word_cost * $translate->count_words);
            } else {
                $currentOrder[$translate->original_name]['count_words'] = $translate->count_words;
                $currentOrder[$translate->original_name]['count_phrases'] = 1;
                $currentOrder[$translate->original_name]['cost'] = ($translate->word_cost * $translate->count_words);
                $currentOrder[$translate->original_name]['lang_id'] = $translate->language_id;
                $currentOrder[$translate->original_name]['icon'] = $translate->icon;
            }
            $currentOrder[$translate->original_name]['texts'][] = $translate->text;
            $allWords += $translate->count_words;
            $allPhrases += 1;
            $fullCost += ($translate->word_cost * $translate->count_words);
        }
        $orders = Order::whereIn('status', ['process', 'wait'])
            ->where('site_id', $site->id)
            ->latest()
            ->get();
        foreach ($orders as $key => $order) {
            $langs = \DB::table('order_translate')
                ->where('order_translate.order_id', $order->id)
                ->leftJoin('translates', 'translates.id', '=', 'order_translate.translate_id')
                ->leftJoin('languages', 'languages.id', '=', 'translates.language_id')
                ->groupBy('languages.id')
                ->select('languages.*')
                ->get();
            $data = [];
            foreach ($langs as $index => $lang) {
                $langs[$index]->count_words = \DB::table('order_translate')
                    ->where('order_translate.order_id', $order->id)
                    ->leftJoin('translates', 'translates.id', '=', 'order_translate.translate_id')
                    ->where('translates.language_id', $lang->id)
                    ->leftJoin('blocks', 'translates.block_id', '=', 'blocks.id')
                    ->sum('blocks.count_words');
                $langs[$index]->count_blocks = \DB::table('order_translate')
                    ->where('order_translate.order_id', $order->id)
                    ->leftJoin('translates', 'translates.id', '=', 'order_translate.translate_id')
                    ->where('translates.language_id', $lang->id)
                    ->count();
                $data[] = $langs[$index];
            }
            $orders[$key]->langs = (object) $data;
        }

        $doneOrders = Order::where('status', 'done')
            ->where('site_id', $site->id)
            ->latest()
            ->get();
        foreach ($doneOrders as $key => $order) {
            $langs = \DB::table('order_translate')
                ->where('order_translate.order_id', $order->id)
                ->leftJoin('translates', 'translates.id', '=', 'order_translate.translate_id')
                ->leftJoin('languages', 'languages.id', '=', 'translates.language_id')
                ->groupBy('languages.id')
                ->select('languages.*')
                ->get();
            $data = [];
            foreach ($langs as $index => $lang) {
                $langs[$index]->count_words = \DB::table('order_translate')
                    ->where('order_translate.order_id', $order->id)
                    ->leftJoin('translates', 'translates.id', '=', 'order_translate.translate_id')
                    ->where('translates.language_id', $lang->id)
                    ->leftJoin('blocks', 'translates.block_id', '=', 'blocks.id')
                    ->sum('blocks.count_words');
                $langs[$index]->count_blocks = \DB::table('order_translate')
                    ->where('order_translate.order_id', $order->id)
                    ->leftJoin('translates', 'translates.id', '=', 'order_translate.translate_id')
                    ->where('translates.language_id', $lang->id)
                    ->count();
                $data[] = $langs[$index];
            }
            $doneOrders[$key]->langs = (object) $data;
        }
        return view('orders.index', compact('translates', 'site', 'orders', 'currentOrder', 'allWords', 'allPhrases', 'fullCost', 'order', 'doneOrders'));
    }

    /**
     * Прочекивание всех непереведенных фраз для выбранного языка
     * @param null $langId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function make($langId = null)
    {
        $site = $this->site;
        if (empty($site) || $site->user_id != $this->user->id) {
            return redirect(route('main.account.selectProject'));
        }
        if ($langId) {
            $lang = Language::find($langId);
            if (!$lang) {
                return redirect(route('main.account.selectProject'));
            }
            \DB::table('translates')->where('language_id', $lang->id)->where('site_id', $this->site->id)->where(function ($query) {
                $query->whereNull('type_translate_id')->orWhere('type_translate_id', '!=', 3);
            })->update(['is_ordered' => 1]);
        }
        return redirect()->route('main.billing.order');
    }

    /**
     * Отчекивание фраз от заказа для выбранного языка
     * @param $langId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delLang($langId)
    {
        $site = $this->site;
        if (empty($site) || $site->user_id != $this->user->id) {
            return redirect(route('main.account.selectProject'));
        }
        $lang = Language::find($langId);
        if (!$lang) {
            return redirect(route('main.account.selectProject'));
        }
        \DB::table('translates')->where('site_id', $this->site->id)->where('language_id', $langId)->update(['is_ordered' => 0]);
        return redirect()->back();
    }

    /**
     * Страница выбора способа оплаты и ввода купона
     * @param $orderID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function prepare($orderID)
    {
        $site = $this->site;
        if (empty($site) || $site->user_id != $this->user->id) {
            return redirect(route('main.account.selectProject'));
        }
        $order = Order::find($orderID);
        if (!$order || $order->user_id != $this->user->id) {
            return redirect()->back();
        }
        if ($order->status != 'new') {
            return redirect()->route('main.billing.order');
        }
        \DB::table('order_translate')->where('order_id', $order->id)->delete();
        foreach ($site->translates()->where('is_ordered', 1)->get() as $trans) {
            $order->translates()->attach($trans->id);
        }
        $translates = $this->getTranslatesToOrder($site);
        $allWords = $allPhrases = $fullCost = 0;
        foreach ($translates as $translate) {
            $allWords += $translate->count_words;
            $allPhrases += 1;
            $fullCost += ($translate->word_cost * $translate->count_words);
        }
        $order->original_sum = $fullCost;
        $order->save();
        $paymentTypes = PaymentType::lists('name', 'id')->toArray();
        return view('orders.prepare', compact('translates', 'allWords', 'allPhrases', 'fullCost', 'order', 'paymentTypes'));
    }
    
    public function store($orderID, Request $request)
    {
        $site = $this->site;
        if (empty($site) || $site->user_id != $this->user->id) {
            return redirect(route('main.account.selectProject'));
        }
        $order = Order::find($orderID);
        if (!$order || $order->user_id != $this->user->id) {
            return redirect()->back();
        }
        if ($order->status != 'new') {
            return redirect()->route('main.billing.order');
        }
        $paymentType = PaymentType::find($request->get('payment_type_id'));
        $couponId = null;
        if ($coupon = getCouponState($request->get('coupon'), $site->id)) {
            $couponId = $coupon->id;
            $order->coupon_id = $couponId;
        }
        $subtotal = getOrderSubTotal($order->original_sum, $request->get('coupon'), $request->get('site_id'));
        $order->payment_sum = $subtotal;
        $order->status = 'wait';
        $order->save();
        $payment = new Payment([
            'outer_id'          => $order->id,
            'relation'          => 'App\Order',
            'user_id'           => $this->user->id,
            'sum'               => $subtotal,
            'original_sum'      => $order->original_sum,
            'status'            => 'new',
            'coupon_id'         => $order->coupon_id,
            'payment_type_id'   => $paymentType->id,
        ]);
        $payment->save();
        if ($paymentType->slug == 'yandex.kassa') {
            \DB::table('translates')->where('site_id', $site->id)->update(['is_ordered' => 0]);
            return redirect()->route('yandex-kassa.form', [$payment->id, $this->user->id, intval($payment->cost)]);
        } elseif ($paymentType->slug == 'beznal') {
            $order->status = 'new';
            $order->save();
            return redirect()->route('main.billing.details-form', [$payment->id]);
        }
        return redirect()->back();
    }

    /**
     * Колекция отчеканных фраз к заказу
     * @param Site $site
     * @return array|static[]
     */
    private function getTranslatesToOrder(\App\Site $site)
    {
        $translates = \DB::table('site_language')
            ->join('translates', 'translates.language_id', '=', 'site_language.language_id')
            ->join('blocks', 'translates.block_id', '=', 'blocks.id')
            ->join('languages', 'site_language.language_id', '=' ,'languages.id')
            ->where('site_language.site_id', $site->id)
            ->where('site_language.enabled', 1)
            ->where('blocks.enabled', 1)
            ->where('translates.is_ordered', 1)
            ->where('translates.site_id', $site->id)
            ->select('blocks.count_words', 'translates.language_id', 'translates.id', 'languages.original_name', 'blocks.text', 'languages.word_cost', 'languages.icon_file as icon')
            ->get();
        return $translates;
    }

    /**
     * Расчет суммы к оплате
     * @param Request $request
     * @return int
     */
    public function subtotal(Request $request)
    {
        $order = Order::find($request->get('order_id'));
        $subtotal = $baseCost = $order->original_sum;
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
        if ($subtotal < 0) {
            $subtotal = 0;
        }
        $resp['html'] = (String) view('orders.subtotal', compact('subtotal', 'timeDiscount', 'timeDiscountSum', 'couponShow', 'baseCost', 'couponDiscount'));
        $resp['coupon'] = $couponMessage;
        return json_encode($resp, JSON_HEX_QUOT | JSON_HEX_TAG);
    }
}
