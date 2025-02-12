<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stripe extends Model{
    use HasFactory;
    protected $table = 'stripes';

    protected $fillable = [
        'email_id', 
        'publishable_key', 
        'secret_key', 
        'status', 
        'created_by', 
        'created_at', 
        'updated_by', 
        'updated_at'
    ];
}