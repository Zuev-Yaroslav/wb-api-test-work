<?php

namespace App\Console\Commands\Database;

use App\Models\ApiToken;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class GetFreshOrdersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:get-fresh-orders {page} {token}';
    // php artisan database:get-fresh-orders {page} {token}

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $apiToken = ApiToken::where('token', $this->argument('token'))->first();
        $orders = $apiToken->orders()->freshFilter()->paginate(perPage: 5, page: $this->argument('page'));
        dump($orders->toArray());
    }
}
