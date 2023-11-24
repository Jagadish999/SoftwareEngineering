<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerBid extends Model
{
    use HasFactory;

    protected $table = 'customer_bids';

    protected $fillable = [
        'user_id',
        'product_id',
        'userBidAmt',
        'userEmail',
        'userMessage',
        'userPhone',
        'status',
    ];
}
