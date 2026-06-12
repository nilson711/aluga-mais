<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalhes do Cliente') }}: {{ $cliente->nome }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Informações do Cadastro - Ultra Compacta -->
            <div class="mt-4 text-xs text-gray-500 border-t pt-3">
                <div class="flex flex-wrap gap-x-4 gap-y-1 justify-end">
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Criado por: <span class="font-medium text-gray-700">{{ $cliente->user->name ?? '—' }}</span>
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        em: {{ $cliente->created_at->format('d/m/Y H:i') }}
                    </span>
                    @if($cliente->created_at != $cliente->updated_at)
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        editado: {{ $cliente->updated_at->format('d/m/Y H:i') }}
                    </span>
                    @endif
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Informações Pessoais -->
                        <div>
                            
                            <h3 class="text-lg font-semibold mb-4">Informações Pessoais</h3>
                            <div class="bg-gray-50 p-4 rounded">
                                <table class="w-full">
                                    <tr class="border-b">
                                        <td class="py-2 font-medium">Nome:</td>
                                        <td class="py-2">{{ $cliente->nome }}</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-2 font-medium">CPF:</td>
                                        <td class="py-2">{{ $cliente->cpf }}</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-2 font-medium">E-mail:</td>
                                        <td class="py-2">{{ $cliente->email ?? 'Não informado' }}</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-2 font-medium">Telefone Principal:</td>
                                        <td class="py-2">{{ $cliente->telefone1 }}</td>
                                    </tr>
                                    @if($cliente->telefone2)
                                    <tr class="border-b">
                                        <td class="py-2 font-medium">Telefone Alternativo:</td>
                                        <td class="py-2">{{ $cliente->telefone2 }}</td>
                                    </tr>
                                    @endif
                                    <tr class="border-b">
                                        <td class="py-2 font-medium">Status:</td>
                                        <td class="py-2">
                                            @if($cliente->ativo)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Ativo
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Inativo
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 font-medium">Cadastrado em:</td>
                                        <td class="py-2">{{ $cliente->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Endereço -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Endereço</h3>
                            <div class="bg-gray-50 p-4 rounded">
                                <table class="w-full">
                                    <tr class="border-b">
                                        <td class="py-2 font-medium">CEP:</td>
                                        <td class="py-2">{{ $cliente->cep }}</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-2 font-medium">Logradouro:</td>
                                        <td class="py-2">{{ $cliente->logradouro }}</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-2 font-medium">Número:</td>
                                        <td class="py-2">{{ $cliente->numero }}</td>
                                    </tr>
                                    @if($cliente->complemento)
                                    <tr class="border-b">
                                        <td class="py-2 font-medium">Complemento:</td>
                                        <td class="py-2">{{ $cliente->complemento }}</td>
                                    </tr>
                                    @endif
                                    <tr class="border-b">
                                        <td class="py-2 font-medium">Bairro:</td>
                                        <td class="py-2">{{ $cliente->bairro }}</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-2 font-medium">Cidade/UF:</td>
                                        <td class="py-2">{{ $cliente->cidade }}/{{ $cliente->uf }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Observações -->
                        @if($cliente->observacoes)
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-semibold mb-2">Observações</h3>
                            <div class="bg-gray-50 p-4 rounded">
                                {{ $cliente->observacoes }}
                            </div>
                        </div>
                        @endif
                        
                        <!-- Histórico de Pedidos -->
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-semibold mb-4">Histórico de Pedidos</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 border">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left">Pedido</th>
                                            <th class="px-4 py-2 text-left">Data</th>
                                            <th class="px-4 py-2 text-left">Entrega</th>
                                            <th class="px-4 py-2 text-left">Devolução</th>
                                            <th class="px-4 py-2 text-right">Total</th>
                                            <th class="px-4 py-2 text-center">Status</th>
                                            <th class="px-4 py-2 text-center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($cliente->pedidos as $pedido)
                                        <tr class="border-t">
                                            <td class="px-4 py-2">#{{ $pedido->id }}</td>
                                            <td class="px-4 py-2">{{ $pedido->created_at->format('d/m/Y') }}</td>
                                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($pedido->data_entrega)->format('d/m/Y') }}</td>
                                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($pedido->data_devolucao)->format('d/m/Y') }}</td>
                                            <td class="px-4 py-2 text-right">R$ {{ number_format($pedido->total, 2, ',', '.') }}</td>
                                            <td class="px-4 py-2 text-center">
                                                @php
                                                    $statusColors = [
                                                        'pendente' => 'yellow',
                                                        'aprovado' => 'blue',
                                                        'retirado' => 'purple',
                                                        'devolvido' => 'green',
                                                        'cancelado' => 'red',
                                                    ];
                                                    $color = $statusColors[$pedido->status] ?? 'gray';
                                                @endphp
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $color }}-100 text-{{ $color }}-800">
                                                    {{ ucfirst($pedido->status) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2 text-center">
                                                <a href="{{ route('pedidos.show', $pedido) }}" class="text-blue-600 hover:text-blue-900">
                                                    Ver Pedido
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="px-4 py-4 text-center text-gray-500">
                                                Nenhum pedido encontrado para este cliente.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end gap-3 mt-6">
                        <a href="{{ route('clientes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Voltar
                        </a>
                        <a href="{{ route('clientes.edit', $cliente) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            Editar Cliente
                        </a>
                        <a href="{{ route('pedidos.create') }}?cliente_id={{ $cliente->id }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Novo Pedido
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>