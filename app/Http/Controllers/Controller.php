<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $options;
    protected $user;

    public function __construct()
    {
        \View::share('route', \Route::getCurrentRoute()->getName());
        \View::share('locale', \App::getLocale());
        $this->options = \DB::table('options')->pluck('val', 'key');
        \View::share('options', $this->options);
        $tracker_id = \Cookie::get('tracker_id');
        if (\Auth::check() && !empty($tracker_id)) {
            if (empty(\Auth::user()->partner_id)) {
                \Auth::user()->partner_id = $tracker_id;
                \Auth::user()->save();
            }
        }
        $this->user  = \Auth::user();
    }
}
