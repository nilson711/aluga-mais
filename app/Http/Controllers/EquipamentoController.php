<?php

namespace App\Http\Controllers;

use App\Models\Equipamento;
use Illuminate\Http\Request;

class EquipamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Equipamento::query();
        
        // Busca por texto (nome, patrimônio, marca, modelo)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'ilike', "%{$search}%")
                  ->orWhere('numero_patrimonio', 'ilike', "%{$search}%")
                  ->orWhere('marca', 'ilike', "%{$search}%")
                  ->orWhere('modelo', 'ilike', "%{$search}%");
            });
        }
        
        // Filtro por categoria
        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }
        
        // Filtro por status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $equipamentos = $query->orderBy('id', 'desc')->paginate(15);
        
        return view('equipamentos.index', compact('equipamentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('equipamentos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'numero_patrimonio' => 'nullable|string|max:50|unique:equipamentos,numero_patrimonio',
            'nome' => 'required|string|max:100',
            'marca' => 'nullable|string|max:50',
            'modelo' => 'nullable|string|max:50',
            'categoria' => 'required|string|max:50',
            'observacoes' => 'nullable|string',
            'preco_diaria' => 'required|numeric|min:0',
            'preco_semanal' => 'required|numeric|min:0',
            'preco_mensal' => 'required|numeric|min:0',
            'caucao' => 'required|numeric|min:0',
            'foto' => 'nullable|string',
            'especificacoes' => 'nullable|string',
            'status' => 'required|in:Disponível,Alugado,Manutenção,Vendido',
            'data_aquisicao' => 'nullable|date',
            'valor_aquisicao' => 'nullable|numeric|min:0',
            'data_venda' => 'nullable|date',
            'valor_venda' => 'nullable|numeric|min:0',
        ]);

        Equipamento::create($validated);

        return redirect()->route('equipamentos.index')
            ->with('success', 'Equipamento cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipamento $equipamento)
    {
        return view('equipamentos.show', compact('equipamento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipamento $equipamento)
    {
        return view('equipamentos.edit', compact('equipamento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Equipamento $equipamento)
    {
        $validated = $request->validate([
            'numero_patrimonio' => 'nullable|string|max:50|unique:equipamentos,numero_patrimonio,' . $equipamento->id,
            'nome' => 'required|string|max:100',
            'marca' => 'nullable|string|max:50',
            'modelo' => 'nullable|string|max:50',
            'categoria' => 'required|string|max:50',
            'observacoes' => 'nullable|string',
            'preco_diaria' => 'required|numeric|min:0',
            'preco_semanal' => 'required|numeric|min:0',
            'preco_mensal' => 'required|numeric|min:0',
            'caucao' => 'required|numeric|min:0',
            'foto' => 'nullable|string',
            'especificacoes' => 'nullable|string',
            'status' => 'required|in:Disponível,Alugado,Manutenção,Vendido',
            'data_aquisicao' => 'nullable|date',
            'valor_aquisicao' => 'nullable|numeric|min:0',
            'data_venda' => 'nullable|date',
            'valor_venda' => 'nullable|numeric|min:0',
        ]);

        $equipamento->update($validated);

        return redirect()->route('equipamentos.index')
            ->with('success', 'Equipamento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipamento $equipamento)
    {
        // Verificar se o equipamento possui pedidos
        if ($equipamento->itensPedido()->count() > 0) {
            return redirect()->route('equipamentos.index')
                ->with('error', 'Não é possível excluir este equipamento pois ele possui pedidos vinculados.');
        }

        $equipamento->delete();

        return redirect()->route('equipamentos.index')
            ->with('success', 'Equipamento removido com sucesso!');
    }

    /**
     * Buscar equipamentos por categoria
     */
    public function porCategoria($categoria)
    {
        $equipamentos = Equipamento::where('categoria', $categoria)
            ->where('status', 'Disponível')
            ->paginate(15);
        
        return view('equipamentos.index', compact('equipamentos'));
    }

    /**
     * Buscar equipamentos disponíveis
     */
    public function disponiveis()
    {
        $equipamentos = Equipamento::where('status', 'Disponível')
            ->orderBy('nome')
            ->paginate(15);
        
        return view('equipamentos.index', compact('equipamentos'));
    }

    /**
     * Ativar/Desativar equipamento (alternar entre Disponível e Manutenção)
     */
    public function toggleStatus(Equipamento $equipamento)
    {
        if ($equipamento->status === 'Disponível') {
            $equipamento->status = 'Manutenção';
            $mensagem = 'Equipamento colocado em manutenção!';
        } elseif ($equipamento->status === 'Manutenção') {
            $equipamento->status = 'Disponível';
            $mensagem = 'Equipamento voltou a ficar disponível!';
        } else {
            return redirect()->route('equipamentos.index')
                ->with('error', 'Apenas equipamentos disponíveis ou em manutenção podem ter o status alternado.');
        }
        
        $equipamento->save();

        return redirect()->route('equipamentos.index')
            ->with('success', $mensagem);
    }

    /**
     * Registrar venda de equipamento
     */
    public function registrarVenda(Request $request, Equipamento $equipamento)
    {
        $request->validate([
            'data_venda' => 'required|date',
            'valor_venda' => 'required|numeric|min:0',
        ]);

        $equipamento->update([
            'data_venda' => $request->data_venda,
            'valor_venda' => $request->valor_venda,
            'status' => 'Vendido',
        ]);

        return redirect()->route('equipamentos.show', $equipamento)
            ->with('success', 'Venda registrada com sucesso!');
    }

    /**
     * API: Buscar equipamentos para select (AJAX)
     */
    public function buscarParaSelect(Request $request)
    {
        $search = $request->get('q', '');
        
        $equipamentos = Equipamento::where('status', 'Disponível')
            ->where(function($query) use ($search) {
                $query->where('nome', 'like', "%{$search}%")
                    ->orWhere('numero_patrimonio', 'like', "%{$search}%")
                    ->orWhere('marca', 'like', "%{$search}%");
            })
            ->limit(10)
            ->get(['id', 'numero_patrimonio', 'nome', 'marca', 'modelo', 'preco_diaria']);
        
        return response()->json($equipamentos);
    }
}