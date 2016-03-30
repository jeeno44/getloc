<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = ['user_id', 'plan_id', 'sum', 'status', 'relation', 'payment_type_id', 'outer_id', 'coupon_id', 'original_sum'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function type()
    {
        return $this->belongsTo('App\PaymentType');
    }

    public function subscription()
    {
        return $this->belongsTo('App\Subscription', 'outer_id')->where('relation', 'App\Subscription');
    }

    public function order()
    {
        return $this->belongsTo('App\Order', 'outer_id')->where('relation', 'order');
    }
}
