<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/account/projects';

    /*protected function authenticated(User $user)
    {
        if (\Auth::check()) {
            $user = \Auth::user();

            if ($user->hasRole('show_stat')) {
                return redirect(route('scan.main'));
            }
        }
    }*/

    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->route('login.form')
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //parent::__construct();
        $this->middleware('guest', ['except' => 'logout']);

        if (strpos(\URL::previous(), 'scan')) {
            $this->redirectTo = route('scan.main');
        } else {
            $this->redirectTo = route('main.account.selectProject');
        }
        if ($this->user) {
            \Log::info(var_dump($this->user));
        }
        \View::share('locale', \App::getLocale());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        if(!empty($data['role'])) {
            $role = \App\Role::find($data['role']);
            $user->assignRole($role);
        }
        return $user;
    }

    public function adminForm()
    {
        return view('admin.layouts.login');
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'name' => 'required', 'password' => 'required',
        ]);
        $throttles = $this->isUsingThrottlesLoginsTrait();
        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }
        $credentials = $request->only('name', 'password');
        if (\Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
            return redirect()->route('admin.dashboard');
        }
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }
        return redirect()->route('admin.login.form')
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                'name' => $this->getFailedLoginMessage(),
            ]);
    }

    public function getLogout()
    {
        if (strpos(\URL::previos(), 'scan')) {
            \Auth::guard($this->getGuard())->logout();
            \Session::remove('projectID');
            return redirect()->route('scan.main');
        }
        return $this->logout();
    }

    public function logout()
    {
        \Auth::guard($this->getGuard())->logout();
        \Session::remove('projectID');
        if (strpos(\URL::previous(), 'scan')) {
            return redirect()->route('scan.main');
        }
        return redirect('/');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if (\Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
            return redirect($this->redirectTo);
        }

        return $this->sendFailedLoginResponse($request);
    }
}
