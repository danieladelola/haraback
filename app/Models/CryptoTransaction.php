<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CryptoTransaction extends Model
{
    // If your table is not 'crypto_transactions', uncomment the line below and set the correct table name
    // protected $table = 'crypto_transactions';

    // Add the fields you want to be mass assignable
    protected $fillable = [
        'user_id',
        'type',         // 'buy', 'sell', 'deposit', etc.
        'currency',     // e.g. 'BTC', 'ETH'
        'amount',       // crypto amount
        'rate',         // USD per 1 crypto
        'total',        // total USD
        'status',       // e.g. 'completed'
    ];

    // If you want timestamps (created_at, updated_at), leave as is.
    // If not, add: public $timestamps = false;
}
