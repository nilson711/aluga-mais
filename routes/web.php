<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EquipamentoController;
use App\Http\Controllers\PedidoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Rota do dashboard usando o DashboardController
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Clientes
    Route::resource('clientes', ClienteController::class);
    
    // Equipamentos
    Route::resource('equipamentos', EquipamentoController::class);
    Route::get('/equipamentos/categoria/{categoria}', [EquipamentoController::class, 'porCategoria'])->name('equipamentos.porCategoria');
    Route::get('/equipamentos/disponiveis', [EquipamentoController::class, 'disponiveis'])->name('equipamentos.disponiveis');
    Route::patch('/equipamentos/{equipamento}/toggle', [EquipamentoController::class, 'toggleAtivo'])->name('equipamentos.toggleAtivo');
    Route::post('/equipamentos/{equipamento}/venda', [EquipamentoController::class, 'registrarVenda'])->name('equipamentos.registrarVenda');
    Route::get('/equipamentos/buscar/select', [EquipamentoController::class, 'buscarParaSelect'])->name('equipamentos.buscar');
    
    // Pedidos
    Route::resource('pedidos', PedidoController::class);
    Route::post('/pedidos/{pedido}/aprovar', [PedidoController::class, 'aprovar'])->name('pedidos.aprovar');
    Route::post('/pedidos/{pedido}/retirar', [PedidoController::class, 'retirar'])->name('pedidos.retirar');
    Route::post('/pedidos/{pedido}/devolver', [PedidoController::class, 'devolver'])->name('pedidos.devolver');
    Route::post('/pedidos/{pedido}/cancelar', [PedidoController::class, 'cancelar'])->name('pedidos.cancelar');
});

// Rota para buscar endereço do cliente (fora do grupo auth, mas com middleware auth)
Route::get('/clientes/{cliente}/endereco', function(App\Models\Cliente $cliente) {
    return response()->json([
        'cep' => $cliente->cep,
        'logradouro' => $cliente->logradouro,
        'numero' => $cliente->numero,
        'complemento' => $cliente->complemento,
        'bairro' => $cliente->bairro,
        'cidade' => $cliente->cidade,
        'uf' => $cliente->uf,
    ]);
})->middleware('auth')->name('clientes.endereco');

require __DIR__.'/auth.php';