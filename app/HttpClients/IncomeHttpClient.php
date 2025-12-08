<?php

namespace App\HttpClients;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class IncomeHttpClient extends  HttpClient
{
    protected const ENDPOINT_INDEX = '/incomes';
}
