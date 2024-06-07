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
            'date' => 'required|date|after_or_equal:today',
            'date_final' => 'nullable|date|after:date',
            'start_time' => 'required|after:' . now()->format('H:i'),
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
