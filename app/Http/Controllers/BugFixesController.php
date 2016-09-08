<?php

namespace App\Http\Controllers;

use App\Site;
use App\Translate;
use Illuminate\Http\Request;

use App\Http\Requests;

class BugFixesController extends Controller
{
    public function fixMe()
    {
        set_time_limit(0);
        $sites = Site::all();
        foreach ($sites as $site) {
            if ($site->languages()->count() == 0) {
                $site->languages()->attach(1);
                foreach ($site->blocks as $block) {
                    Translate::create([
                        'block_id'  => $block->id,
                        'language_id'   => 1,
                        'text'      => '',
                        'count_words'   => $block->count_words,
                        'type_translate_id' => null,
                        'site_id'   => $site->id,
                        'enabled'   => 1,
                        'archive'   => 0,
                        'is_ordered'    => 0,
                    ]);
                }
            }
        }
    }
}
