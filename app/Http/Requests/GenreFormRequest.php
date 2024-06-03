<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenreFormRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
        ];
        if (strtolower($this->getMethod()) == 'post') {
            $rules = array_merge($rules, [
                'code' => 'required|string|max:255|unique:genres,code|alpha_dash',
            ]);
        }
        return $rules;
    }

    public function authorize(): bool
    {
        return true;
    }
}
