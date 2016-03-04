<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'plans';

    protected $fillable = ['name', 'desc', 'cost', 'old_cost', 'period_name', 'period_value', 'count_words', 'count_languages', 'white_label', 'enabled'];

    public function subscriptions()
    {
        return $this->belongsTo('App\Subscription');
    }
}
