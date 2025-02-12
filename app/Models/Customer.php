<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model{
    use HasFactory;
    protected $table = 'customers';

    protected $fillable = [
        'name', 
        'phone', 
        'email', 
        'stripe_id',
        'stripe_customer_id',
        'status', 
        'created_at', 
        'created_by',
        'updated_at',
        'updated_by'
    ];
}