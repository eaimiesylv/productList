<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class AuthFormRequest extends FormRequest
{
    public function rules(Request $request): array
    {
       
        $rules = [
            'email' => [
                'required',
                'email',
                'max:55',
            ],
            'password' => 'required|string|min:2|max:60',
            //'code' => 'required|string|min:2|max:60',
        ];
       
        if ($request->code === 'yes') {
          
    
        } else {
            
            $rules['email'][] = Rule::exists('users', 'email');
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'email.exists' => 'Invalid credentials',
            // 'organization_code.required' => 'The organization code is required when code is yes.', // Uncomment or add any additional messages you need
        ];
    }
}
