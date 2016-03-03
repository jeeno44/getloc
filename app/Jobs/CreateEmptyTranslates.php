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
        foreach ($this->site->languages as $language) {
            foreach ($this->site->blocks as $block) {
                Translate::create([
                    'site_id'       => $this->site->id,
                    'block_id'      => $block->id,
                    'language_id'   => $language->id,
                    'count_words'   => $block->count_words,
                ]);
            }
        }
        \Event::fire('site.changed', $this->site);
    }
}
