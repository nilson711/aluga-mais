<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::paginate(10);
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'email' => 'nullable|email|max:100|unique:clientes',
            'telefone1' => 'required|string|max:15|regex:/^\([0-9]{2}\) [0-9]{4,5}-[0-9]{4}$/',
            'telefone2' => 'nullable|string|max:15|regex:/^\([0-9]{2}\) [0-9]{4,5}-[0-9]{4}$/',
            'cpf' => 'required|string|max:14|unique:clientes|regex:/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}-[0-9]{2}$/',
            'cep' => 'required|string|max:10',
            'logradouro' => 'required|string|max:200',
            'numero' => 'required|string|max:10',
            'complemento' => 'nullable|string|max:100',
            'bairro' => 'required|string|max:100',
            'cidade' => 'required|string|max:100',
            'uf' => 'required|string|max:2',
            'observacoes' => 'nullable|string',
            'ativo' => 'boolean',
            ],
            [
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'cpf.regex' => 'Digite um CPF válido no formato 111.111.111-11.',
            'telefone1.regex' => 'Digite um telefone válido no formato (11) 99999-9999.',
            ]
            );

              // Remove formatação antes de salvar
            $validated['telefone1'] = preg_replace('/[^0-9]/', '', $validated['telefone1']);
            $validated['telefone2'] = isset($validated['telefone2']) ? preg_replace('/[^0-9]/', '', $validated['telefone2']) : null;
            $validated['cpf'] = preg_replace('/[^0-9]/', '', $validated['cpf']);
            
            $validated['ativo'] = $request->has('ativo') ? true : false;
            
        // Adicionar o user_id do usuário logado
        $validated['user_id'] = Auth::id();

        Cliente::create($validated);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function show(Cliente $cliente)
    {
        // Carregar o relacionamento com o usuário
        $cliente->load('user');
        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
            // Verificar se o usuário tem permissão
            if ($cliente->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
                abort(403, 'Acesso não autorizado.');
            }

        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'email' => 'nullable|email|unique:clientes,email,' . $cliente->id,
            'telefone1' => 'required|string|max:20',
            'telefone2' => 'nullable|string|max:20',
            'cpf' => 'required|string|unique:clientes,cpf,' . $cliente->id,
            'cep' => 'required|string|max:10',
            'logradouro' => 'required|string|max:200',
            'numero' => 'required|string|max:10',
            'complemento' => 'nullable|string|max:100',
            'bairro' => 'required|string|max:100',  
            'cidade' => 'required|string|max:100',
            'uf' => 'required|string|max:2',
            'observacoes' => 'nullable|string',
            'ativo' => 'boolean',
        ]);

        $cliente->update($validated);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente removido com sucesso!');
    }
}