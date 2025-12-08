<?php

use App\Console\Commands\Seed\IncomeSeedCommand;
use App\Console\Commands\Seed\OrderSeedCommand;
use App\Console\Commands\Seed\SaleSeedCommand;
use App\Console\Commands\Seed\StockSeedCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

$now = Carbon::now()->format('Y-m-d');

Schedule::command(IncomeSeedCommand::class, [$now])->twiceDaily(12, 18);
Schedule::command(OrderSeedCommand::class, [$now])->twiceDaily(12, 18);
Schedule::command(SaleSeedCommand::class, [$now])->twiceDaily(12, 18);
Schedule::command(StockSeedCommand::class)->twiceDaily(12, 18);
