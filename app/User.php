<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'visibility_name', 'phone', 'site', 'company', 'partner_link', 'partner_id',
        'partner_income', 'max_sites', 'payment_type', 'is_contragent', 'activation_code', 'activated'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'role_user');
    }

    public function hasRole($check)
    {
        return in_array($check, array_pluck($this->roles->toArray(), 'name'));
    }

    public function assignRole($role) {
        $this->roles()->attach($role);
    }

    public function sites() {
        return $this->hasMany('App\Site');
    }

    public function subscription()
    {
        return $this->hasOne('App\Subscription');
    }
}
