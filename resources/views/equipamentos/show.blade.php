<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalhes do Equipamento') }}: {{ $equipamento->nome }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Informações Gerais</h3>
                            <table class="w-full">
                                <tr class="border-b">
                                    <td class="py-2 font-medium">ID:</td>
                                    <td class="py-2">{{ $equipamento->id }}</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-2 font-medium">Nome:</td>
                                    <td class="py-2">{{ $equipamento->nome }}</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-2 font-medium">Categoria:</td>
                                    <td class="py-2">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $equipamento->categoria }}
                                        </span>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-2 font-medium">Marca/Modelo:</td>
                                    <td class="py-2">{{ $equipamento->marca }} {{ $equipamento->modelo }}</td>
                                </tr>
<!-- Status -->
<tr class="border-b">
    <td class="py-2 font-medium">Status:</td>
    <td class="py-2">
        @php
            $statusColors = [
                'Disponível' => 'green',
                'Alugado' => 'blue',
                'Manutenção' => 'yellow',
                'Vendido' => 'gray',
            ];
            $statusIcons = [
                'Disponível' => '✅',
                'Alugado' => '🔄',
                'Manutenção' => '🔧',
                'Vendido' => '💰',
            ];
            $color = $statusColors[$equipamento->status] ?? 'gray';
            $icon = $statusIcons[$equipamento->status] ?? '❓';
        @endphp
        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $color }}-100 text-{{ $color }}-800">
            {{ $icon }} {{ $equipamento->status }}
        </span>
    </td>
</tr>
                            </table>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Preços e Valores</h3>
                            <table class="w-full">
                                <tr class="border-b">
                                    <td class="py-2 font-medium">Diária:</td>
                                    <td class="py-2">R$ {{ number_format($equipamento->preco_diaria, 2, ',', '.') }}</td>
                                </tr>
                                @if($equipamento->preco_semanal)
                                <tr class="border-b">
                                    <td class="py-2 font-medium">Semanal:</td>
                                    <td class="py-2">R$ {{ number_format($equipamento->preco_semanal, 2, ',', '.') }}</td>
                                </tr>
                                @endif
                                @if($equipamento->preco_mensal)
                                <tr class="border-b">
                                    <td class="py-2 font-medium">Mensal:</td>
                                    <td class="py-2">R$ {{ number_format($equipamento->preco_mensal, 2, ',', '.') }}</td>
                                </tr>
                                @endif
                                <!-- @if($equipamento->caucao)
                                <tr class="border-b">
                                    <td class="py-2 font-medium">Caução:</td>
                                    <td class="py-2">R$ {{ number_format($equipamento->caucao, 2, ',', '.') }}</td>
                                </tr> -->
                                @endif
                                @if($equipamento->valor_aquisicao)
                                <tr class="border-b">
                                    <td class="py-2 font-medium">Valor de Aquisição:</td>
                                    <td class="py-2">R$ {{ number_format($equipamento->valor_aquisicao, 2, ',', '.') }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        
                        @if($equipamento->especificacoes)
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-semibold mb-2">Especificações Técnicas</h3>
                            <div class="bg-gray-50 p-4 rounded">
                                {{ $equipamento->especificacoes }}
                            </div>
                        </div>
                        @endif
                        
                        @if($equipamento->observacoes)
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-semibold mb-2">Observações</h3>
                            <div class="bg-gray-50 p-4 rounded">
                                {{ $equipamento->observacoes }}
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <div class="flex justify-end gap-3 mt-6">
                        <a href="{{ route('equipamentos.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Voltar
                        </a>
                        <a href="{{ route('equipamentos.edit', $equipamento) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            Editar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>