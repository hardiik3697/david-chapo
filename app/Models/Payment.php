<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model{
    use HasFactory;
    protected $table = 'payments';

    protected $fillable = [
        'customer_id', 
        'customer_platform_id', 
        'amount', 
        'payment_id', 
        'client_secret', 
        'payment_type',
        'payment_type_id',
        'payment_method_types',
        'payment_status',
        'recharge_status', 
        'created_at', 
        'created_by',
        'updated_at',
        'updated_by',
        'recharge_at',
        'recharge_by'
    ];
}