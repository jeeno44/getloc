<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    protected $fillable = ['payment_id', 'contact_name', 'contact_phone', 'contact_email', 'company_post_address', 'company_law_address',
        'company_name', 'company_bank_account', 'company_bank_bik', 'company_ogrn', 'company_principal_post', 'company_principal_name', 'company_file'];

    public function payment()
    {
        return $this->belongsTo('App\Payment');
    }
}