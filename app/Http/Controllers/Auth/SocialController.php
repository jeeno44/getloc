<?php

namespace App\Http\Controllers\Auth;

use App\SocialAccount;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Socialite;

class SocialController extends Controller
{
    public function linkToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        $user = Socialite::driver('google')->user();
        if ($this->auth($user, 'google')) {
            return redirect()->to('/');
        } else {
            return redirect()->route('login.form')->withErrors(['Неудалось войти через Google']);
        }
    }

    public function linkToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookCallback()
    {
        $user = Socialite::driver('facebook')->user();
        if ($this->auth($user, 'facebook')) {
            return redirect()->to('/');
        } else {
            return redirect()->route('login.form')->withErrors(['Неудалось войти через Facebook']);
        }
    }

    public function linkToTwitter()
    {
        return Socialite::driver('twitter')->redirect();
    }

    public function twitterCallback()
    {
        $user = Socialite::driver('twitter')->user();
        $account = SocialAccount::where('social_id', $user->getId())->where('social_driver', 'twitter')->first();
        if (!empty($account)) {
            \Auth::login($account->user);
            return redirect()->to('/');
        }
        \Session::set('user', $user);
        return redirect()->route('social.email');
    }

    public function getEmail()
    {
        return view('auth.social.register');
    }

    public function postEmail(Request $request)
    {
        $socialUser = \Session::get('user');
        $this->validate($request, [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
        $user = new User([
            'name'      => $socialUser->getName(),
            'email'     => $request->get('email'),
            'password'  => bcrypt($request->get('password')),
        ]);
        $user->save();
        $account = new SocialAccount([
            'social_driver'     => 'twitter',
            'social_id'         => $socialUser->getId(),
            'user_id'           => $user->id,
        ]);
        $account->save();
        \Auth::login($user);
        \Session::remove('user');
        return redirect()->to('/');
    }

    private function auth($socialAccount, $driver)
    {
        $account = SocialAccount::where('social_id', $socialAccount->getId())->where('social_driver', $driver)->first();
        if (!empty($account)) {
            \Auth::login($account->user);
            return true;
        }
        return $this->newSocialAccount($socialAccount, $driver);
    }

    private function newSocialAccount($socialAccount, $driver)
    {
        $user = User::where('email', $socialAccount->getEmail())->first();
        if (empty($user)) {
            $user = new User([
                'name'      => $socialAccount->getName(),
                'email'     => $socialAccount->getEmail(),
                'password'  => bcrypt(str_random(6)),
            ]);
            $user->save();
        }
        $account = new SocialAccount([
            'social_driver'     => $driver,
            'social_id'         => $socialAccount->getId(),
            'user_id'           => $user->id,
        ]);
        $account->save();
        \Auth::login($user);
        return true;
    }
}
