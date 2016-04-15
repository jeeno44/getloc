<?php

namespace App\Http\Controllers;

use App\Language;
use App\Order;
use App\Site;
use Illuminate\Http\Request;
use App\PaymentType;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    private $sites = [];

    public function __construct()
    {
        parent::__construct();
        $this->sites = Site::where('user_id', $this->user->id)->orderBy('url')->get();
        \View::share('sites', $this->sites);
    }

    public function index($id = null)
    {
        $site = Site::find(\Session::get('projectID'));
        if (!$site) {
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
        $translates = \DB::table('site_language')
            ->join('translates', 'translates.language_id', '=', 'site_language.language_id')
            ->join('blocks', 'translates.block_id', '=', 'blocks.id')
            ->join('languages', 'site_language.language_id', '=' ,'languages.id')
            ->where('site_language.site_id', $site->id)
            ->where('site_language.enabled', 1)
            ->where('blocks.enabled', 1)
            ->where('translates.is_ordered', 1)
            ->select('blocks.count_words', 'translates.language_id', 'translates.id', 'languages.original_name', 'blocks.text')
            ->get();
        $currentOrder = [];
        $allWords = $allPhrases = $fullCost = 0;
        foreach ($translates as $translate) {
            if (!empty($currentOrder[$translate->original_name])) {
                $currentOrder[$translate->original_name]['count_words'] += $translate->count_words;
                $currentOrder[$translate->original_name]['count_phrases'] += 1;
                $currentOrder[$translate->original_name]['cost'] += ($this->options['word_cost'] * $translate->count_words);
            } else {
                $currentOrder[$translate->original_name]['count_words'] = $translate->count_words;
                $currentOrder[$translate->original_name]['count_phrases'] = 1;
                $currentOrder[$translate->original_name]['cost'] = ($this->options['word_cost'] * $translate->count_words);
            }
            $currentOrder[$translate->original_name]['texts'][] = $translate->text;
            $allWords += $translate->count_words;
            $allPhrases += 1;
            $fullCost += ($this->options['word_cost'] * $translate->count_words);
        }
        $orders = Order::where('status', '!=', 'new')->where('site_id', $site->id)->latest()->get();
        return view('orders.index', compact('translates', 'site', 'orders', 'currentOrder', 'allWords', 'allPhrases', 'fullCOst'));
    }

    public function make($langId = null)
    {
        if ($langId) {
            $lang = Language::find($langId);
            $site = Site::find(\Session::get('projectID'));
            if (!$site || !$lang) {
                return redirect(route('main.account.selectProject'));
            }
            \DB::table('translates')->where('language_id', $lang->id)->where('site_id', $site->id)->where(function ($query) {
                $query->whereNull('type_translate_id');
            })->update(['is_ordered' => 1]);
        }
        
        return redirect()->route('main.billing.order');
    }
}
