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
            'payment_type' => 'required|in:VISA,PAYPAL,MBWAY',
            'payment_ref' => 'required',
            'nif' => 'required|digits:9',
        ];

        if ($this->input('payment_type') === 'VISA') {
            $rules['payment_ref'] .= '|digits:16';
        } elseif ($this->input('payment_type') === 'PAYPAL') {
            $rules['payment_ref'] .= '|email';
        } elseif ($this->input('payment_type') === 'MBWAY') {
            $rules['payment_ref'] .= '|digits:9';
        }

        return $rules;
    }

    public function messages(): array
    {
        $paymentType = $this->input('payment_type');
        $digitMessage = '';
        if ($paymentType === 'VISA') {
            $digitMessage = 'The payment card must be a valid 16-digit credit card number.';
        } elseif ($paymentType === 'MBWAY') {
            $digitMessage = 'The mobile phone must be a valid 9-digit number.';
        }

        return [
            'payment_ref.required' => 'Payment reference is required.',
            'payment_ref.digits' => $digitMessage,
            'payment_ref.email' => 'The Paypal email must be a valid email address.',
        ];
    }



}
