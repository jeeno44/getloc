<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
     protected $fillable = ['site_id', 'location', 'titles', 'theme', 'background', 'background_active', 'color', 'color_active'];
}
