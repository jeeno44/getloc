<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

use App\Http\Requests;

class SettingsController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs->add('admin/settings', 'Настройки');
    }

    public function getSettings()
    {
        return view('admin.settings.index');
    }

    public function postSettings(Request $request)
    {
        $this->validate($request, [
            'password'                  => 'required|min:6|confirmed',
            'password_confirmation'     => 'required|min:6',
        ]);
        $user = \Auth::getUser();
        $user->password = bcrypt($request->get('password'));
        $user->save();
        return redirect('admin/settings')->with('messages', ['Сохранено']);
    }
}
