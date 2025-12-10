<?php

namespace App\Console\Commands\AfterMigrations;

use App\Models\Account;
use App\Models\Income;
use App\Models\Order;
use App\Models\Sale;
use App\Models\Stock;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class SetAccountIdInTablesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'after-migrations:set-account-id-in-tables';
    //php artisan after-migrations:set-account-id-in-tables

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set account id in tables';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $choice = $this->choice(
            'Choose model.',
            ['Stock', 'Income', 'Order', 'Sale', 'All'],
        );
        $accountIds = Account::all()->pluck('id');
        if ($accountIds->isEmpty()) {
            $this->error('Accounts is not found');
            return;
        }

        switch ($choice) {
            case 'Stock':
                $this->info('start this stocks process');
                $stocks = Stock::whereNull('account_id')->latestDate()->get();
                $this->setAccountIdInTables($stocks, $accountIds);
                $this->info("\n" . 'Done');
                break;
            case 'Income':
                $this->info('start this incomes process');
                $incomes = Income::whereNull('account_id')->latestDate()->get();
                $this->setAccountIdInTables($incomes, $accountIds);
                $this->info("\n" . 'Done');
                break;
            case 'Order':
                $this->info('start this orders process');
                $orders = Order::whereNull('account_id')->latestDate()->get();
                $this->setAccountIdInTables($orders, $accountIds);
                $this->info("\n" . 'Done');
                break;
            case 'Sale':
                $this->info('start this sales process');
                $sales = Sale::whereNull('account_id')->latestDate()->get();
                $this->setAccountIdInTables($sales, $accountIds);
                $this->info("\n" . 'Done');
                break;
        }
    }

    private function setAccountIdInTables($entities, Collection $accountIds)
    {
        if ($entities->IsEmpty()) {
            $this->info('Everyone has an account id.');
            exit();
        }
        $this->withProgressBar(
            $entities,
            function (Model $entity) use ($accountIds) {
                $entity->update([
                    'account_id' => $accountIds->random(),
                ]);
            }
        );
    }
}
