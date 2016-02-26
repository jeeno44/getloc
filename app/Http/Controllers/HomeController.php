<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Site;
use App\User;
use App\WebForm;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('tracker')) {
            $user = User::where('partner_link', $request->get('tracker'))->first();
            if (!empty($user)) {
                $cookie = \Cookie::forever('tracker_id', $user->id);
                return redirect()->route('main')->withCookie($cookie);
            }
        }
        $sites = Site::count();
        return view('pages.main', compact('sites'));
    }

    public function feature()
    {
        return view('pages.feature');
    }

    /**
     * @param Request $request
     * return void
     */
    public function callMe(Request $request)
    {
        $data = $request->all();
        $data['form_name'] = 'Сообщить о запуске';
        \Mail::queue('emails.call-me', $data, function($message) use ($data) {
            $message->to($data['email'])->subject('Вы узнаете о запуске сервиса одним из первых!');
        });
        WebForm::create($data);
    }

    public function getDemo(Request $request)
    {
        header('Access-Control-Allow-Origin: *');
        $data = $request->all();
        if (empty($data['site'])) {
            return 'fail';
        }
        $user = User::where('email', $data['email'])->first();
        if (empty($user)) {
            $user = new User([
                'email'     => $data['email'],
                'name'      => $data['name'],
                'password'  => bcrypt('123456')
            ]);
            $user->save();
        }
        $data['form_name'] = 'Демо доступ';
        \Mail::queue('emails.get-demo', $data, function($message) use ($data) {
            $message->to($data['email'])->subject('Вы узнаете о запуске сервиса одним из первых!');
        });
        WebForm::create($data);
        sendApiQuery(route('api.add-site'), ['url' => $data['site'], 'user_id' => $user->id]);
        return route('scan.main');
    }
}
