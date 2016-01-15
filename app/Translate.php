<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Translate extends Model
{
    protected $fillable = ['block_id', 'language_id', 'text'];

    public function language()
    {
        return $this->belongsTo('App\language');
    }

    public function block()
    {
        return $this->belongsTo('App\Block');
    }
}
