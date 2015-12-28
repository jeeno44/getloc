<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $fillable = ['site_id', 'text', 'count_words', 'count_symbols', 'type'];

    public function site()
    {
        return $this->belongsTo('App\Site');
    }

    public function pages()
    {
        return $this->belongsToMany('App\Page', 'page_block');
    }
}
