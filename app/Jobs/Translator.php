<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Site;

class Translator extends Job implements ShouldQueue
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
        foreach ($this->site->translates()->where('text', '')->get() as $translate) {
            autoTranslate($translate, $this->site);
        }
        \Event::fire('site.changed', $this->site);
    }
}
