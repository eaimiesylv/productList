<?php

namespace App\Imports;

use App\Models\Currency;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Str;
use App\Http\Requests\CurrencyFormRequest;

class CurrencyImport implements ToModel, WithHeadingRow, WithValidation,SkipsEmptyRows
{
    public function model(array $row)
    {
        
       
        $currencyName = isset($row['currency_name']) ? Str::limit(trim($row['currency_name']), 15) : null;
        $currencySymbol = isset($row['currency_symbol']) ? Str::limit(trim($row['currency_symbol']), 5) : null;

       
        if ($currencyName && $currencySymbol) {
            return new Currency([
                'currency_name' => $currencyName,
                'currency_symbol' => $currencySymbol,
            ]);
        }


        return null;
    }
    public function rules(): array
    {
        $currencyFormRequest = new CurrencyFormRequest();
        return $currencyFormRequest->rules();
    }
    public function customValidationMessages()
    {
        return [
            'currency_name.regex' => 'The currency name must not start or end with a space.',
            'currency_symbol.regex' => 'The currency symbol must not start with a space',
            'currency_name.required' => 'The currency name field is required.', // Example additional message
            'currency_symbol.required' => 'The currency symbol field is required.',
            // Add other messages as needed
        ];
    }

   
}
