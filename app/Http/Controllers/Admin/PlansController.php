<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Plan;
use Illuminate\Http\Request;
use App\Http\Requests;


class PlansController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs->add('admin/billing/plans', 'Тарифные планы');
    }

    public function index()
    {
        $items = Plan::paginate(20);
        return view('admin.plans.index', compact('items'));
    }

    public function create()
    {
        $this->breadcrumbs->add('admin/billing/plans/create', 'Новый тарифный план');
        return view('admin.plans.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if (empty($data['white_label'])) {
            $data['white_label'] = false;
        }
        $item = new Plan($data);
        $item->save();
        return redirect('admin/billing/plans')->with('success', 'Сохранено');
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $item = Plan::find($id);
        return view('admin.plans.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        if (empty($data['white_label'])) {
            $data['white_label'] = false;
        }
        $item = Plan::find($id);
        $item->update($data);
        return redirect('admin/billing/plans')->with('success', 'Сохранено');
    }

    public function destroy($id)
    {
        $item = Plan::find($id);
        $item->delete();
        return redirect()->back()->with('success', 'Удалено');
    }
}
