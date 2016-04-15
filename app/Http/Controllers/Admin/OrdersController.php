<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Requests;

class OrdersController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs->add('admin/billing/orders', 'Заказы');
    }

    public function index()
    {
        $items = Order::latest()->where('status', '!=', 'new')->paginate(20);
        return view('admin.orders.index', compact('items'));
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
        //
    }
}
