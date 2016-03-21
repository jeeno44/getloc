<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['user_id', 'site_id', 'code', 'discount', 'is_percent', 'type', 'ends_at', 'activated_at', 'enabled'];

    public function site()
    {
        return $this->belongsTo('App\Site');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
