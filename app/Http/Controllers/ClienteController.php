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
        // Limpar CPF/CNPJ antes da validação
        $cpfLimpo = preg_replace('/[^0-9]/', '', $request->cpf);
        
        // Verificar se é CPF (11 dígitos) ou CNPJ (14 dígitos)
        $digitos = strlen($cpfLimpo);
        if ($digitos !== 11 && $digitos !== 14) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['cpf' => 'O CPF deve ter 11 dígitos ou o CNPJ deve ter 14 dígitos.']);
        }
        
        // Verificar se o CPF/CNPJ já existe no banco
        $cpfExistente = Cliente::where('cpf', $cpfLimpo)->first();
        if ($cpfExistente) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['cpf' => 'Este CPF/CNPJ já está cadastrado.']);
        }
        
        // Verificar se o email já existe (se informado)
        if ($request->email) {
            $emailExistente = Cliente::where('email', $request->email)->first();
            if ($emailExistente) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['email' => 'Este email já está cadastrado.']);
            }
        }

        // Ajustar validação para aceitar CPF (14) ou CNPJ (18) com máscara
        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'telefone1' => 'required|string|max:15|regex:/^\([0-9]{2}\) [0-9]{4,5}-[0-9]{4}$/',
            'telefone2' => 'nullable|string|max:15|regex:/^\([0-9]{2}\) [0-9]{4,5}-[0-9]{4}$/',
            'cpf' => [
                'required',
                'string',
                'max:18',
                'regex:/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}-[0-9]{2}$|^[0-9]{2}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4}-[0-9]{2}$/'
            ],
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

        // Remove formatação antes de salvar
        $validated['telefone1'] = preg_replace('/[^0-9]/', '', $validated['telefone1']);
        $validated['telefone2'] = isset($validated['telefone2']) ? preg_replace('/[^0-9]/', '', $validated['telefone2']) : null;
        $validated['cpf'] = $cpfLimpo; // Usa o CPF/CNPJ já limpo
        
        $validated['ativo'] = $request->has('ativo') ? true : false;
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

        // Limpar CPF/CNPJ antes da validação
        $cpfLimpo = preg_replace('/[^0-9]/', '', $request->cpf);
        
        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'email' => 'nullable|email|unique:clientes,email,' . $cliente->id,
            'telefone1' => 'required|string|max:20',
            'telefone2' => 'nullable|string|max:20',
            'cpf' => [
                'required',
                'string',
                'max:18',
                'regex:/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}-[0-9]{2}$|^[0-9]{2}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4}-[0-9]{2}$/',
                'unique:clientes,cpf,' . $cliente->id,
            ],
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

        // Remover formatação antes de salvar
        $validated['cpf'] = $cpfLimpo;

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