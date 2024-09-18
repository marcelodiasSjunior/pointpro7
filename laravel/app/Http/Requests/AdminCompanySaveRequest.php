<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminCompanySaveRequest extends FormRequest
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
            'title' => 'required',
            'seguimento' => 'required',
            'razao_social' => 'required',
            'cnpj' => 'required|size:18|unique:companies',
            'telefone' => 'required|min:14, max:15',
            'cep' => 'required|size:8',
            'endereco' => 'required',
            'bairro' => 'required',
            'city_id' => 'required',
            'plan' => 'required',
            'ativa' => 'required'
        ];
    }
}
