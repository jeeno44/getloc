<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['site_id', 'url', 'visited', 'collected', 'code', 'level'];

    public function site()
    {
        return $this->belongsTo('App\Site');
    }

    public function blocks()
    {
        return $this->belongsToMany('App\Block', 'page_block');
    }

    public function hasBlock($id)
    {
        return in_array($id, $this->blocks()->lists('id')->toArray());
    }
}
