<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Translate extends Model
{
    protected $fillable = ['block_id', 'language_id', 'text', 'type_translate_id', 'count_words'];

    public function language()
    {
        return $this->belongsTo('App\Language');
    }

    public function block()
    {
        return $this->belongsTo('App\Block');
    }

    public function type()
    {
        return $this->belongsTo('App\TypeTranslate', 'type_translate_id');
    }
}
