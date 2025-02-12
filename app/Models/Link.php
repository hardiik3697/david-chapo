<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model{
    use HasFactory;
    protected $table = 'links';

    protected $fillable = [
        'link', 
        'created_at', 
        'created_by',
        'updated_at',
        'updated_by'
    ];
}