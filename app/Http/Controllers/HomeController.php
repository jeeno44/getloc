<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Site;
use App\User;
use App\WebForm;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sites = Site::count();
        return view('index.pages.main', compact('sites'));
    }

    public function futures()
    {
        return view('index.pages.futures');
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
    }
}
