<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\UserDetail;
use App\Site;

class AnalyticsController extends Controller
{
    private $sites = array();

    public function __construct()
    {
        parent::__construct();
        $this->sites = Site::where('user_id', $this->user->id)->orderBy('url')->get(); //TODO: Команды
        \View::share('sites', $this->sites);
    }

    public function contragent()
    {
        $detail = UserDetail::where('user_id', $this->user->id)->first();
        if (!$detail) {
            $detail = new UserDetail();
        }
        return view('scan.details-form', compact('detail'));
    }

    public function detailsStore(Request $request)
    {
        $data = $request->all();
        $detail = UserDetail::where('user_id', $this->user->id)->first();
        if (!$detail) {
            $data['user_id'] = $this->user->id;
            $detail = new UserDetail($data);
        }
        $detail->fill($data);
        $detail->save();
        \Mail::send('emails.details-store', ['detail' => $detail], function ($m) {
            $m->to(['vchevela@gmail.com', 'a@lezhnin.me'])->subject('Изменены данные контрагента!');
        });
        return redirect()->back()->with(['status' => 'Сохранено']);
    }
}
