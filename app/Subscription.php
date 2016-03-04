<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'subscriptions';

    protected $fillable = ['user_id', 'plan_id', 'ends_at', 'last_id', 'count_words'];

    public function plan()
    {
        return $this->belongsTo('App\Plan');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
