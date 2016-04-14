<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebForm extends Model
{
    protected $table = 'webforms';

    protected $fillable = ['name', 'email', 'phone', 'site', 'form_name', 'languages', 'text'];
}
