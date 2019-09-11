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
//        $user = User::where('email', $data['email'])->first();
//        if (empty($user)) {
//            $user = new User([
//                'email'     => $data['email'],
//                'name'      => $data['name'],
//                'password'  => bcrypt('123456')
//            ]);
//            $user->save();
//        }
        $data['form_name'] = 'Демо доступ';
//        \Mail::queue('emails.get-demo', $data, function($message) use ($data) {
//            $message->to($data['email'])->subject('Вы узнаете о запуске сервиса одним из первых!');
//        });
        WebForm::create($data);
        sendApiQuery(route('api.add-site'), ['url' => $data['site'], 'user_id' => $data['uid'], 'languages' => '']);
        return route('scan.main');
    }
    public function addSiteUnregistered(Request $request) {
        header('Access-Control-Allow-Origin: *');
        $data = $request->all();
        $user = User::where('email', $data['email'])->first();
        $tmppass = str_random(8);
        $data['site'] = $data['url'];
        $data['form_name'] = 'Демо доступ';
        if (empty($user)) {
            $user = new User([
                'email'     => $data['email'],
                'name'      => $data['name'],
                'phone'     => $data['phone'],
                'password'  => bcrypt($tmppass),
                'activated' => 1
            ]);
            $user->save();
            $data['uid'] = $user->id;
            $data['user'] = $user;
            $data['pass'] = $tmppass;
            \Mail::queue('emails.new-user', $data, function($message) use ($data) {
                $message->to($data['email'])->subject('Спасибо за регистрацию!');
            });
        } else {
            $data['uid'] = $user->id;
            \Mail::queue('emails.new-site', $data, function($message) use ($data) {
                $message->to($data['email'])->subject('Сайт добавлен!');
            });
        }

        sendApiQuery(route('api.add-unreg-site'), ['url' => $data['url'], 'user_id' => $data['uid'], 'languages' => 1]);
        return route('scan.main');
    }

    public function sendFeedback(Request $request) {
        $data = $request->all();
//        dd($data);
        \Mail::queue('emails.feedback', $data, function($message) use ($data) {
            $message->to('a@get-loc.ru')->cc('v@get-loc.ru')->subject('Вопрос с сайта.');
        });

    }
}
