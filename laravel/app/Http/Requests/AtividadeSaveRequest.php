<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AtividadeSaveRequest extends FormRequest
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
            'dias_da_semana' => 'required',
            'funcao' => 'required|exists:funcoes,id',
            'description' => 'required',
            'funcionarios' => 'required'
        ];
    }
}
