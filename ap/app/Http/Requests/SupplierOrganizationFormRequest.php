<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SupplierOrganizationFormRequest extends FormRequest
{
    
    public function rules(Request $request): array
    {
        return [
           
            'organization_code' => 'required|integer',
         
        
        ];
    }


}
