<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;


class UsersController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs->add('admin/users', 'Пользователи');
    }

    public function index()
    {
        \Session::set('usersPrevUrl', \URL::full());
        $userWithRoles = \DB::table('role_user')->pluck('user_id', 'user_id');
        $items = User::latest()->whereNotIn('id', $userWithRoles)->paginate(20);
        return view('admin.users.index', compact('items'));
    }

    public function partners()
    {
        \Session::set('usersPrevUrl', \URL::full());
        $rolePartner = Role::where('name', 'partner')->first();
        $items = $rolePartner->users()->latest()->paginate(20);
        return view('admin.users.partners', compact('items'));
    }

    public function edit($id)
    {
        $user = User::findOrfail($id);
        if ($user->hasRole('partner')) {
            $this->breadcrumbs->add('admin/users', 'Редактирование партнера');
        } else {
            $this->breadcrumbs->add('admin/users', 'Редактирование пользователя');
        }
        return view('admin.users.edit', compact('user'));
    }
	
    public function update(Request $request, $id)
    {
        $user = User::findOrfail($id);
        \DB::table('role_user')->where('user_id', $user->id)->delete();
        $roles = $request->get('roles');
        if (!empty($roles)) {
            foreach ($roles as $role) {
                $user->roles()->attach($role);
            }
        }
        $data = $request->all();
        if (!empty($data['roles'])) {
            unset($data['roles']);
        }
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }
        $user->update($data);
        $previousUrl = \Session::get('usersPrevUrl', 'admin/users');
        return redirect($previousUrl)->with('messages', ['Сохранено']);
    }

    public function destroy($id)
    {
        $i = User::find($id);
        $i->delete();
        return redirect()->back()->with('messages', ['Удалено']);
    }
}
