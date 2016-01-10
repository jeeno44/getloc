<?php

namespace App\Http\Controllers;

use App\Page;
use App\Site;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function getIndex()
    {
        $sites = Site::with('pages')->limit(30)->latest()->get();
        return view('welcome', compact('sites'));
    }
}
