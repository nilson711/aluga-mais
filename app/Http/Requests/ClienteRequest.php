<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $clienteId = $this->route('cliente')?->id;
        
        return [
            'nome' => 'required|string|max:100',
            'email' => 'nullable|email|max:100|unique:clientes,email,' . $clienteId,
            'telefone1' => 'required|string|max:15|regex:/^\([0-9]{2}\) [0-9]{4,5}-[0-9]{4}$/',
            'telefone2' => 'nullable|string|max:15|regex:/^\([0-9]{2}\) [0-9]{4,5}-[0-9]{4}$/',
            'cpf' => 'required|string|max:14|unique:clientes,cpf,' . $clienteId . '|regex:/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}-[0-9]{2}$/',
            'cep' => 'required|string|max:10',
            'logradouro' => 'required|string|max:200',
            'numero' => 'required|string|max:10',
            'complemento' => 'nullable|string|max:100',
            'bairro' => 'required|string|max:100',
            'cidade' => 'required|string|max:100',
            'uf' => 'required|string|max:2',
            'observacoes' => 'nullable|string',
            'ativo' => 'boolean',
        ];
    }
    
    public function messages(): array
    {
        return [
            'telefone1.regex' => 'Digite um telefone válido no formato (99) 99999-9999',
            'telefone2.regex' => 'Digite um telefone válido no formato (99) 99999-9999',
            'cpf.regex' => 'Digite um CPF válido no formato 111.111.111-11',
            'cpf.unique' => 'Este CPF já está cadastrado',
        ];
    }
}