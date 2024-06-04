<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigurationFormRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'ticket_price' => 'required|numeric|min:0',
            'registered_customer_ticket_discount' => 'required|numeric|min:0',
        ];
        return $rules;
    }

    public function authorize(): bool
    {
        return true;
    }
}
