<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Site;
use App\Translate;

class CreateEmptyTranslates extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $site;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Site $site)
    {
        $this->site = $site;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $settings   = $this->site->getSettings();
        $autoPub    = isset($settings->auto_publishing) ? $settings->auto_publishing : 1;
        $autoTrans  = isset($settings->auto_translate) ? $settings->auto_translate : 1;
        foreach ($this->site->languages as $language) {
            foreach ($this->site->blocks as $block) {
                $oldTrans = Translate::where('site_id', $this->site->id)
                    ->where('block_id', $block->id)
                    ->where('language_id', $language->id)
                    ->first();
                if (empty($oldTrans)) {
                    $trans = new Translate([
                        'site_id'       => $this->site->id,
                        'block_id'      => $block->id,
                        'language_id'   => $language->id,
                        'count_words'   => $block->count_words,
                        'enabled'       => $autoPub,
                    ]);
                    $trans->save();
                    if ($autoTrans == 1) {
                        autoTranslate($trans, $this->site);
                    }
                } else {
                    $oldTrans->update([
                        'count_words'   => $block->count_words,
                    ]);
                }
            }
        }
        if ($autoTrans == 1) {
            \Queue::push(new \App\Jobs\Translator($this->site));
        } else {
            \Event::fire('site.changed', $this->site);
        }

    }
}
