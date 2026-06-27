<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Novo Pedido') }}
        </h2>

        <!-- CSS do Select2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <!-- CSS de tema (Bootstrap ou Tailwind) -->
        <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

        <!-- jQuery (necessário para Select2) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- JS do Select2 -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        
        <style>
            /* Ajustar altura do Select2 para igualar aos outros campos */
            .select2-container--bootstrap-5 .select2-selection {
                min-height: 42px !important;
                height: 42px !important;
                border-radius: 0.375rem !important;
                border-color: #d1d5db !important;
                background-color: #ffffff !important;
            }
            
            .select2-container--bootstrap-5 .select2-selection__rendered {
                line-height: 40px !important;
                padding-left: 12px !important;
                color: #252711 !important;
            }
            
            .select2-container--bootstrap-5 .select2-selection__arrow {
                height: 40px !important;
            }
            
            .select2-container--bootstrap-5 .select2-selection--single {
                background-color: #ffffff !important;
            }
            
            /* Placeholder do Select2 */
            .select2-container--bootstrap-5 .select2-selection__placeholder {
                color: #6b7280 !important;
            }
            
            /* Focus state */
            .select2-container--bootstrap-5.select2-container--focus .select2-selection {
                border-color: #3b82f6 !important;
                box-shadow: 0 0 0 1px #3b82f6 !important;
                outline: none !important;
            }
            
            /* Dropdown do Select2 */
            .select2-dropdown {
                border-color: #d1d5db !important;
                border-radius: 0.375rem !important;
                z-index: 1050 !important;
            }
            
            /* Opções do dropdown */
            .select2-results__option {
                padding: 8px 12px !important;
            }
            
            .select2-results__option--highlighted {
                background-color: #aecdfe !important;
            }
        </style>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('pedidos.store') }}" method="POST" id="pedidoForm">
                        @csrf

                    <!-- Seção: Dados do Cliente e Datas -->
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                            <!-- Cliente com Select2 -->

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
                                        <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                            {{ $cliente->nome }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cliente_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            
                            <!-- Data Entrega (2 colunas) -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Data Entrega *</label>
                                <input type="date" name="data_entrega_date" id="data_entrega_date" value="{{ old('data_entrega_date') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Hora Entrega (2 colunas) -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Hora Entrega *</label>
                                <select name="data_entrega_time" id="data_entrega_time" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Selecione...</option>
                                    @php
                                        $start = strtotime('08:00');
                                        $end = strtotime('22:00');
                                    @endphp
                                    @for ($time = $start; $time <= $end; $time += 1800)
                                        <option value="{{ date('H:i', $time) }}" {{ old('data_entrega_time') == date('H:i', $time) ? 'selected' : '' }}>
                                            {{ date('H:i', $time) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <!-- Data Devolução (2 colunas) -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Data Devolução *</label>
                                <input type="date" name="data_devolucao_date" id="data_devolucao_date" value="{{ old('data_devolucao_date') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Hora Devolução (2 colunas) -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Hora Devolução *</label>
                                <select name="data_devolucao_time" id="data_devolucao_time" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Selecione...</option>
                                    @for ($time = $start; $time <= $end; $time += 1800)
                                        <option value="{{ date('H:i', $time) }}" {{ old('data_devolucao_time') == date('H:i', $time) ? 'selected' : '' }}>
                                            {{ date('H:i', $time) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            
                            <!-- Campos hidden -->
                            <input type="hidden" name="data_entrega" id="data_entrega_combined">
                            <input type="hidden" name="data_devolucao" id="data_devolucao_combined">
                        </div>
                    </div>

                        <!-- Seção: Endereço de Entrega -->
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-gray-800">📍 Endereço de Entrega</h3>
                                <!-- <button type="button" id="copiarEnderecoCliente" class="text-sm bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1 rounded-lg transition flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                                    </svg>
                                    Copiar endereço do cliente
                                </button> -->
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                                <!-- CEP (3 colunas) -->
                                <div class="md:col-span-3">
                                    <label class="block text-sm font-medium text-gray-700">CEP *</label>
                                    <input type="text" name="cep_entrega" id="cep_entrega" value="{{ old('cep_entrega') }}"
                                        placeholder="12345-678"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('cep_entrega') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Logradouro (7 colunas) -->
                                <div class="md:col-span-7">
                                    <label class="block text-sm font-medium text-gray-700">Logradouro *</label>
                                    <input type="text" name="logradouro_entrega" id="logradouro_entrega" value="{{ old('logradouro_entrega') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('logradouro_entrega') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Número (2 colunas) -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Número *</label>
                                    <input type="text" name="numero_entrega" id="numero_entrega" value="{{ old('numero_entrega') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('numero_entrega') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Complemento (12 colunas) -->
                                <div class="md:col-span-12">
                                    <label class="block text-sm font-medium text-gray-700">Complemento</label>
                                    <input type="text" name="complemento_entrega" id="complemento_entrega" value="{{ old('complemento_entrega') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('complemento_entrega') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Bairro (4 colunas) -->
                                <div class="md:col-span-4">
                                    <label class="block text-sm font-medium text-gray-700">Bairro *</label>
                                    <input type="text" name="bairro_entrega" id="bairro_entrega" value="{{ old('bairro_entrega') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('bairro_entrega') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Cidade (6 colunas) -->
                                <div class="md:col-span-6">
                                    <label class="block text-sm font-medium text-gray-700">Cidade *</label>
                                    <input type="text" name="cidade_entrega" id="cidade_entrega" value="{{ old('cidade_entrega') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('cidade_entrega') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- UF (2 colunas) -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">UF *</label>
                                    <select name="uf_entrega" id="uf_entrega"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Selecione...</option>
                                        <option value="AC">AC</option><option value="AL">AL</option><option value="AP">AP</option>
                                        <option value="AM">AM</option><option value="BA">BA</option><option value="CE">CE</option>
                                        <option value="DF">DF</option><option value="ES">ES</option><option value="GO">GO</option>
                                        <option value="MA">MA</option><option value="MT">MT</option><option value="MS">MS</option>
                                        <option value="MG">MG</option><option value="PA">PA</option><option value="PB">PB</option>
                                        <option value="PR">PR</option><option value="PE">PE</option><option value="PI">PI</option>
                                        <option value="RJ">RJ</option><option value="RN">RN</option><option value="RS">RS</option>
                                        <option value="RO">RO</option><option value="RR">RR</option><option value="SC">SC</option>
                                        <option value="SP">SP</option><option value="SE">SE</option><option value="TO">TO</option>
                                    </select>
                                    @error('uf_entrega') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                                            <!-- Link de Localização -->
                            <div class="md:col-span-12">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Link de Localização (Waze) <span class="text-red-500">*</span>
                                </label>
                                <div class="flex gap-2">
                                    <input type="text" name="localizacao" id="localizacao" value="{{ old('localizacao') }}"
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

                            </div>



<input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
<input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">

                        
                        
                        <!-- Seção: Itens do Pedido -->
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">📦 Itens do Pedido</h3>
                            
                            <div id="itens-container" class="space-y-3">
                                <div class="item-row grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                                    <div class="md:col-span-5">
                                        <label class="block text-sm font-medium text-gray-700">Equipamento</label>
                                        <select name="itens[0][equipamento_id]" class="equipamento-select w-full rounded-md border-gray-300" required>
                                            <option value="">Selecione...</option>
                                            @foreach($equipamentos as $equipamento)
                                                <option value="{{ $equipamento->id }}" data-preco="{{ $equipamento->preco_diaria }}">
                                                    {{ $equipamento->nome }} 
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Quantidade</label>
                                        <input type="number" name="itens[0][quantidade]" class="quantidade w-full rounded-md border-gray-300" value="1" min="1" required>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Preço Unitário</label>
                                        <input type="text" name="itens[0][preco_unitario]" class="preco-unitario w-full rounded-md border-gray-300 bg-gray-100" readonly>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Subtotal</label>
                                        <input type="text" class="subtotal w-full rounded-md border-gray-300 bg-gray-100" readonly>
                                    </div>
                                    <div class="md:col-span-1">
                                        <button type="button" class="remove-item w-full bg-red-500 text-white px-3 py-2 rounded hover:bg-red-700 transition">Remover</button>
                                    </div>
                                </div>
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
        <!-- Coluna Esquerda: Forma de Pagamento, CPF e CNPJ -->
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Forma de Pagamento *</label>
                <select name="forma_pagamento" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Selecione...</option>
                    <option value="dinheiro" {{ old('forma_pagamento') == 'dinheiro' ? 'selected' : '' }}>Dinheiro</option>
                    <option value="pix" {{ old('forma_pagamento') == 'pix' ? 'selected' : '' }}>PIX</option>
                    <option value="cartao_credito" {{ old('forma_pagamento') == 'cartao_credito' ? 'selected' : '' }}>Cartão de Crédito</option>
                    <option value="cartao_debito" {{ old('forma_pagamento') == 'cartao_debito' ? 'selected' : '' }}>Cartão de Débito</option>
                    <option value="boleto" {{ old('forma_pagamento') == 'boleto' ? 'selected' : '' }}>Boleto</option>
                </select>
                @error('forma_pagamento') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">CPF (opcional)</label>
                <input type="text" name="cpf_pedido" id="cpf_pedido" value="{{ old('cpf_pedido') }}"
                    placeholder="111.111.111-11"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('cpf_pedido') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">CNPJ (opcional)</label>
                <input type="text" name="cnpj_pedido" id="cnpj_pedido" value="{{ old('cnpj_pedido') }}"
                    placeholder="12.345.678/0001-90"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('cnpj_pedido') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>
        
        <!-- Coluna Direita: Totais -->
        <div class="space-y-2">
            <div class="flex justify-between items-center pb-2 border-b">
                <span class="font-medium text-gray-600">Subtotal:</span>
                <span id="subtotal-display" class="text-lg font-semibold">R$ 0,00</span>
            </div>
            
            <div class="flex justify-between items-center pb-2 border-b">
                <span class="font-medium text-gray-600">Taxa de Entrega (R$):</span>
                <input type="number" name="taxa_entrega" id="taxa_entrega" value="10.00" step="0.01" 
                    class="w-32 text-right border rounded px-2 py-1">
            </div>
            
            <div class="flex justify-between items-center pb-2 border-b">
                <span class="font-medium text-gray-600">Desconto (R$):</span>
                <input type="number" name="desconto" id="desconto" value="0" step="0.01" 
                    class="w-32 text-right border rounded px-2 py-1">
            </div>
            
            <div class="flex justify-between items-center pb-2 border-b">
                <span class="font-medium text-gray-600">Entrada (50%):</span>
                <span id="caucao-display" class="text-lg font-semibold text-orange-600">R$ 0,00</span>
            </div>
            
            <div class="flex justify-between items-center pt-2">
                <span class="font-bold text-lg text-gray-800">TOTAL:</span>
                <span id="total-display" class="text-2xl font-bold text-blue-600">R$ 0,00</span>
            </div>
        </div>
    </div>
</div>
                        
                        <!-- Observações -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700">Observações</label>
                            <textarea name="observacoes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Informações adicionais sobre o pedido...">{{ old('observacoes') }}</textarea>
                        </div>
                        
                        <!-- Botões -->
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('pedidos.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition">
                                Cancelar
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                                Salvar Pedido
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

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
        } else {
            document.getElementById('cep_entrega').value = '';
            document.getElementById('logradouro_entrega').value = '';
            document.getElementById('numero_entrega').value = '';
            document.getElementById('complemento_entrega').value = '';
            document.getElementById('bairro_entrega').value = '';
            document.getElementById('cidade_entrega').value = '';
            document.getElementById('uf_entrega').value = '';
        }
    });
    
    if ($('#cliente_id').val()) {
        carregarEnderecoCliente($('#cliente_id').val());
    }
    
    // ============================================
    // BUSCA CEP
    // ============================================
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
                            // ✅ Após buscar CEP, tentar preencher devolução
                            preencherDevolucaoAutomatica();
                        }
                    })
                    .catch(error => console.error('Erro ao buscar CEP:', error));
            }
        });
    }
    
    // ============================================
    // PREENCHER DEVOLUÇÃO PARA O PRÓXIMO DIA
    // ============================================
    function preencherDevolucaoAutomatica() {
        const dataEntrega = document.getElementById('data_entrega_date');
        const horaEntrega = document.getElementById('data_entrega_time');
        const dataDevolucao = document.getElementById('data_devolucao_date');
        const horaDevolucao = document.getElementById('data_devolucao_time');
        
        // Só preencher se tiver data de entrega e a devolução estiver vazia
        if (dataEntrega && dataEntrega.value && dataDevolucao && !dataDevolucao.value) {
            // Calcular próximo dia
            const data = new Date(dataEntrega.value);
            data.setDate(data.getDate() + 1);
            
            // Formatar para YYYY-MM-DD
            const year = data.getFullYear();
            const month = String(data.getMonth() + 1).padStart(2, '0');
            const day = String(data.getDate()).padStart(2, '0');
            dataDevolucao.value = `${year}-${month}-${day}`;
            
            // Mesma hora
            if (horaDevolucao && horaEntrega && horaEntrega.value) {
                horaDevolucao.value = horaEntrega.value;
            }
        }
    }
    
    // ============================================
    // CÁLCULOS DOS ITENS DO PEDIDO
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
            const diffTime = devolucao - entrega;
            const diffDays = diffTime / (1000 * 60 * 60 * 24);
            const diasArredondados = Math.ceil(diffDays);
            return Math.max(diasArredondados, 1);
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
        
        if (subtotalDisplay) subtotalDisplay.innerHTML = 'R$ ' + subtotal.toFixed(2).replace('.', ',');
        if (totalDisplay) totalDisplay.innerHTML = 'R$ ' + total.toFixed(2).replace('.', ',');
        if (caucaoDisplay) caucaoDisplay.innerHTML = 'R$ ' + caucao.toFixed(2).replace('.', ',');
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
    
    // Adicionar eventos aos campos de data/hora
    const dataEntregaDate = document.getElementById('data_entrega_date');
    const dataEntregaTime = document.getElementById('data_entrega_time');
    const dataDevolucaoDate = document.getElementById('data_devolucao_date');
    const dataDevolucaoTime = document.getElementById('data_devolucao_time');
    
    if (dataEntregaDate) {
        dataEntregaDate.addEventListener('change', function() {
            atualizarTodosPrecos();
            preencherDevolucaoAutomatica();
        });
    }
    if (dataEntregaTime) dataEntregaTime.addEventListener('change', atualizarTodosPrecos);
    if (dataDevolucaoDate) dataDevolucaoDate.addEventListener('change', atualizarTodosPrecos);
    if (dataDevolucaoTime) dataDevolucaoTime.addEventListener('change', atualizarTodosPrecos);
    
    // Adicionar novo item
    let itemCount = 1;
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
    
    document.querySelectorAll('.item-row').forEach(row => {
        adicionarEventosItem(row);
    });
    
    // ============================================
    // VALIDAÇÃO DE DATAS
    // ============================================
    function getDataAtual() {
        const hoje = new Date();
        const year = hoje.getFullYear();
        const month = String(hoje.getMonth() + 1).padStart(2, '0');
        const day = String(hoje.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }
    
    if (dataEntregaDate) {
        dataEntregaDate.setAttribute('min', getDataAtual());
        
        dataEntregaDate.addEventListener('change', function() {
            if (this.value && this.value < getDataAtual()) {
                alert('A data de entrega não pode ser anterior à data de hoje.');
                this.value = '';
            }
        });
    }
    
    if (dataDevolucaoDate && dataEntregaDate) {
        dataDevolucaoDate.addEventListener('change', function() {
            if (!dataEntregaDate.value) {
                alert('Selecione primeiro a data de entrega.');
                this.value = '';
                return;
            }
            
            if (this.value && this.value < dataEntregaDate.value) {
                alert('A data de devolução não pode ser anterior à data de entrega.');
                this.value = '';
            }
        });
    }
    
    if (dataDevolucaoTime && dataEntregaTime && dataDevolucaoDate && dataEntregaDate) {
        function validarHorarioDevolucao() {
            if (!dataEntregaDate.value || !dataDevolucaoDate.value) return;
            
            if (dataDevolucaoDate.value === dataEntregaDate.value) {
                const horaEntrega = dataEntregaTime.value;
                const horaDevolucao = dataDevolucaoTime.value;
                
                if (horaEntrega && horaDevolucao && horaDevolucao <= horaEntrega) {
                    alert('O horário de devolução deve ser posterior ao horário de entrega.');
                    dataDevolucaoTime.value = '';
                }
            }
        }
        
        dataDevolucaoTime.addEventListener('change', validarHorarioDevolucao);
        dataEntregaTime.addEventListener('change', validarHorarioDevolucao);
    }
    
    // ============================================
    // VALIDAÇÃO ANTES DE ENVIAR
    // ============================================
    document.getElementById('pedidoForm')?.addEventListener('submit', function(e) {
        if (!dataEntregaDate?.value) {
            alert('Preencha a data de entrega.');
            e.preventDefault();
            return false;
        }
        
        if (!dataEntregaTime?.value) {
            alert('Preencha o horário de entrega.');
            e.preventDefault();
            return false;
        }
        
        if (!dataDevolucaoDate?.value) {
            alert('Preencha a data de devolução.');
            e.preventDefault();
            return false;
        }
        
        if (!dataDevolucaoTime?.value) {
            alert('Preencha o horário de devolução.');
            e.preventDefault();
            return false;
        }
        
        if (dataEntregaDate.value < getDataAtual()) {
            alert('A data de entrega não pode ser anterior à data de hoje.');
            e.preventDefault();
            return false;
        }
        
        if (dataDevolucaoDate.value < dataEntregaDate.value) {
            alert('A data de devolução não pode ser anterior à data de entrega.');
            e.preventDefault();
            return false;
        }
        
        if (dataDevolucaoDate.value === dataEntregaDate.value && 
            dataDevolucaoTime.value <= dataEntregaTime.value) {
            alert('O horário de devolução deve ser posterior ao horário de entrega.');
            e.preventDefault();
            return false;
        }
        
        const dataEntrega = document.getElementById('data_entrega_date')?.value;
        const horaEntrega = document.getElementById('data_entrega_time')?.value;
        if (dataEntrega && horaEntrega) {
            document.getElementById('data_entrega_combined').value = `${dataEntrega}T${horaEntrega}:00`;
        }
        
        const dataDevolucao = document.getElementById('data_devolucao_date')?.value;
        const horaDevolucao = document.getElementById('data_devolucao_time')?.value;
        if (dataDevolucao && horaDevolucao) {
            document.getElementById('data_devolucao_combined').value = `${dataDevolucao}T${horaDevolucao}:00`;
        }
    });
    
    // ============================================
    // MÁSCARAS CPF/CNPJ
    // ============================================
    const cpfPedido = document.getElementById('cpf_pedido');
    if (cpfPedido) {
        cpfPedido.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 11) value = value.slice(0, 11);
            if (value.length <= 11) {
                value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
            }
            e.target.value = value;
        });
        
        cpfPedido.addEventListener('blur', function() {
            if (this.value && !validarCPF(this.value)) {
                alert('CPF inválido!');
                this.value = '';
            }
        });
    }
    
    const cnpjPedido = document.getElementById('cnpj_pedido');
    if (cnpjPedido) {
        cnpjPedido.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 14) value = value.slice(0, 14);
            if (value.length <= 14) {
                value = value.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
            }
            e.target.value = value;
        });
        
        cnpjPedido.addEventListener('blur', function() {
            if (this.value && !validarCNPJ(this.value)) {
                alert('CNPJ inválido!');
                this.value = '';
            }
        });
    }
    
    function validarCPF(cpf) {
        cpf = cpf.replace(/\D/g, '');
        if (cpf.length !== 11) return false;
        if (/^(\d)\1{10}$/.test(cpf)) return false;
        
        let sum = 0;
        for (let i = 0; i < 9; i++) sum += parseInt(cpf.charAt(i)) * (10 - i);
        let firstDigit = 11 - (sum % 11);
        if (firstDigit >= 10) firstDigit = 0;
        if (firstDigit !== parseInt(cpf.charAt(9))) return false;
        
        sum = 0;
        for (let i = 0; i < 10; i++) sum += parseInt(cpf.charAt(i)) * (11 - i);
        let secondDigit = 11 - (sum % 11);
        if (secondDigit >= 10) secondDigit = 0;
        if (secondDigit !== parseInt(cpf.charAt(10))) return false;
        
        return true;
    }
    
    function validarCNPJ(cnpj) {
        cnpj = cnpj.replace(/\D/g, '');
        if (cnpj.length !== 14) return false;
        if (/^(\d)\1{13}$/.test(cnpj)) return false;
        
        let sum = 0;
        let peso = 5;
        for (let i = 0; i < 12; i++) {
            sum += parseInt(cnpj.charAt(i)) * peso;
            peso--;
            if (peso < 2) peso = 9;
        }
        let firstDigit = 11 - (sum % 11);
        if (firstDigit >= 10) firstDigit = 0;
        if (firstDigit !== parseInt(cnpj.charAt(12))) return false;
        
        sum = 0;
        peso = 6;
        for (let i = 0; i < 13; i++) {
            sum += parseInt(cnpj.charAt(i)) * peso;
            peso--;
            if (peso < 2) peso = 9;
        }
        let secondDigit = 11 - (sum % 11);
        if (secondDigit >= 10) secondDigit = 0;
        if (secondDigit !== parseInt(cnpj.charAt(13))) return false;
        
        return true;
    }
    
    // ============================================
    // GERAR LINK DE LOCALIZAÇÃO
    // ============================================
    const gerarBtn = document.getElementById('gerarLocalizacao');
    if (gerarBtn) {
        gerarBtn.addEventListener('click', async function() {
            const logradouro = document.getElementById('logradouro_entrega').value;
            const numero = document.getElementById('numero_entrega').value;
            const bairro = document.getElementById('bairro_entrega').value;
            const cidade = document.getElementById('cidade_entrega').value;
            const uf = document.getElementById('uf_entrega').value;
            
            if (!logradouro || !cidade) {
                alert('Preencha o endereço completo antes de gerar o link.');
                return;
            }
            
            // Mostrar loading
            const textoOriginal = this.innerHTML;
            this.disabled = true;
            this.innerHTML = '<span class="animate-pulse">🔄 Buscando...</span>';
            
            // Construir endereço completo
            let enderecoCompleto = `${logradouro}, ${numero}`;
            if (bairro) enderecoCompleto += ` - ${bairro}`;
            enderecoCompleto += `, ${cidade} - ${uf}, Brasil`;
            
            let linkGerado = false;
            
            try {
                // Tentar buscar coordenadas usando Nominatim (OpenStreetMap)
                const searchUrl = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(enderecoCompleto)}&format=json&limit=1&countrycodes=br&addressdetails=1`;
                
                const response = await fetch(searchUrl, {
                    headers: {
                        'Accept-Language': 'pt-BR',
                        'User-Agent': 'AlugaMais/1.0'
                    }
                });
                const data = await response.json();
                
                if (data && data.length > 0) {
                    const lat = parseFloat(data[0].lat).toFixed(6);
                    const lon = parseFloat(data[0].lon).toFixed(6);
                    
                    // Gerar link do Waze com coordenadas
                    const wazeLink = `https://waze.com/ul?ll=${lat},${lon}&navigate=yes`;
                    document.getElementById('localizacao').value = wazeLink;
                    
                    // Salvar coordenadas
                    const latitudeInput = document.getElementById('latitude');
                    const longitudeInput = document.getElementById('longitude');
                    if (latitudeInput) latitudeInput.value = lat;
                    if (longitudeInput) longitudeInput.value = lon;
                    
                    linkGerado = true;
                    this.classList.add('bg-green-600');
                    this.innerHTML = '✅ Link gerado!';
                }
            } catch (error) {
                console.error('Erro ao buscar coordenadas:', error);
            }
            
            // ✅ Se não conseguiu as coordenadas, gerar link com o endereço
            if (!linkGerado) {
                const wazeLinkEndereco = `https://waze.com/ul?q=${encodeURIComponent(enderecoCompleto)}&navigate=yes`;
                document.getElementById('localizacao').value = wazeLinkEndereco;
                
                this.classList.add('bg-yellow-600');
                this.innerHTML = '⚠️ Link com endereço';
                
                setTimeout(() => {
                    this.classList.remove('bg-yellow-600');
                }, 2000);
            }
            
            setTimeout(() => {
                this.classList.remove('bg-green-600', 'bg-yellow-600');
                this.innerHTML = textoOriginal;
                this.disabled = false;
            }, 2000);
        });
    }
    
    // Eventos de taxa e desconto
    const taxaEntrega = document.getElementById('taxa_entrega');
    const desconto = document.getElementById('desconto');
    if (taxaEntrega) taxaEntrega.addEventListener('input', atualizarTotais);
    if (desconto) desconto.addEventListener('input', atualizarTotais);
    
    // Inicializar
    atualizarTotais();
    setTimeout(() => {
        preencherDevolucaoAutomatica();
    }, 100);
</script>