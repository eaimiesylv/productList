<?php

namespace App\Http\Requests\Tested;

use Illuminate\Foundation\Http\FormRequest;

class MediaFormRequest extends FormRequest
{
   

    public function rules()
    {
        return [
            'media' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'media_name' => 'required|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,xlsx,xls', 
        ];
    }
}