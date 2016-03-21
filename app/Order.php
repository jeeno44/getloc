<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'site_id', 'sum', 'status'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function site()
    {
        return $this->belongsTo('App\Site');
    }
}
