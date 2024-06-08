<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'photo_filename' => 'sometimes|image|mimes:png,jpg|max:4096', // maxsize = 4Mb
        ];
        if (strtolower($this->getMethod()) == 'post') {
            $rules = array_merge($rules, [
                'email' => 'required|string|email|max:255|unique:users',
            ]);
        }
        return $rules;
    }

    public function authorize(): bool
    {
        return true;
    }
}
