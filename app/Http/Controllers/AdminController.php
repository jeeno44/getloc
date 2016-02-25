<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    protected $breadcrumbs;

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs = \App\Breadcrumbs::getInstance();
        $this->breadcrumbs->add('admin', '<i class="fa fa-home"></i> Главная');
    }
}
