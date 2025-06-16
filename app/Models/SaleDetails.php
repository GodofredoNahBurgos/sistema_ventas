<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleDetails extends Model
{
    protected $table = 'sale_details';
    protected $fillable = [
        'quantity',
        'unit_price',
        'sub_total',
        'sale_id',
        'product_id',
    ];
}
