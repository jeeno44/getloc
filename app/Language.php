<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = ['name', 'icon_file', 'short', 'original_name', 'word_cost'];

    public $timestamps = false;
}
