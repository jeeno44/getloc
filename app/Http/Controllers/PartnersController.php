<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use App\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PartnersController extends Controller
{
    public function index()
    {
        return view('partners.index');
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255|unique:users',
        ]);
        $data = $request->all();
        $password = str_random(8);
        $data['partner_link'] = str_random(10);
        $data['v_password'] = $password;
        $data['password'] = bcrypt($password);
        $user = new User($data);
        $user->save();
        $rolePart = Role::where('name', 'partner')->first();
        if (!empty($rolePart)) {
            $user->roles()->attach($rolePart->id);
        }
        \Mail::queue('emails.new-partner', $data, function($message) use ($data) {
            $message->to($data['email'])->subject('Регистрация в парнерской программе!');
        });
        \Mail::queue('emails.new-partner-to-admin', $data, function($message) use ($data) {
            $message->to('a@lezhnin.me')->subject('Новый партнер!');
        });
        return redirect()->back()->with('status', 'success');
    }
}
