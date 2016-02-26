<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\WebForm;
use Illuminate\Http\Request;
use App\Http\Requests;


class FeedbackController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs->add('admin/feedback/call', 'Обратная связь');
    }

    public function call()
    {
        $items = WebForm::latest()->where('form_name', 'Сообщить о запуске')->paginate(20);
        return view('admin.feedback.call', compact('items'));
    }

    public function demo()
    {
        $items = WebForm::latest()->where('form_name', 'Демо доступ')->paginate(20);
        return view('admin.feedback.demo', compact('items'));
    }

    public function destroy($id)
    {
        $i = WebForm::find($id);
        $i->delete();
        return redirect()->back();
    }
}
