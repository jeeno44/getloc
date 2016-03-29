<?php

namespace App\Console\Commands;

use App\Subscription;
use Illuminate\Console\Command;

class GetMyMoney extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get-my-money';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Почасовое списывание денег с депозитов пользователей';

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
        $subscriptions = Subscription::where('deposit', '>', 0.00)->get();
        foreach ($subscriptions as $subscription) {
            $hourlySum = $subscription->month_cost / 30 / 24;
            if (($subscription->deposit - $hourlySum) <= 0.00) {
                $subscription->update(['deposit' =>  0.00]);
            } else {
                $subscription->update(['deposit' =>  $subscription->deposit - $hourlySum]);
            }
        }
    }
}
