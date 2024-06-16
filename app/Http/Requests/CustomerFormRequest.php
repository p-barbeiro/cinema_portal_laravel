<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerFormRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'payment_type' => 'nullable|in:VISA,PAYPAL,MBWAY',
            'nif' => 'nullable|digits:9',
            'name' => 'required|string|max:255',
            'photo_filename' => 'sometimes|image|mimes:png,jpg|max:4096', // maxsize = 4Mb
        ];

        $rules['payment_ref'] = [
            'required_with:payment_type',
            $this->getPaymentRefRule(),
        ];

        return $rules;
    }

    private function getPaymentRefRule()
    {
        return function ($attribute, $value, $fail) {
            switch ($this->payment_type) {
                case 'VISA':
                    if (!is_numeric($value) || strlen($value) !== 16) {
                        $fail('The payment reference for VISA must be a 16-digit number.');
                    }
                    break;
                case 'MBWAY':
                    if (!is_numeric($value) || strlen($value) !== 9 || $value[0] !== '9') {
                        $fail('The payment reference for MBWAY must be a 9-digit number starting with 9.');
                    }
                    break;
                case 'PAYPAL':
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $fail('The payment reference for PAYPAL must be a valid email address.');
                    }
                    break;
                default:
                    $fail('The selected payment type is invalid.');
            }
        };
    }


    public function authorize(): bool
    {
        return true;
    }
}
