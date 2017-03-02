<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryPhrase extends Model
{
    protected $table = 'history_changes_phrases';
    protected $fillable = ['translate_id', 'text'];

    public function translate()
    {
        return $this->belongsTo('App\Translate');
    }
}
