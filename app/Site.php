<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Site extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['name', 'url', 'count_words', 'count_symbols', 'count_blocks', 'user_id', 'secret', 'language_id', 'enabled', 'demo'];

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

    public function translates()
    {
        return $this->hasMany('App\Translate');
    }

    public function enabledLanguages()
    {
        return $this->belongsToMany('App\Language', 'site_language')->where('enabled', 1);
    }

    public function hasLanguage($lang)
    {
        return in_array($lang, $this->languages()->lists('id', 'id')->toArray());
    }

    public function hasEnabledLanguage($lang)
    {
        return in_array($lang, $this->enabledLanguages()->lists('id', 'id')->toArray());
    }

    public function getSettings()
    {
        $settings = \DB::table('sites_settings')->where('site_id', $this->id)->first();
        return $settings;
    }
    
    public function subscription()
    {
        return $this->hasOne('App\Subscription');
    }

    public function images()
    {
        return $this->belongsTo('App\SiteFile')->where('ftype', 'image');
    }

    public function docs()
    {
        return $this->belongsTo('App\SiteFile')->where('ftype', 'doc');
    }
}
