<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Site;

class PersonalController extends Controller
{
    private $sites = [];

    public function __construct()
    {
        parent::__construct();
        $this->sites = Site::where('user_id', $this->user->id)->orderBy('url')->get();
        \View::share('sites', $this->sites);
    }

    public function index()
    {
        return view('personal.index');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users,email,'.\Auth::user()->id,
        ]);
        $data = $request->all();
        if ($request->get('password')) {
            $this->validate($request, [
                'password' => 'min:6|confirmed',
            ]);
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }
        \Auth::user()->update($data);
        if (strpos(\URL::previous(), 'scan')) {
            return redirect()->route('scan.account.personal')->with('msg', ['class' => 'info-massages__item_detected', 'text' => 'Личные данные сохранены']);
        }
        return redirect()->back()->with('msg', ['class' => 'info-massages__item_detected', 'text' => 'Личные данные сохранены']);
    }
}
