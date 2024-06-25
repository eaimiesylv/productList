<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ProductFormRequest extends FormRequest
{
    
    public function rules(Request $request = Null): array
    {
        return [

            'product_name' => 'required|string|max:255',
            'product_title' => 'required|string|max:255',
            'product_description' => 'required|string',
            'category' => 'required|string|max:255',
            'tag' => 'required|string|max:255',
            'size' => 'required|integer|max:255',
            'weight' => 'required|numeric',
            'sku_id' => 'required|string|max:255|unique:products,sku_id',
            'colour' => 'required|string|max:255',
        
        ];
    }
   

}
