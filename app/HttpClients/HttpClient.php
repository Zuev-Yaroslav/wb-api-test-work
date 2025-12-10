<?php

namespace App\HttpClients;

use App\Models\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

abstract class HttpClient
{
    protected const ENDPOINT_INDEX = '/entity';
    protected PendingRequest $http;
    private static array $instances = [];

    private static function getInstance(): self
    {
        if (!isset(self::$instances[static::class])) {
            self::$instances[static::class] = new static();
        }
        return self::$instances[static::class];
    }

    public static function make() : self
    {
        return static::getInstance();
    }

    public function auth(string $key) : self
    {
        $this->http->withQueryParameters(['key' => $key]);
        return $this;
    }

    public function __construct()
    {
        $this->http = Http::wbapi();
    }
    public function index(array $queryParams) : Collection
    {
        $response = $this->http->get(static::ENDPOINT_INDEX, $queryParams);
        if ($response->getStatusCode() === 429) {
            dump('Too many requests. Next attempt in 100 seconds.');
            sleep(100);
            $response = $this->http->get(static::ENDPOINT_INDEX, $queryParams);
        }

        return $response->collect();
    }
    public function saveAllToDb(array $queryParams, string $model) : void
    {
        $accountIds = Account::all()->pluck('id');

        for ($i = 1; true; $i++) {
            $queryParams['page'] = $i;
            $data = $this->index($queryParams);
            if (!isset($data['data'])) {
                dump('No data. There must have been some mistake');
                break;
            }
            $items = collect($data['data']);
            if ($items->isEmpty()) {
                dump('No data in ' . $i . ' page');
                break;
            }
            $items->each(function ($item) use ($model, $accountIds) {
                if ($accountIds->isNotEmpty()) {
                    $item['account_id'] = $accountIds->random();
                }
                $model::create($item);
            });
            dump($model . ' records in page ' . $i . ' was saved successfully');
        }

    }

}
