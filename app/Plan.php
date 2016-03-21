<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'plans';

    protected $fillable = ['name', 'desc', 'cost', 'old_cost', 'period_name', 'period_value', 'count_words', 'count_languages', 'white_label', 'enabled', 'required_coupon'];

    public function subscriptions()
    {
        return $this->belongsTo('App\Subscription');
    }
}
