<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Language;
use Illuminate\Http\Request;
use App\Http\Requests;


class LanguagesController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs->add('admin/settings/languages', 'Языки');
    }

    public function index(Request $request)
    {
        if ($request->has('page')) {
            \Session::set('prev_page', 'admin/settings/languages?page='.$request->get('page'));
        }
        $items = Language::paginate(20);
        return view('admin.languages.index', compact('items'));
    }

    public function create()
    {
        $this->breadcrumbs->add('admin/settings/languages/create', 'Новый язык');
        return view('admin.languages.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $item = new Language($data);
        $item->save();
        return redirect('admin/settings/languages')->with('success', 'Сохранено');
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $item = Language::find($id);
        $this->breadcrumbs->add('admin/settings/languages/create', 'Редактировать язык');
        return view('admin.languages.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $item = Language::find($id);
        $item->update($data);
        return redirect(\Session::get('prev_page', 'admin/settings/languages'))->with('success', 'Сохранено');
    }

    public function destroy($id)
    {
        $item = Language::find($id);
        $item->delete();
        return redirect()->back()->with('success', 'Удалено');
    }
}
