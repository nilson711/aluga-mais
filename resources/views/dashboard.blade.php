<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

                <!-- Listas de Entregas e Devoluções -->
            <!-- Listas de Entregas e Devoluções -->
<!-- Próximas Entregas (card inteiro clicável) -->
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <h3 class="text-blue-900 font-bold mb-4 text-lg">📦 Próximas Entregas</h3>
        <div class="space-y-3">
            @forelse($proximasEntregas ?? [] as $entrega)
                <a href="{{ route('pedidos.show', $entrega) }}" class="block">
                    <div class="bg-blue-50 p-3 rounded-lg border-l-4 border-blue-300 hover:bg-blue-100 transition cursor-pointer">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-bold text-gray-800">{{ $entrega->cliente->nome }}</p>
                                <!-- ✅ Adicionado Bairro -->
                                <p class="text-sm text-gray-600">
                                    📍 {{ $entrega->bairro_entrega ?? 'Bairro não informado' }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    📅 {{ \Carbon\Carbon::parse($entrega->data_entrega)->format('d/m/Y H:i') }} - 
                                    📦 {{ $entrega->itens->sum('quantidade') }} itens
                                </p>
                            </div>
                            <div>
                                @php
                                    $statusColors = [
                                        'pendente' => 'yellow',
                                        'aprovado' => 'blue',
                                        'entregue' => 'purple',
                                        'devolvido' => 'green',
                                        'cancelado' => 'red',
                                    ];
                                    $statusLabels = [
                                        'pendente' => 'Pendente',
                                        'aprovado' => 'Aprovado',
                                        'entregue' => 'Entregue',
                                        'devolvido' => 'Devolvido',
                                        'cancelado' => 'Cancelado',
                                    ];
                                    $color = $statusColors[$entrega->status] ?? 'gray';
                                    $label = $statusLabels[$entrega->status] ?? ucfirst($entrega->status);
                                @endphp
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $color }}-100 text-{{ $color }}-800">
                                    {{ $label }}
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="bg-gray-50 p-3 rounded-lg text-center text-gray-500">
                    Nenhuma entrega programada para os próximos dias.
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Próximas Devoluções (card inteiro clicável) -->
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <h3 class="text-blue-900 font-bold mb-4 text-lg">🔄 Próximas Devoluções</h3>
        <div class="space-y-3">
            @forelse($proximasDevolucoes ?? [] as $devolucao)
                <a href="{{ route('pedidos.show', $devolucao) }}" class="block">
                    <div class="bg-green-50 p-3 rounded-lg border-l-4 border-green-300 hover:bg-green-100 transition cursor-pointer">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-bold text-gray-800">{{ $devolucao->cliente->nome }}</p>
                                <!-- ✅ Adicionado Bairro -->
                                <p class="text-sm text-gray-600">
                                    📍 {{ $devolucao->bairro_entrega ?? 'Bairro não informado' }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    📅 {{ \Carbon\Carbon::parse($devolucao->data_devolucao)->format('d/m/Y H:i') }} - 
                                    📦 {{ $devolucao->itens->sum('quantidade') }} itens
                                </p>
                            </div>
                            <div>
                                @php
                                    $statusColors = [
                                        'pendente' => 'yellow',
                                        'aprovado' => 'blue',
                                        'entregue' => 'purple',
                                        'devolvido' => 'green',
                                        'cancelado' => 'red',
                                    ];
                                    $statusLabels = [
                                        'pendente' => 'Pendente',
                                        'aprovado' => 'Aprovado',
                                        'entregue' => 'Entregue',
                                        'devolvido' => 'Devolvido',
                                        'cancelado' => 'Cancelado',
                                    ];
                                    $color = $statusColors[$devolucao->status] ?? 'gray';
                                    $label = $statusLabels[$devolucao->status] ?? ucfirst($devolucao->status);
                                @endphp
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $color }}-100 text-{{ $color }}-800">
                                    {{ $label }}
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="bg-gray-50 p-3 rounded-lg text-center text-gray-500">
                    Nenhuma devolução programada para os próximos dias.
                </div>
            @endforelse
        </div>
    </div>
</div>

            <!-- Pedidos Recentes -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-blue-900 font-bold mb-4 text-lg">📋 Pedidos Recentes</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pedido</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($pedidosRecentes ?? [] as $pedido)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">#{{ $pedido->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $pedido->cliente->nome }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">R$ {{ number_format($pedido->total, 2, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('pedidos.show', $pedido) }}" class="text-blue-600 hover:text-blue-900">Ver</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        Nenhum pedido encontrado.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>