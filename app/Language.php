<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = ['name', 'icon_file', 'short'];

    public $timestamps = false;
}
