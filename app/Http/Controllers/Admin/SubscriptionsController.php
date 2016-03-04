<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Subscription;
use Illuminate\Http\Request;
use App\Http\Requests;

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
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $item = Subscription::find($id);
        $item->delete();
        return redirect()->back()->with('success', 'Удалено');
    }
}
