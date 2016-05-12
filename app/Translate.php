<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Translate extends Model
{
    protected $fillable = ['block_id', 'language_id', 'text', 'type_translate_id', 'count_words', 'site_id', 'archive'];

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

    public function site()
    {
        return $this->belongsTo('App\Site');
    }

    public function historyPhrase()
    {
        return $this->hasMany('App\HistoryPhrase');
    }
}
