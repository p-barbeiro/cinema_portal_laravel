<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieFormRequest extends FormRequest
{

    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'genre_code' => 'required|exists:genres,code',
            'year' => 'required|integer|min:1000|max:9999',
            'synopsis' => 'required|string|max:500',
            'poster_filename' => 'sometimes|image|mimes:png,jpg|max:4096', // maxsize = 4Mb
            'trailer_url' => 'nullable|url|max:255',
        ];
        return $rules;

    }

    public function authorize(): bool
    {
        return true;
    }
}
