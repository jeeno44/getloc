<?php

namespace App\Console\Commands;

use Redis;
use Illuminate\Console\Command;

class SpiderListener extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spider:listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listen Python spider messages';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Redis::psubscribe(['spider_send'], function($message) {
            echo $message;
        });
    }
}
