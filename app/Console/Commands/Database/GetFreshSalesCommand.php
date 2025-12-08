<?php

namespace App\Console\Commands\Database;

use App\Models\ApiToken;
use App\Models\Order;
use App\Models\Sale;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class GetFreshSalesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:get-fresh-sales {page} {token}';
    // php artisan database:get-fresh-sales {page} {token}

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
        $sales = $apiToken->sales()->freshFilter()->paginate(perPage: 5, page: $this->argument('page'));
        dump($sales->toArray());
    }
}
