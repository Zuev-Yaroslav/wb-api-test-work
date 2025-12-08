<?php

namespace App\Models;

use App\Models\Traits\HasAuth;
use App\Models\Traits\HasGetFreshData;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasGetFreshData;
    use HasAuth;
    protected $guarded = [];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
    public function apiToken()
    {
        return $this->account->apiToken();
    }
}
