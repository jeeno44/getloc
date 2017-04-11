<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocTranslate extends Model
{
    protected $fillable = ['doc_id', 'language_id', 'full_url', 'site_id', 'ftype'];
}
