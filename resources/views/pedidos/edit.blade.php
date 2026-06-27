<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Pedido') }} #{{ $pedido->id }}
        </h2>
    </x-slot>

    <!-- CSS do Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('pedidos.update', $pedido) }}" method="POST" id="pedidoForm">
                        @csrf
                        @method('PUT')

                        <!-- Seção: Dados do Cliente e Datas -->
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                                <!-- Cliente (4 colunas) -->
                                <div class="md:col-span-4">
                                    <div class="flex justify-between items-center mb-1">
                                        <label class="block text-sm font-medium text-gray-700">Cliente *</label>
                                        <a href="{{ route('clientes.create') }}" target="_blank" class="text-xs text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Novo Cliente
                                        </a>
                                    </div>
                                    <select name="cliente_id" id="cliente_id" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Selecione ou digite o nome do cliente...</option>
                                        @foreach($clientes as $cliente)
                                            <option value="{{ $cliente->id }}" {{ old('cliente_id', $pedido->cliente_id) == $cliente->id ? 'selected' : '' }}>
                                                {{ $cliente->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cliente_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                
                                <!-- Data Entrega (2 colunas) -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Data Entrega *</label>
                                    <input type="date" name="data_entrega_date" id="data_entrega_date" 
                                        value="{{ old('data_entrega_date', \Carbon\Carbon::parse($pedido->data_entrega)->format('Y-m-d')) }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                
                                <!-- Hora Entrega (2 colunas) -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Hora Entrega *</label>
                                    <select name="data_entrega_time" id="data_entrega_time" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        @php
                                            $start = strtotime('08:00');
                                            $end = strtotime('22:00');
                                            $horaEntregaSelecionada = old('data_entrega_time', \Carbon\Carbon::parse($pedido->data_entrega)->format('H:i'));
                                        @endphp
                                        <option value="">Selecione...</option>
                                        @for ($time = $start; $time <= $end; $time += 1800)
                                            <option value="{{ date('H:i', $time) }}" {{ $horaEntregaSelecionada == date('H:i', $time) ? 'selected' : '' }}>
                                                {{ date('H:i', $time) }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                
                                <!-- Data Devolução (2 colunas) -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Data Devolução *</label>
                                    <input type="date" name="data_devolucao_date" id="data_devolucao_date" 
                                        value="{{ old('data_devolucao_date', \Carbon\Carbon::parse($pedido->data_devolucao)->format('Y-m-d')) }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                
                                <!-- Hora Devolução (2 colunas) -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Hora Devolução *</label>
                                    <select name="data_devolucao_time" id="data_devolucao_time" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        @php
                                            $horaDevolucaoSelecionada = old('data_devolucao_time', \Carbon\Carbon::parse($pedido->data_devolucao)->format('H:i'));
                                        @endphp
                                        @for ($time = $start; $time <= $end; $time += 1800)
                                            <option value="{{ date('H:i', $time) }}" {{ $horaDevolucaoSelecionada == date('H:i', $time) ? 'selected' : '' }}>
                                                {{ date('H:i', $time) }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                
                                <!-- Campos hidden -->
                                <input type="hidden" name="data_entrega" id="data_entrega_combined" value="{{ $pedido->data_entrega }}">
                                <input type="hidden" name="data_devolucao" id="data_devolucao_combined" value="{{ $pedido->data_devolucao }}">
                            </div>
                        </div>

                        <!-- Seção: Endereço de Entrega -->
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-gray-800">📍 Endereço de Entrega</h3>
                                <button type="button" id="copiarEnderecoCliente" class="text-sm bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1 rounded-lg transition flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                                    </svg>
                                    Copiar endereço do cliente
                                </button>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                                <div class="md:col-span-3">
                                    <label class="block text-sm font-medium text-gray-700">CEP *</label>
                                    <input type="text" name="cep_entrega" id="cep_entrega" value="{{ old('cep_entrega', $pedido->cep_entrega) }}"
                                        placeholder="12345-678"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('cep_entrega') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="md:col-span-7">
                                    <label class="block text-sm font-medium text-gray-700">Logradouro *</label>
                                    <input type="text" name="logradouro_entrega" id="logradouro_entrega" value="{{ old('logradouro_entrega', $pedido->logradouro_entrega) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('logradouro_entrega') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Número *</label>
                                    <input type="text" name="numero_entrega" id="numero_entrega" value="{{ old('numero_entrega', $pedido->numero_entrega) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('numero_entrega') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="md:col-span-12">
                                    <label class="block text-sm font-medium text-gray-700">Complemento</label>
                                    <input type="text" name="complemento_entrega" id="complemento_entrega" value="{{ old('complemento_entrega', $pedido->complemento_entrega) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('complemento_entrega') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="md:col-span-4">
                                    <label class="block text-sm font-medium text-gray-700">Bairro *</label>
                                    <input type="text" name="bairro_entrega" id="bairro_entrega" value="{{ old('bairro_entrega', $pedido->bairro_entrega) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('bairro_entrega') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="md:col-span-6">
                                    <label class="block text-sm font-medium text-gray-700">Cidade *</label>
                                    <input type="text" name="cidade_entrega" id="cidade_entrega" value="{{ old('cidade_entrega', $pedido->cidade_entrega) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('cidade_entrega') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">UF *</label>
                                    <select name="uf_entrega" id="uf_entrega"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Selecione...</option>
                                        @foreach(['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'] as $uf)
                                            <option value="{{ $uf }}" {{ old('uf_entrega', $pedido->uf_entrega) == $uf ? 'selected' : '' }}>{{ $uf }}</option>
                                        @endforeach
                                    </select>
                                    @error('uf_entrega') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Link de Localização -->
                                <div class="md:col-span-12">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Link de Localização (Waze) <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex gap-2">
                                        <input type="text" name="localizacao" id="localizacao" value="{{ old('localizacao', $pedido->localizacao ?? '') }}"
                                            placeholder="https://waze.com/ul?ll=-15.12345,-47.12345&navigate=yes"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            required>
                                        <button type="button" id="gerarLocalizacao" class="mt-1 bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded whitespace-nowrap">
                                            📍 Gerar
                                        </button>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">
                                        Clique em "Gerar" para criar o link automaticamente baseado no endereço de entrega.
                                    </p>
                                    @error('localizacao') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $pedido->latitude ?? '') }}">
                                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $pedido->longitude ?? '') }}">
                            </div>
                        </div>

                        <!-- Seção: Itens do Pedido -->
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">📦 Itens do Pedido</h3>
                            
                            <div id="itens-container" class="space-y-3">
                                @foreach($pedido->itens as $index => $item)
                                <div class="item-row grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                                    <div class="md:col-span-5">
                                        <label class="block text-sm font-medium text-gray-700">Equipamento</label>
                                        <select name="itens[{{ $index }}][equipamento_id]" class="equipamento-select w-full rounded-md border-gray-300" required>
                                            <option value="">Selecione...</option>
                                            @foreach($equipamentos as $equipamento)
                                                <option value="{{ $equipamento->id }}" 
                                                    data-preco="{{ $equipamento->preco_diaria }}"
                                                    {{ old("itens.$index.equipamento_id", $item->equipamento_id) == $equipamento->id ? 'selected' : '' }}>
                                                    {{ $equipamento->nome }} ({{ $equipamento->numero_patrimonio ?? 'N/S' }}) - R$ {{ number_format($equipamento->preco_diaria, 2, ',', '.') }}/dia
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Quantidade</label>
                                        <input type="number" name="itens[{{ $index }}][quantidade]" class="quantidade w-full rounded-md border-gray-300" value="{{ old("itens.$index.quantidade", $item->quantidade) }}" min="1" required>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Preço Unitário</label>
                                        <input type="text" name="itens[{{ $index }}][preco_unitario]" class="preco-unitario w-full rounded-md border-gray-300 bg-gray-100" value="{{ old("itens.$index.preco_unitario", $item->preco_unitario) }}" readonly>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Subtotal</label>
                                        <input type="text" class="subtotal w-full rounded-md border-gray-300 bg-gray-100" value="R$ {{ number_format($item->subtotal, 2, ',', '.') }}" readonly>
                                    </div>
                                    <div class="md:col-span-1">
                                        <button type="button" class="remove-item w-full bg-red-500 text-white px-3 py-2 rounded hover:bg-red-700 transition">Remover</button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <button type="button" id="add-item" class="mt-4 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700 transition flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Adicionar Item
                            </button>
                        </div>
                        
                        <!-- Seção: Totais -->
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">💰 Totais</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Coluna Direita: Forma de Pagamento, CPF e CNPJ -->
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Forma de Pagamento *</label>
                                        <select name="forma_pagamento" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <option value="">Selecione...</option>
                                            <option value="dinheiro" {{ old('forma_pagamento', $pedido->forma_pagamento) == 'dinheiro' ? 'selected' : '' }}>Dinheiro</option>
                                            <option value="pix" {{ old('forma_pagamento', $pedido->forma_pagamento) == 'pix' ? 'selected' : '' }}>PIX</option>
                                            <option value="cartao_credito" {{ old('forma_pagamento', $pedido->forma_pagamento) == 'cartao_credito' ? 'selected' : '' }}>Cartão de Crédito</option>
                                            <option value="cartao_debito" {{ old('forma_pagamento', $pedido->forma_pagamento) == 'cartao_debito' ? 'selected' : '' }}>Cartão de Débito</option>
                                            <option value="boleto" {{ old('forma_pagamento', $pedido->forma_pagamento) == 'boleto' ? 'selected' : '' }}>Boleto</option>
                                        </select>
                                        @error('forma_pagamento') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">CPF</label>
                                        <input type="text" name="cpf_pedido" id="cpf_pedido" value="{{ old('cpf_pedido', $pedido->cpf_pedido ?? '') }}"
                                            placeholder="111.111.111-11"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        @error('cpf_pedido') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">CNPJ</label>
                                        <input type="text" name="cnpj_pedido" id="cnpj_pedido" value="{{ old('cnpj_pedido', $pedido->cnpj_pedido ?? '') }}"
                                            placeholder="12.345.678/0001-90"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        @error('cnpj_pedido') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <!-- Coluna Esquerda: Totais -->
                                <div class="space-y-2">
                                    <div class="flex justify-between items-center pb-2 border-b">
                                        <span class="font-medium text-gray-600">Subtotal:</span>
                                        <span id="subtotal-display" class="text-lg font-semibold">R$ {{ number_format($pedido->subtotal, 2, ',', '.') }}</span>
                                    </div>
                                    
                                    <div class="flex justify-between items-center pb-2 border-b">
                                        <span class="font-medium text-gray-600">Taxa de Entrega (R$):</span>
                                        <input type="number" name="taxa_entrega" id="taxa_entrega" value="{{ old('taxa_entrega', $pedido->taxa_entrega) }}" step="0.01" 
                                            class="w-32 text-right border rounded px-2 py-1">
                                    </div>
                                    
                                    <div class="flex justify-between items-center pb-2 border-b">
                                        <span class="font-medium text-gray-600">Desconto (R$):</span>
                                        <input type="number" name="desconto" id="desconto" value="{{ old('desconto', $pedido->desconto) }}" step="0.01" 
                                            class="w-32 text-right border rounded px-2 py-1">
                                    </div>
                                    
                                    <div class="flex justify-between items-center pb-2 border-b">
                                        <span class="font-medium text-gray-600">Entrada (50%):</span>
                                        <span id="caucao-display" class="text-lg font-semibold text-orange-600">R$ 0,00</span>
                                    </div>
                                    
                                    <div class="flex justify-between items-center pt-2">
                                        <span class="font-bold text-lg text-gray-800">TOTAL:</span>
                                        <span id="total-display" class="text-2xl font-bold text-blue-600">R$ {{ number_format($pedido->total, 2, ',', '.') }}</span>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                        <!-- Observações -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700">Observações</label>
                            <textarea name="observacoes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Informações adicionais sobre o pedido...">{{ old('observacoes', $pedido->observacoes) }}</textarea>
                        </div>
                        
                        <!-- Botões -->
                        <div class="flex justify-end gap-3 mt-6 pt-4 border-t">
                            <a href="{{ route('pedidos.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-8 rounded transition inline-block">
                                Cancelar
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-8 rounded transition">
                                Atualizar Pedido
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- jQuery e Select2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    // ============================================
    // INICIALIZAÇÃO DO SELECT2
    // ============================================
    $('#cliente_id').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Selecione ou digite o nome do cliente...',
        allowClear: true,
        language: {
            noResults: function() {
                return "Nenhum cliente encontrado";
            }
        }
    });
    
    // ============================================
    // CARREGAR ENDEREÇO DO CLIENTE
    // ============================================
    function carregarEnderecoCliente(clienteId) {
        if (!clienteId) return;
        
        fetch(`/clientes/${clienteId}/endereco`)
            .then(response => response.json())
            .then(data => {
                if (data) {
                    document.getElementById('cep_entrega').value = data.cep || '';
                    document.getElementById('logradouro_entrega').value = data.logradouro || '';
                    document.getElementById('numero_entrega').value = data.numero || '';
                    document.getElementById('complemento_entrega').value = data.complemento || '';
                    document.getElementById('bairro_entrega').value = data.bairro || '';
                    document.getElementById('cidade_entrega').value = data.cidade || '';
                    document.getElementById('uf_entrega').value = data.uf || '';
                }
            })
            .catch(error => console.error('Erro ao carregar endereço:', error));
    }
    
    $('#cliente_id').on('change', function() {
        const clienteId = $(this).val();
        if (clienteId) {
            carregarEnderecoCliente(clienteId);
        }
    });
    
    // ============================================
    // BOTÃO COPIAR ENDEREÇO
    // ============================================
    document.getElementById('copiarEnderecoCliente')?.addEventListener('click', function() {
        const clienteId = document.getElementById('cliente_id').value;
        if (clienteId) {
            carregarEnderecoCliente(clienteId);
            this.classList.add('bg-green-200');
            setTimeout(() => {
                this.classList.remove('bg-green-200');
            }, 2000);
        } else {
            alert('Selecione um cliente primeiro.');
        }
    });
    
    // ============================================
    // CÁLCULOS DOS ITENS
    // ============================================
    
    function calcularDias() {
        const entregaDate = document.getElementById('data_entrega_date')?.value;
        const entregaTime = document.getElementById('data_entrega_time')?.value;
        const devolucaoDate = document.getElementById('data_devolucao_date')?.value;
        const devolucaoTime = document.getElementById('data_devolucao_time')?.value;
        
        if (!entregaDate || !entregaTime || !devolucaoDate || !devolucaoTime) {
            return 1;
        }
        
        const entrega = new Date(`${entregaDate}T${entregaTime}:00`);
        const devolucao = new Date(`${devolucaoDate}T${devolucaoTime}:00`);
        
        if (devolucao > entrega) {
            const diffTime = Math.abs(devolucao - entrega);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            return Math.max(diffDays, 1);
        }
        return 1;
    }
    
    function atualizarPrecoUnitario(row) {
        const select = row.querySelector('.equipamento-select');
        const precoDisplay = row.querySelector('.preco-unitario');
        
        if (!select || !precoDisplay) return;
        
        const selectedOption = select.options[select.selectedIndex];
        const precoDiaria = parseFloat(selectedOption?.getAttribute('data-preco')) || 0;
        const dias = calcularDias();
        
        if (precoDiaria > 0 && dias > 0) {
            precoDisplay.value = (precoDiaria * dias).toFixed(2);
        } else {
            precoDisplay.value = '';
        }
        
        atualizarTotais();
    }
    
    function atualizarTotais() {
        let subtotal = 0;
        
        document.querySelectorAll('.item-row').forEach(row => {
            const quantidade = parseFloat(row.querySelector('.quantidade')?.value) || 0;
            const precoUnitario = parseFloat(row.querySelector('.preco-unitario')?.value) || 0;
            const subtotalItem = quantidade * precoUnitario;
            
            const subtotalField = row.querySelector('.subtotal');
            if (subtotalField) {
                subtotalField.value = 'R$ ' + subtotalItem.toFixed(2).replace('.', ',');
            }
            subtotal += subtotalItem;
        });
        
        const taxaEntrega = parseFloat(document.getElementById('taxa_entrega')?.value) || 0;
        const desconto = parseFloat(document.getElementById('desconto')?.value) || 0;
        const total = subtotal + taxaEntrega - desconto;
        const caucao = total * 0.5;
        
        const subtotalDisplay = document.getElementById('subtotal-display');
        const totalDisplay = document.getElementById('total-display');
        const caucaoDisplay = document.getElementById('caucao-display');
        
        if (subtotalDisplay) {
            subtotalDisplay.innerHTML = 'R$ ' + subtotal.toFixed(2).replace('.', ',');
        }
        if (totalDisplay) {
            totalDisplay.innerHTML = 'R$ ' + total.toFixed(2).replace('.', ',');
        }
        if (caucaoDisplay) {
            caucaoDisplay.innerHTML = 'R$ ' + caucao.toFixed(2).replace('.', ',');
        }
    }
    
    function adicionarEventosItem(row) {
        const select = row.querySelector('.equipamento-select');
        const quantidade = row.querySelector('.quantidade');
        
        if (select) {
            select.addEventListener('change', function() {
                atualizarPrecoUnitario(row);
            });
        }
        
        if (quantidade) {
            quantidade.addEventListener('input', function() {
                atualizarPrecoUnitario(row);
            });
        }
        
        const removeBtn = row.querySelector('.remove-item');
        if (removeBtn) {
            removeBtn.addEventListener('click', function() {
                if (document.querySelectorAll('.item-row').length > 1) {
                    row.remove();
                    atualizarTotais();
                }
            });
        }
    }
    
    function atualizarTodosPrecos() {
        document.querySelectorAll('.item-row').forEach(row => {
            atualizarPrecoUnitario(row);
        });
    }
    
    // Eventos de data
    const dataEntregaDate = document.getElementById('data_entrega_date');
    const dataEntregaTime = document.getElementById('data_entrega_time');
    const dataDevolucaoDate = document.getElementById('data_devolucao_date');
    const dataDevolucaoTime = document.getElementById('data_devolucao_time');
    
    if (dataEntregaDate) dataEntregaDate.addEventListener('change', atualizarTodosPrecos);
    if (dataEntregaTime) dataEntregaTime.addEventListener('change', atualizarTodosPrecos);
    if (dataDevolucaoDate) dataDevolucaoDate.addEventListener('change', atualizarTodosPrecos);
    if (dataDevolucaoTime) dataDevolucaoTime.addEventListener('change', atualizarTodosPrecos);
    
    // Adicionar novo item
    let itemCount = {{ count($pedido->itens) }};
    const addItemBtn = document.getElementById('add-item');
    
    if (addItemBtn) {
        addItemBtn.addEventListener('click', function() {
            const container = document.getElementById('itens-container');
            const template = container.children[0];
            const newRow = template.cloneNode(true);
            
            newRow.querySelectorAll('input, select').forEach(el => {
                const name = el.getAttribute('name');
                if (name) {
                    el.setAttribute('name', name.replace(/\[\d+\]/, `[${itemCount}]`));
                }
                if (el.type === 'text' || el.type === 'number') {
                    el.value = '';
                }
                if (el.classList.contains('quantidade')) {
                    el.value = '1';
                }
                if (el.classList.contains('preco-unitario')) {
                    el.value = '';
                }
                if (el.classList.contains('subtotal')) {
                    el.value = '';
                }
            });
            
            const select = newRow.querySelector('.equipamento-select');
            if (select) select.selectedIndex = 0;
            
            container.appendChild(newRow);
            itemCount++;
            adicionarEventosItem(newRow);
        });
    }
    
    // Inicializar eventos
    document.querySelectorAll('.item-row').forEach(row => {
        adicionarEventosItem(row);
    });
    
    // Eventos de taxa e desconto
    const taxaEntrega = document.getElementById('taxa_entrega');
    const desconto = document.getElementById('desconto');
    
    if (taxaEntrega) taxaEntrega.addEventListener('input', atualizarTotais);
    if (desconto) desconto.addEventListener('input', atualizarTotais);
    
    // Máscaras para CPF e CNPJ
    const cpfPedido = document.getElementById('cpf_pedido');
    const cnpjPedido = document.getElementById('cnpj_pedido');
    
    if (cpfPedido) {
        cpfPedido.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 11) value = value.slice(0, 11);
            if (value.length <= 11) {
                value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
            }
            e.target.value = value;
        });
    }
    
    if (cnpjPedido) {
        cnpjPedido.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 14) value = value.slice(0, 14);
            if (value.length <= 14) {
                value = value.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
            }
            e.target.value = value;
        });
    }
    
    // Busca CEP
    const cepEntrega = document.getElementById('cep_entrega');
    if (cepEntrega) {
        cepEntrega.addEventListener('blur', function() {
            let cep = this.value.replace(/\D/g, '');
            if (cep.length === 8) {
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            document.getElementById('logradouro_entrega').value = data.logradouro || '';
                            document.getElementById('bairro_entrega').value = data.bairro || '';
                            document.getElementById('cidade_entrega').value = data.localidade || '';
                            document.getElementById('uf_entrega').value = data.uf || '';
                        }
                    })
                    .catch(error => console.error('Erro ao buscar CEP:', error));
            }
        });
    }
    
    // Combinar data/hora antes de enviar
    function combinarDataHora() {
        const dataEntregaDate = document.getElementById('data_entrega_date')?.value;
        const dataEntregaTime = document.getElementById('data_entrega_time')?.value;
        if (dataEntregaDate && dataEntregaTime) {
            document.getElementById('data_entrega_combined').value = `${dataEntregaDate}T${dataEntregaTime}:00`;
        }
        
        const dataDevolucaoDate = document.getElementById('data_devolucao_date')?.value;
        const dataDevolucaoTime = document.getElementById('data_devolucao_time')?.value;
        if (dataDevolucaoDate && dataDevolucaoTime) {
            document.getElementById('data_devolucao_combined').value = `${dataDevolucaoDate}T${dataDevolucaoTime}:00`;
        }
    }
    
    document.querySelector('form')?.addEventListener('submit', function() {
        combinarDataHora();
    });
    
    // Inicializar totais
    setTimeout(() => {
        atualizarTotais();
    }, 100);
</script>