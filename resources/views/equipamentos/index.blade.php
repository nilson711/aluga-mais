<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Equipamentos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                <div class="flex justify-between mb-4">
                    <a href="{{ route('equipamentos.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        + Novo Equipamento
                    </a>
                    
                    <div class="flex gap-2">
                        <input type="text" id="search" placeholder="Buscar equipamento..." class="border rounded px-3 py-2">
                        <select id="categoria_filter" class="border rounded px-3 py-2">
                            <option value="">Todas categorias</option>
                            <option value="Mesa">Mesa</option>
                            <option value="Cadeira">Cadeira</option>
                            <option value="Refrigeração">Refrigeração</option>
                            <option value="Tenda">Tenda</option>
                            <option value="Climatizador">Climatizador</option>
                            <option value="Outros">Outros</option>
                        </select>
                        <select id="status_filter" class="border rounded px-3 py-2">
                            <option value="">Todos os status</option>
                            <option value="Disponível">✅ Disponível</option>
                            <option value="Alugado">🔄 Alugado</option>
                            <option value="Manutenção">🔧 Manutenção</option>
                            <option value="Vendido">💰 Vendido</option>
                        </select>
                    </div>
                </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <!-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th> -->
                                     <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patrimônio</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoria</th>
                                    <!-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Marca/Modelo</th> -->
                                    <!-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diária</th> -->
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($equipamentos as $equipamento)
                                <tr>
                                    <!-- <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $equipamento->id }}</td> -->
                                     <td class="px-6 py-4 whitespace-nowrap text-sm font-mono">{{ $equipamento->numero_patrimonio ?? '—' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $equipamento->nome }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $equipamento->categoria }}
                                        </span>
                                    </td>
                                    <!-- <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $equipamento->marca }} {{ $equipamento->modelo }}</td> -->
                                    <!-- <td class="px-6 py-4 whitespace-nowrap text-sm">R$ {{ number_format($equipamento->preco_diaria, 2, ',', '.') }}</td> -->

                                    <td class="px-6 py-4 whitespace-nowrap">
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
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $color }}-100 text-{{ $color }}-800">
                                            {{ $icon }} {{ $equipamento->status }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('equipamentos.show', $equipamento) }}" class="text-blue-600 hover:text-blue-900 mr-3">Ver</a>
                                        <a href="{{ route('equipamentos.edit', $equipamento) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Editar</a>
                                        <form action="{{ route('equipamentos.destroy', $equipamento) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Tem certeza que deseja excluir este equipamento?')">
                                                Excluir
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                        Nenhum equipamento cadastrado.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $equipamentos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Função para aplicar os filtros
    function aplicarFiltros() {
        const search = document.getElementById('search').value;
        const categoria = document.getElementById('categoria_filter').value;
        const status = document.getElementById('status_filter').value;
        
        // Construir a URL com os parâmetros
        let url = new URL(window.location.href);
        
        if (search) {
            url.searchParams.set('search', search);
        } else {
            url.searchParams.delete('search');
        }
        
        if (categoria) {
            url.searchParams.set('categoria', categoria);
        } else {
            url.searchParams.delete('categoria');
        }
        
        if (status) {
            url.searchParams.set('status', status);
        } else {
            url.searchParams.delete('status');
        }
        
        // Resetar para página 1 quando filtrar
        url.searchParams.delete('page');
        
        window.location.href = url.toString();
    }
    
    // Debounce para busca ao digitar (espera 500ms após parar de digitar)
    let timeoutId;
    const searchInput = document.getElementById('search');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(aplicarFiltros, 500);
        });
    }
    
    // Aplicar filtros ao mudar categoria
    const categoriaFilter = document.getElementById('categoria_filter');
    if (categoriaFilter) {
        categoriaFilter.addEventListener('change', aplicarFiltros);
    }
    
    // Aplicar filtros ao mudar status
    const statusFilter = document.getElementById('status_filter');
    if (statusFilter) {
        statusFilter.addEventListener('change', aplicarFiltros);
    }
    
    // Preencher os campos com os valores da URL (ao carregar a página)
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        
        const searchValue = urlParams.get('search');
        if (searchValue && searchInput) {
            searchInput.value = searchValue;
        }
        
        const categoriaValue = urlParams.get('categoria');
        if (categoriaValue && categoriaFilter) {
            categoriaFilter.value = categoriaValue;
        }
        
        const statusValue = urlParams.get('status');
        if (statusValue && statusFilter) {
            statusFilter.value = statusValue;
        }
    });
</script>

</x-app-layout>