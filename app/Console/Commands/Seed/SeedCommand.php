<?php

namespace App\Console\Commands\Seed;

use Illuminate\Console\Command;

class SeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed';

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
        $this->call(IncomeSeedCommand::class);
        $this->call(OrderSeedCommand::class);
        $this->call(SaleSeedCommand::class);
        $this->call(StockSeedCommand::class);
    }
}
