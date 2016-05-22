<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteFile extends Model
{
    protected $table = 'docs_sites';

    protected $fillable = ['site_id', 'link_text', 'ftype', 'doc_type', 'full_url'];

    public function site()
    {
        return $this->belongsTo('App\Site');
    }
}
