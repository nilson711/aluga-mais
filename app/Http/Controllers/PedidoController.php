<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Equipamento;
use App\Models\ItemPedido;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pedidos = Pedido::with('cliente')->orderBy('id', 'desc')->paginate(15);
        return view('pedidos.index', compact('pedidos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::orderBy('nome')->get();
        $equipamentos = Equipamento::where('status', 'Disponível')
            ->whereNull('data_venda')
            ->orderBy('nome')
            ->get();
        
        return view('pedidos.create', compact('clientes', 'equipamentos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
                'cliente_id' => 'required|exists:clientes,id',
                'cep_entrega' => 'nullable|string|max:10',
                'logradouro_entrega' => 'nullable|string|max:200',
                'numero_entrega' => 'nullable|string|max:10',
                'complemento_entrega' => 'nullable|string|max:100',
                'bairro_entrega' => 'nullable|string|max:100',
                'cidade_entrega' => 'nullable|string|max:100',
                'uf_entrega' => 'nullable|string|max:2',
                'data_entrega' => 'required|date',
                'data_devolucao' => 'required|date|after:data_entrega',
                'forma_pagamento' => 'required|string',
                'taxa_entrega' => 'nullable|numeric|min:0',
                'desconto' => 'nullable|numeric|min:0',
                'observacoes' => 'nullable|string',
                'itens' => 'required|array|min:1',
                'itens.*.equipamento_id' => 'required|exists:equipamentos,id',
                'itens.*.quantidade' => 'required|integer|min:1',

            ]);

        // ✅ Calcular dias totais no back-end (IGNORAR o valor do front-end)
        $dataEntrega = Carbon::parse($request->data_entrega);
        $dataDevolucao = Carbon::parse($request->data_devolucao);
        
        // Calcular diferença em horas e arredondar para cima
        $diferencaEmHoras = $dataEntrega->diffInHours($dataDevolucao);
        $diasTotais = (int) ceil($diferencaEmHoras / 24);
        
        // Garantir que seja no mínimo 1 dia
        if ($diasTotais < 1) {
            $diasTotais = 1;
        }
        
        // Calcular subtotal baseado nos dias calculados
        $subtotal = 0;
        foreach ($request->itens as $item) {
            $equipamento = Equipamento::find($item['equipamento_id']);
            $precoTotal = $equipamento->preco_diaria * $diasTotais * $item['quantidade'];
            $subtotal += $precoTotal;
        }

        // Arredondar valores para 2 casas decimais
        $subtotal = round($subtotal, 2);
        $desconto = round($request->desconto ?? 0, 2);
        $total = round($subtotal - $desconto, 2);
    
         // Criar pedido com endereço de entrega
        $pedido = Pedido::create([
            'cliente_id' => $request->cliente_id,
            'cep_entrega' => $request->cep_entrega,
            'logradouro_entrega' => $request->logradouro_entrega,
            'numero_entrega' => $request->numero_entrega,
            'complemento_entrega' => $request->complemento_entrega,
            'bairro_entrega' => $request->bairro_entrega,
            'cidade_entrega' => $request->cidade_entrega,
            'uf_entrega' => $request->uf_entrega,
            'data_entrega' => $request->data_entrega,
            'data_devolucao' => $request->data_devolucao,
            'dias_totais' => $diasTotais,
            'subtotal' => $subtotal,
            'taxa_entrega' => $request->taxa_entrega ?? 0,
            'desconto' => $desconto,
            // 'total' => $total,
            'total' => ($subtotal + ($request->taxa_entrega ?? 0)) - $desconto,
            'status' => 'pendente',
            'observacoes' => $request->observacoes,
            'forma_pagamento' => $request->forma_pagamento,
            'caucao_pago' => $request->has('caucao_pago') ? 1 : 0,

            'localizacao' => $request->localizacao,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        // Criar itens do pedido
        foreach ($request->itens as $item) {
            $equipamento = Equipamento::find($item['equipamento_id']);
            $precoUnitario = round($equipamento->preco_diaria * $diasTotais, 2);
            
            ItemPedido::create([
                'pedido_id' => $pedido->id,
                'equipamento_id' => $item['equipamento_id'],
                'quantidade' => $item['quantidade'],
                'preco_unitario' => $precoUnitario,
                'subtotal' => round($precoUnitario * $item['quantidade'], 2),
                'observacoes' => $item['observacoes'] ?? null,
            ]);
        }

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        $pedido->load('cliente', 'itens.equipamento');
        return view('pedidos.show', compact('pedido'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pedido $pedido)
    {
        // 

        $clientes = Cliente::orderBy('nome')->get();
        $equipamentos = Equipamento::where('status', 'Disponível')
            ->whereNull('data_venda')
            ->orderBy('nome')
            ->get();
        
        $pedido->load('itens');
        
        return view('pedidos.edit', compact('pedido', 'clientes', 'equipamentos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        // ✅ Validar todos os campos (incluindo endereço e localização)
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'cep_entrega' => 'nullable|string|max:10',
            'logradouro_entrega' => 'nullable|string|max:200',
            'numero_entrega' => 'nullable|string|max:10',
            'complemento_entrega' => 'nullable|string|max:100',
            'bairro_entrega' => 'nullable|string|max:100',
            'cidade_entrega' => 'nullable|string|max:100',
            'uf_entrega' => 'nullable|string|max:2',
            'data_entrega' => 'required|date',
            'data_devolucao' => 'required|date|after:data_entrega',
            'forma_pagamento' => 'required|string',
            'taxa_entrega' => 'nullable|numeric|min:0',
            'desconto' => 'nullable|numeric|min:0',
            'observacoes' => 'nullable|string',
            'localizacao' => 'nullable|string|max:255',
            'latitude' => 'nullable|string|max:20',
            'longitude' => 'nullable|string|max:20',
            'itens' => 'required|array|min:1',
            'itens.*.equipamento_id' => 'required|exists:equipamentos,id',
            'itens.*.quantidade' => 'required|integer|min:1',
        ]);

        // ✅ Calcular dias totais (usando horas para precisão)
        $dataEntrega = Carbon::parse($request->data_entrega);
        $dataDevolucao = Carbon::parse($request->data_devolucao);
        
        $diferencaEmHoras = $dataEntrega->diffInHours($dataDevolucao);
        $diasTotais = (int) ceil($diferencaEmHoras / 24);
        
        if ($diasTotais < 1) {
            $diasTotais = 1;
        }

        // ✅ Calcular subtotal
        $subtotal = 0;
        foreach ($request->itens as $item) {
            $equipamento = Equipamento::find($item['equipamento_id']);
            $precoTotal = $equipamento->preco_diaria * $diasTotais * $item['quantidade'];
            $subtotal += $precoTotal;
        }

        $subtotal = round($subtotal, 2);
        $taxaEntrega = round($request->taxa_entrega ?? 0, 2);
        $desconto = round($request->desconto ?? 0, 2);
        $total = round($subtotal + $taxaEntrega - $desconto, 2);

        // ✅ Remover itens antigos
        $pedido->itens()->delete();

        // ✅ Atualizar pedido com todos os campos
        $pedido->update([
            'cliente_id' => $request->cliente_id,
            'cep_entrega' => $request->cep_entrega,
            'logradouro_entrega' => $request->logradouro_entrega,
            'numero_entrega' => $request->numero_entrega,
            'complemento_entrega' => $request->complemento_entrega,
            'bairro_entrega' => $request->bairro_entrega,
            'cidade_entrega' => $request->cidade_entrega,
            'uf_entrega' => $request->uf_entrega,
            'data_entrega' => $request->data_entrega,
            'data_devolucao' => $request->data_devolucao,
            'dias_totais' => $diasTotais,
            'subtotal' => $subtotal,
            'taxa_entrega' => $taxaEntrega,
            'desconto' => $desconto,
            'total' => $total,
            'observacoes' => $request->observacoes,
            'forma_pagamento' => $request->forma_pagamento,
            'localizacao' => $request->localizacao,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        // ✅ Criar novos itens
        foreach ($request->itens as $item) {
            $equipamento = Equipamento::find($item['equipamento_id']);
            $precoUnitario = round($equipamento->preco_diaria * $diasTotais, 2);
            
            ItemPedido::create([
                'pedido_id' => $pedido->id,
                'equipamento_id' => $item['equipamento_id'],
                'quantidade' => $item['quantidade'],
                'preco_unitario' => $precoUnitario,
                'subtotal' => round($precoUnitario * $item['quantidade'], 2),
                'observacoes' => $item['observacoes'] ?? null,
            ]);
        }

        return redirect()->route('pedidos.show', $pedido)
            ->with('success', 'Pedido atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        if ($pedido->status != 'pendente') {
            return redirect()->route('pedidos.index')
                ->with('error', 'Apenas pedidos pendentes podem ser excluídos.');
        }

        $pedido->itens()->delete();
        $pedido->delete();

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido excluído com sucesso!');
    }

    /**
     * Aprovar pedido
     */
    public function aprovar(Pedido $pedido)
    {
        if ($pedido->status != 'pendente') {
            return redirect()->route('pedidos.index')
                ->with('error', 'Pedido não pode ser aprovado.');
        }

        $pedido->update(['status' => 'aprovado']);

        return redirect()->route('pedidos.show', $pedido)
            ->with('success', 'Pedido aprovado com sucesso!');
    }

    /**
     * Esta função registra a entrega dos equipamento 
     * o nome 'retirar' se referia a saída do equipamento do estoque
     */
    public function retirar(Pedido $pedido)
    {
        if ($pedido->status != 'aprovado') {
            return redirect()->route('pedidos.index')
                ->with('error', 'Pedido não pode ser retirado.');
        }

        $pedido->update(['status' => 'entregue']);

        return redirect()->route('pedidos.show', $pedido)
            ->with('success', 'Entrega registrada com sucesso!');
    }

    /**
     * Registrar devolução
     */
    public function devolver(Pedido $pedido)
    {
        if ($pedido->status != 'entregue') {
            return redirect()->route('pedidos.index')
                ->with('error', 'Pedido não pode ser devolvido.');
        }

        $pedido->update(['status' => 'devolvido']);

        // Registrar devolução em todos os itens
        foreach ($pedido->itens as $item) {
            $item->update([
                'devolvido' => true,
                'data_devolucao_real' => now(),
            ]);
        }

        return redirect()->route('pedidos.show', $pedido)
            ->with('success', 'Devolução registrada com sucesso!');
    }

    /**
     * Cancelar pedido
     */
    public function cancelar(Pedido $pedido)
    {
        if (!in_array($pedido->status, ['pendente', 'aprovado'])) {
            return redirect()->route('pedidos.index')
                ->with('error', 'Pedido não pode ser cancelado.');
        }

        $pedido->update(['status' => 'cancelado']);

        return redirect()->route('pedidos.show', $pedido)
            ->with('success', 'Pedido cancelado com sucesso!');
    }
}