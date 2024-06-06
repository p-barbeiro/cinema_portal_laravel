<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScreeningFormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'movie_id' => 'required|exists:movies,id',
            'theater_id' => 'required|exists:theaters,id',
            'date' => 'required|date|after:yesterday',
            'date_final' => 'nullable|date|after:date',
            'start_time' => 'required',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
