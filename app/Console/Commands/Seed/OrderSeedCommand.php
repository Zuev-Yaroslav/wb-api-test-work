<?php

namespace App\Console\Commands\Seed;

use App\Exceptions\CheckDateException;
use App\HttpClients\OrderHttpClient;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class OrderSeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:seed {from-date?}';

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
        CheckDateException::checkFormatDate($this->argument('from-date'));
        $now = Carbon::now()->format('Y-m-d');
        $orderHttpClient = OrderHttpClient::make();
        $orderHttpClient->auth(config('wbapi.auth_key'));

        $queryParams = [
            'dateFrom' => $this->argument('from-date') ?? '2000-01-01',
            'dateTo' => $now,
            'limit' => 500,
        ];

        $orderHttpClient->saveAllToDb($queryParams, Order::class);

    }
}
