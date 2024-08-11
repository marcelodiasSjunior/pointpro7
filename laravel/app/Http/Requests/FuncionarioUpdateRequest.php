<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FuncionarioUpdateRequest extends FormRequest
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
            'jornada_id' => 'required|exists:jornadas,id',
            'funcao_id' => 'required|exists:funcoes,id',
            'name' => 'required',
            'nascimento' => 'required',
            'celular' => 'required',
            'cpf' => 'required|size:14',
            'sexo' => 'required',
            'estado_civil' => 'required',
            'grau_instrucao' => 'required',
            'cep' => 'required',
            'endereco' => 'required',
            'bairro' => 'required',
            'state_id' => 'required',
            'city_id' => 'required'
        ];
    }
}
