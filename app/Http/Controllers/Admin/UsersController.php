<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;


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
        $startCurrentMonth = new Carbon('first day of this month');
        $startCurrentMonth->toDateTimeString();
        $startPrevMonth = new Carbon('first day of previous month');
        $startPrevMonth->toDateTimeString();
        $partnerRole = Role::where('name', 'partner')->first();
        if (!empty($partnerRole)) {
            $userWithRoles = \DB::table('role_user')->where('role_id', $partnerRole->id)->pluck('user_id', 'user_id');
        } else {
            $userWithRoles = \DB::table('role_user')->pluck('user_id', 'user_id');
        }
        $items = User::latest()->whereNotIn('id', $userWithRoles)->paginate(20);
        foreach ($items as $item) {
            $currentMonths = \DB::table('sites')->where('count_words', '>', 0)->where('user_id', $item->id)->where('created_at', '>', $startCurrentMonth)->count();
            $prevMonths = \DB::table('sites')->where('count_words', '>', 0)->where('user_id', $item->id)->count();
            $item->prevMonths = $prevMonths;
            $item->currentMonths = $currentMonths;
        }
        return view('admin.users.index', compact('items'));
    }

    public function partners()
    {
        \Session::set('usersPrevUrl', \URL::full());
        $rolePartner = Role::where('name', 'partner')->first();
        $items = $rolePartner->users()->latest()->paginate(20);
        return view('admin.users.partners', compact('items'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
        $data = $request->all();
        $data['name'] = $data['email'];
        $data['password'] = bcrypt($data['password']);
        $user = new User($data);
        $user->save();
        $roles = $request->get('roles');
        if (!empty($roles)) {
            foreach ($roles as $role) {
                $user->roles()->attach($role);
            }
        }
        $previousUrl = \Session::get('usersPrevUrl', 'admin/users');
        return redirect($previousUrl)->with('messages', ['Сохранено']);
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
        $this->validate($request, [
            'password'                  => 'min:6|confirmed',
        ]);
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

    public function show($id)
    {
        $user = User::findOrfail($id);
        return view('admin.users.show', compact('user'));
    }
}
