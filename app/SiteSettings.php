<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteSettings extends Model
{
    protected $table = ['sites_settings'];

    protected $fillable = ['site_id', 'auto_publishing', 'auto_translate'];
    
    public function site()
    {
        return $this->belongsTo('App\Site');
    }
}
