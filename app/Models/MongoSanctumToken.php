<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class MongoSanctumToken extends SanctumPersonalAccessToken
{
    protected $connection = 'mongodb';
    protected $collection = 'personal_access_tokens';
}
