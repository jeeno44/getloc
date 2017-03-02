<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImportHistory extends Model
{
    protected $fillable = ['site_id', 'file_name', 'file_path', 'from_language_id', 'to_language_id', 'count_blocks'];

    public function fromLanguage()
    {
        return $this->belongsTo(Language::class, 'from_language_id');
    }

    public function toLanguage()
    {
        return $this->belongsTo(Language::class, 'to_language_id');
    }
}
