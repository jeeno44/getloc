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
        $items = Payment::latest()->paginate(20);
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
