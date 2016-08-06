<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Role;
use App\User;

class ScanUsersController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs->add('/users', 'Пользователи');
    }

    public function index()
    {
        \Session::set('usersPrevUrl', \URL::full());
        $userWithRoles = \DB::table('role_user')->where('role_id', 3)->pluck('user_id', 'user_id');
        $items = User::latest()->whereIn('id', $userWithRoles)->paginate(20);
        return view('scan.users.index', compact('items'));
    }

    public function edit($id)
    {
        $user = User::findOrfail($id);
        $this->breadcrumbs->add('admin/users', 'Редактирование контрагента');
        $detail = \App\UserDetail::where('user_id', $this->user->id)->first();
        if (!$detail) {
            $data['user_id'] = $this->user->id;
            $detail = new \App\UserDetail($data);
        }
        return view('scan.users.edit', compact('user', 'detail'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrfail($id);
        $data = $request->all();
        if (empty($data['is_contragent'])) {
            $data['is_contragent'] = false;
            //dd($data['is_contragent']);
        }
        $user->update($data);
        $detail = \App\UserDetail::where('user_id', $this->user->id)->first();
        if (!$detail) {
            $data['user_id'] = $this->user->id;
            $detail = new \App\UserDetail($data);
            $detail->save();
        } else {
            $detail->update($data);
        }
        $previousUrl = \Session::get('usersPrevUrl', '/users');
        return redirect($previousUrl)->with('messages', ['Сохранено']);
    }

    public function destroy($id)
    {
        $i = User::find($id);
        $i->delete();
        return redirect()->back()->with('messages', ['Удалено']);
    }
}
