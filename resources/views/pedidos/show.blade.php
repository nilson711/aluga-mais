<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pedido #') }}{{ $pedido->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Status e ações -->
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <span class="px-3 py-1 rounded-full text-sm font-semibold 
                                @if($pedido->status == 'pendente') bg-yellow-100 text-yellow-800
                                @elseif($pedido->status == 'aprovado') bg-blue-100 text-blue-800
                                @elseif($pedido->status == 'entregue') bg-purple-100 text-purple-800
                                @elseif($pedido->status == 'devolvido') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($pedido->status) }}
                            </span>
                        </div>
                        <div class="flex gap-2">
                            @if($pedido->status == 'pendente')
                                <form action="{{ route('pedidos.aprovar', $pedido) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded">Aprovar</button>
                                </form>
                            @endif
                            @if($pedido->status == 'aprovado')
                                <form action="{{ route('pedidos.retirar', $pedido) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-purple-500 hover:bg-purple-700 text-white px-4 py-2 rounded">Registrar Entrega</button>
                                </form>
                            @endif
                            @if($pedido->status == 'entregue')
                                <form action="{{ route('pedidos.devolver', $pedido) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">Registrar Devolução</button>
                                </form>
                            @endif
                            @if(in_array($pedido->status, ['pendente', 'aprovado']))
                                <form action="{{ route('pedidos.cancelar', $pedido) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded" onclick="return confirm('Cancelar este pedido?')">Cancelar</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Informações do Cliente -->
                        <div>
                            <h3 class="text-lg font-semibold mb-3">Dados do Cliente</h3>
                            <div class="bg-gray-50 p-4 rounded">
                                <p><strong>Nome:</strong> {{ $pedido->cliente->nome }}</p>
                                <p><strong>CPF:</strong> {{ $pedido->cliente->cpf }}</p>
                                <p><strong>Telefone:</strong> {{ $pedido->cliente->telefone1 }}</p>
                                <p><strong>Email:</strong> {{ $pedido->cliente->email ?? 'Não informado' }}</p>
                                
                            </div>
                        </div>

                    
                        <!-- Informações do Pedido -->
                        <div>
                            <h3 class="text-lg font-semibold mb-3">Dados do Pedido</h3>
                            <div class="bg-gray-50 p-4 rounded">
                                <p><strong>Data do Pedido:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                                <p><strong>Data Entrega:</strong> {{ \Carbon\Carbon::parse($pedido->data_entrega)->format('d/m/Y H:i') }}</p>
                                <p><strong>Data Devolução:</strong> {{ \Carbon\Carbon::parse($pedido->data_devolucao)->format('d/m/Y H:i') }}</p>
                                <p><strong>Dias Totais:</strong> {{ $pedido->dias_totais }} dias</p>
                                <p><strong>Forma Pagamento:</strong> {{ ucfirst($pedido->forma_pagamento) }}</p>
                                <p><strong>Observações:</strong> {{ $pedido->observacoes ?? 'Nenhuma' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Itens do Pedido -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold mb-3">Itens do Pedido</h3>
                        <table class="min-w-full divide-y divide-gray-200 border">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left">Equipamento</th>
                                    <th class="px-4 py-2 text-center">Quantidade</th>
                                    <th class="px-4 py-2 text-right">Preço Unitário</th>
                                    <th class="px-4 py-2 text-right">Subtotal</th>
                                    <th class="px-4 py-2 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pedido->itens as $item)
                                <tr class="border-t">
                                    <td class="px-4 py-2">{{ $item->equipamento->nome }}</td>
                                    <td class="px-4 py-2 text-center">{{ $item->quantidade }}</td>
                                    <td class="px-4 py-2 text-right">R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-right">R$ {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-center">
                                        @if($item->devolvido)
                                            <span class="text-green-600">Devolvido em {{ \Carbon\Carbon::parse($item->data_devolucao)->format('d/m/Y H:i') }}</span>
                                        @else
                                            <span class="text-yellow-600">Pendente</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr class="border-t">
                                    <td colspan="3" class="px-4 py-2 text-right font-bold">Subtotal:</td>
                                    <td class="px-4 py-2 text-right font-bold">R$ {{ number_format($pedido->subtotal, 2, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="px-4 py-2 text-right font-bold">Desconto:</td>
                                    <td class="px-4 py-2 text-right font-bold">R$ {{ number_format($pedido->desconto, 2, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="px-4 py-2 text-right font-bold text-lg">TOTAL:</td>
                                    <td class="px-4 py-2 text-right font-bold text-lg">R$ {{ number_format($pedido->total, 2, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                                                <!-- Seção: Endereço de Entrega -->
                            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">📍 Endereço de Entrega</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p><strong>CEP:</strong> {{ $pedido->cep_entrega ?? 'Não informado' }}</p>
                                        <p><strong>Logradouro:</strong> {{ $pedido->logradouro_entrega ?? 'Não informado' }}</p>
                                        <p><strong>Número:</strong> {{ $pedido->numero_entrega ?? 'Não informado' }}</p>
                                        <p><strong>Complemento:</strong> {{ $pedido->complemento_entrega ?? 'Não informado' }}</p>
                                    </div>
                                    <div>
                                        <p><strong>Bairro:</strong> {{ $pedido->bairro_entrega ?? 'Não informado' }}</p>
                                        <p><strong>Cidade:</strong> {{ $pedido->cidade_entrega ?? 'Não informado' }}</p>
                                        <p><strong>UF:</strong> {{ $pedido->uf_entrega ?? 'Não informado' }}</p>
                                    </div>
                                </div>
                            </div>

                   <!-- Mapa do Waze -->
<!-- Mapa e Localização -->
@if($pedido->latitude && $pedido->longitude)
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
    <div class="p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">🗺️ Mapa de Localização (Waze)</h3>
        <div class="aspect-w-16 aspect-h-9">
            <iframe 
                src="https://embed.waze.com/iframe?zoom=15&lat={{ $pedido->latitude }}&lon={{ $pedido->longitude }}&pin=1"
                width="100%"
                height="450"
                style="border:0;"
                allowfullscreen>
            </iframe>
        </div>
        <div class="mt-4 flex gap-3">
            <!-- ✅ Link corrigido do Waze -->
            <a href="https://www.waze.com/ul?ll={{ $pedido->latitude }},{{ $pedido->longitude }}&navigate=yes" 
               target="_blank" 
               rel="noopener noreferrer"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Abrir no Waze
            </a>
            @if($pedido->localizacao && !str_contains($pedido->localizacao, 'waze.com'))
            <a href="{{ $pedido->localizacao }}" 
               target="_blank" 
               rel="noopener noreferrer"
               class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                </svg>
                Abrir no Google Maps
            </a>
            @endif
        </div>
        <p class="text-sm text-gray-500 mt-3">
            📍 O alfinete indica o local aproximado da entrega. Clique no botão para abrir o trajeto no Waze.
        </p>
    </div>
</div>
@elseif($pedido->localizacao)
<!-- Fallback: Apenas o link, sem mapa -->
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
    <div class="p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">🗺️ Localização da Entrega</h3>
        <div class="flex gap-3">
            @if(str_contains($pedido->localizacao, 'waze.com'))
                <a href="{{ $pedido->localizacao }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Abrir no Waze
                </a>
            @else
                <a href="{{ $pedido->localizacao }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                    </svg>
                    Abrir no Google Maps
                </a>
            @endif
        </div>
        <p class="text-sm text-gray-500 mt-3">
            📍 Clique no botão para visualizar a rota no aplicativo de mapas.
        </p>
    </div>
</div>
@endif


                    
                    <div class="flex justify-end gap-3 mt-6">
                        <a href="{{ route('pedidos.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Voltar
                        </a>
                        <a href="{{ route('pedidos.edit', $pedido) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            Editar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>