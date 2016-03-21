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
        $options = \DB::table('options')->get();
        return view('admin.settings.index', compact('options'));
    }

    public function getStopWords()
    {
        $options = \DB::table('options')->get();
        $this->breadcrumbs->add('admin/settings', 'Стоп-лист');
        return view('admin.settings.stop', compact('options'));
    }

    public function postSettings(Request $request)
    {
        $this->validate($request, [
            'password'                  => 'min:6|confirmed',
            'password_confirmation'     => 'min:6',
        ]);
        if ($request->has('password')) {
            $user = \Auth::getUser();
            $user->password = bcrypt($request->get('password'));
            $user->save();
        }
        foreach ($this->options as $key => $val) {
            if ($request->has($key) && $val != $request->get($key)) {
                \DB::table('options')->where('key', $key)->update(['val' => $request->get($key)]);
            }
        }
        return redirect()->back()->with('messages', ['Сохранено']);
    }
}
