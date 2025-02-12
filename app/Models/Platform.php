<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model{
    use HasFactory;
    protected $table = 'platforms';

    protected $fillable = [
        'name', 
        'description', 
        'backend_url', 
        'frontend_url', 
        'logo', 
        'image', 
        'status', 
        'created_at', 
        'created_by', 
        'updated_at', 
        'updated_by'
    ];
}