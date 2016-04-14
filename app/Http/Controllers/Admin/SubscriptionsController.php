<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Site;
use App\Subscription;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Plan;

class SubscriptionsController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs->add('admin/billing/subscriptions', 'Приобретенные подписки');
    }

    public function index()
    {
        $items = Subscription::latest()->paginate(20);
        return view('admin.subscriptions.index', compact('items'));
    }

    public function create()
    {
        $objPlans = Plan::all();
        $plans = ['' => 'Не выбран'];
        foreach ($objPlans as $p) {
            $plans[$p->id] = $p->name.' - '.$p->cost.' '.trans('phrases.rubles');
        }
        $objSites = Site::with('subscription')->get();
        $sites = ['' => 'Не выбран'];
        foreach ($objSites as $site) {
            if (!$site->subscription) {
                $sites[$site->id] = $site->url;
            }
        }
        return view('admin.subscriptions.create', compact('plans', 'sites'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $site = Site::find($data['site_id']);
        if ($site) {
            $data['user_id'] = $site->user_id;
            $subscription = new Subscription($data);
            $subscription->save();
            \Event::fire('blocks.changed', $subscription);
        }
        return redirect('admin/billing/subscriptions')->with('success', 'Сохранено');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $objPlans = Plan::all();
        $plans = ['' => 'Не выбран'];
        foreach ($objPlans as $p) {
            $plans[$p->id] = $p->name.' - '.$p->cost.' '.trans('phrases.rubles');
        }
        $subscription = Subscription::find($id);
        return view('admin.subscriptions.edit', compact('plans', 'sites', 'subscription'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $subscription = Subscription::find($id);
        $subscription->update($data);
        \Event::fire('blocks.changed', $subscription);
        return redirect('admin/billing/subscriptions')->with('success', 'Сохранено');
    }
    
    public function planData($id)
    {
        $plan = Plan::find($id);
        if ($plan) {
            return json_encode([
                'cost'              => (int)$plan->cost,
                'count_words'       => $plan->count_words,
                'count_languages'   => $plan->count_languages,
            ]);
        }
        return json_encode([
            'cost'              => 0,
            'count_words'       => 0,
            'count_languages'   => 0,
        ]);
    }

    public function destroy($id)
    {
        $item = Subscription::find($id);
        $item->delete();
        return redirect()->back()->with('success', 'Удалено');
    }
}
