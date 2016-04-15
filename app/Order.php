<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'site_id', 'sum', 'status', 'original_sum', 'payment_sum', 'coupon_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function site()
    {
        return $this->belongsTo('App\Site');
    }

    public function translates()
    {
        return $this->belongsToMany('App\Translate', 'order_translate');
    }
}
