<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'subscriptions';

    protected $fillable = ['user_id', 'plan_id', 'site_id', 'ends_at', 'last_id', 'count_words', 'count_languages', 'white_label', 'month_cost', 'deposit'];

    public function plan()
    {
        return $this->belongsTo('App\Plan');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function site()
    {
        return $this->belongsTo('App\Site');
    }
}
