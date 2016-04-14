<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Payment;
use Illuminate\Http\Request;
use App\Http\Requests;

class PaymentsController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs->add('admin/billing/payments', 'История платежей');
    }

    public function index()
    {
        $items = Payment::latest()->where('is_draft', 0)->paginate(20);
        return view('admin.payments.index', compact('items'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $payment = Payment::find($id);
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
        return redirect()->back()->with('messages', ['Платеж успешно проведен']);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function approve($id)
    {

    }
    
    public function cancel($id)
    {

    }

}
