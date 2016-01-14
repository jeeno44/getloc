<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = ['name', 'url', 'count_words', 'count_symbols', 'count_blocks', 'user_id', 'secret', 'language_id'];

    public function pages()
    {
        return $this->hasMany('App\Page');
    }

    public function blocks()
    {
        return $this->hasMany('App\Block');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function language()
    {
        return $this->belongsTo('App\Language');
    }

    public function languages()
    {
        return $this->belongsToMany('App\Language', 'site_language');
    }

    public function hasLanguage($lang)
    {
        return in_array($lang, $this->languages()->lists('id', 'id')->toArray());
    }
}
