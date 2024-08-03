<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JornadaSaveRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'segunda' => 'required|date_format:H:i',
            'terca' => 'required|date_format:H:i',
            'quarta' => 'required|date_format:H:i',
            'quinta' => 'required|date_format:H:i',
            'sexta' => 'required|date_format:H:i',
            'sabado' => 'required|date_format:H:i',
            'domingo' => 'required|date_format:H:i',
        ];
    }
}
