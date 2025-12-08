<?php

namespace App\HttpClients;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class SaleHttpClient extends  HttpClient
{
    protected const ENDPOINT_INDEX = '/sales';
}
