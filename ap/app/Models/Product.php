<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Traits\SetCreatedBy;
use Carbon\Carbon;

class Product extends Model
{
    use  HasFactory;
    
    protected $fillable = [
        'product_name',
        'product_title',
        'product_description',
        'category',
        'tag',
        'size',
        'weight',
        'sku_id',
        'colour',
    ];

   
    
}
