<?php

namespace App\Models\Traits;

trait HasAuth
{
    public function checkYourEntryUsingToken(string $token) : bool
    {
        return $this->apiToken()->where('token', $token)->exists();
    }
}
