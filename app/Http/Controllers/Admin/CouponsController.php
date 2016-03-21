<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Coupon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\CouponRequest;


class CouponsController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs->add('admin/billing/coupons', 'Купоны');
    }

    public function index()
    {
        $items = Coupon::paginate(20);
        return view('admin.coupons.index', compact('items'));
    }

    public function create()
    {
        $this->breadcrumbs->add('admin/billing/coupons/create', 'Новый купон');
        return view('admin.coupons.create');
    }

    public function store(CouponRequest $request)
    {
        $data = $request->all();
        $item = new Coupon($data);
        $item->save();
        return redirect('admin/billing/coupons')->with('success', 'Сохранено');
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $item = Coupon::find($id);
        $this->breadcrumbs->add('admin/billing/coupons/create', 'Редактировать купон');
        return view('admin.coupons.edit', compact('item'));
    }

    public function update(CouponRequest $request, $id)
    {
        $data = $request->all();
        $item = Coupon::find($id);
        $item->update($data);
        return redirect('admin/billing/coupons')->with('success', 'Сохранено');
    }

    public function destroy($id)
    {
        $item = Coupon::find($id);
        $item->delete();
        return redirect()->back()->with('success', 'Удалено');
    }
}
