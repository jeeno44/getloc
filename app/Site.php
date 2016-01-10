<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = ['name', 'url', 'count_words', 'count_symbols', 'count_blocks', 'user_id'];

    public function pages()
    {
        return $this->hasMany('App\Page');
    }
}
