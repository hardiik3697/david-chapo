<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPlatform extends Model{
    use HasFactory;
    protected $table = 'customers_platform';

    protected $fillable = [
        'customer_id', 
        'platform_id', 
        'username', 
        'status', 
        'created_at', 
        'created_by',
        'updated_at',
        'updated_by'
    ];
}