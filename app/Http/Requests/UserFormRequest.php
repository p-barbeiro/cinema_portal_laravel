<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'photo_filename' => 'sometimes|image|mimes:png,jpg|max:4096', // maxsize = 4Mb
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
