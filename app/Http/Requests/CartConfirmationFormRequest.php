<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CartConfirmationFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'payment_type' => 'required|in:VISA,PAYPAL,MBWAY',
            'payment_ref' => 'required',
            'cvv' => 'required_if:payment_type,"VISA",digits:3',
            'nif' => 'nullable|digits:9',
            ];

        return $rules;
    }

}
