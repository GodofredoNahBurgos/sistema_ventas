<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'desciption',
        'quantity',
        'cost_price',
        'sale_price',
        'image',
        'active',
        'user_id',
        'category_id',
        'supplier_id'
    ];
}
