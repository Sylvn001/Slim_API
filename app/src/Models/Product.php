<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model{
    protected $fillable = [
        'title',
        'description',
        'manufacturer',
        'price',
        'created_at',
        'updated_at',
    ];
}