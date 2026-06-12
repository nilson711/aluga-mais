<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\ItemPedido;
use App\Models\Equipamento;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Data atual
        $hoje = Carbon::today();
        $inicioSemana = Carbon::now()->startOfWeek();
        $inicioMes = Carbon::now()->startOfMonth();
        
        // ============================================
        // 1. RESUMO DO DIA
        // ============================================
        
        // Itens alugados hoje
        $itensAlugadosHoje = ItemPedido::whereHas('pedido', function($query) use ($hoje) {
            $query->whereDate('data_entrega', $hoje)
                  ->where('status', '!=', 'cancelado');
        })->sum('quantidade');
        
        // Pedidos pendentes
        $pedidosPendentes = Pedido::where('status', 'pendente')->count();
        
        // Devoluções hoje
        $devolucoesHoje = Pedido::whereDate('data_devolucao', $hoje)
            ->where('status', '!=', 'cancelado')
            ->count();
        
        // ============================================
        // 2. FATURAMENTO
        // ============================================
        
        $faturamentoHoje = Pedido::whereDate('created_at', $hoje)
            ->where('status', '!=', 'cancelado')
            ->sum('total');
        
        $faturamentoSemana = Pedido::where('created_at', '>=', $inicioSemana)
            ->where('status', '!=', 'cancelado')
            ->sum('total');
        
        $faturamentoMes = Pedido::where('created_at', '>=', $inicioMes)
            ->where('status', '!=', 'cancelado')
            ->sum('total');
        
        // ============================================
        // 3. ITENS MAIS ALUGADOS
        // ============================================
        
        $itensPopulares = Equipamento::select('equipamentos.id', 'equipamentos.nome', DB::raw('SUM(itens_pedido.quantidade) as total_alugueis'))
            ->join('itens_pedido', 'equipamentos.id', '=', 'itens_pedido.equipamento_id')
            ->join('pedidos', 'itens_pedido.pedido_id', '=', 'pedidos.id')
            ->where('pedidos.status', '!=', 'cancelado')
            ->groupBy('equipamentos.id', 'equipamentos.nome')
            ->orderBy('total_alugueis', 'desc')
            ->limit(5)
            ->get();
        
        // ============================================
        // 4. PRÓXIMAS ENTREGAS (próximos 7 dias)
        // ✅ Mostrar pedidos pendentes OU aprovados que ainda não foram entregues
        // ============================================
        
        $proximasEntregas = Pedido::with(['cliente', 'itens'])
            ->whereIn('status', ['pendente', 'aprovado'])
            ->whereDate('data_entrega', '>=', $hoje)
            ->whereDate('data_entrega', '<=', $hoje->copy()->addDays(7))
            ->orderBy('data_entrega', 'asc')
            ->limit(5)
            ->get();
        
        // ============================================
        // 5. PRÓXIMAS DEVOLUÇÕES (próximos 7 dias)
        // ============================================
        
        $proximasDevolucoes = Pedido::with(['cliente', 'itens'])
            ->where('status', 'entregue')
            ->whereDate('data_devolucao', '>=', $hoje)
            ->whereDate('data_devolucao', '<=', $hoje->copy()->addDays(7))
            ->orderBy('data_devolucao', 'asc')
            ->limit(5)
            ->get();
        
        // ============================================
        // 6. PEDIDOS RECENTES
        // ============================================
        
        $pedidosRecentes = Pedido::with('cliente')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return view('dashboard', compact(
            'itensAlugadosHoje',
            'pedidosPendentes',
            'devolucoesHoje',
            'faturamentoHoje',
            'faturamentoSemana',
            'faturamentoMes',
            'itensPopulares',
            'proximasEntregas',
            'proximasDevolucoes',
            'pedidosRecentes'
        ));
    }
}