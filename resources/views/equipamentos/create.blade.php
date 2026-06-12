<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Novo Equipamento') }}
        </h2>
    </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form action="{{ route('equipamentos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <!-- Primeira linha: Nome (2 colunas) + Patrimônio (2 colunas) -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Nome *</label>
                            <input type="text" name="nome" value="{{ old('nome') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('nome') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <!-- Nº Patrimônio (2 colunas) -->
                        <div class="md:col-span-2">
                            <div class="flex items-center gap-2 mb-1">
                                <label class="block text-sm font-medium text-gray-700">Nº Patrimônio</label>
                                <div class="group relative">
                                    <svg class="w-4 h-4 text-gray-400 hover:text-gray-600 cursor-help" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block bg-gray-800 text-white text-xs rounded py-1 px-2 whitespace-nowrap z-10">
                                        Deixe em branco para gerar automaticamente
                                    </div>
                                </div>
                            </div>
                            <input type="text" name="numero_patrimonio" value="{{ old('numero_patrimonio') }}"
                                placeholder="Ex: PAT2025040001 ou deixe em branco"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <p class="mt-1 text-xs text-gray-500">
                                💡 Se não informado, o sistema gerará automaticamente
                            </p>
                            @error('numero_patrimonio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <!-- Segunda linha: Categoria, Marca, Modelo (3 colunas) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Categoria *</label>
                            <select name="categoria" id="categoria" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Selecione...</option>
                                <option value="Mesa" {{ old('categoria') == 'Mesa' ? 'selected' : '' }}>Mesa</option>
                                <option value="Cadeira" {{ old('categoria') == 'Cadeira' ? 'selected' : '' }}>Cadeira</option>
                                <option value="Refrigeração" {{ old('categoria') == 'Refrigeração' ? 'selected' : '' }}>Refrigeração</option>
                                <option value="Tenda" {{ old('categoria') == 'Tenda' ? 'selected' : '' }}>Tenda</option>
                                <option value="Climatizador" {{ old('categoria') == 'Climatizador' ? 'selected' : '' }}>Climatizador</option>
                                <option value="Outros" {{ old('categoria') == 'Outros' ? 'selected' : '' }}>Outros</option>
                            </select>
                            @error('categoria') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Marca *</label>
                            <select name="marca" id="marca" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Selecione a marca...</option>
                                <optgroup label="Refrigeraçãos e Refrigeração">
                                    <option value="Electrolux" {{ old('marca') == 'Electrolux' ? 'selected' : '' }}>Electrolux</option>
                                    <option value="Consul" {{ old('marca') == 'Consul' ? 'selected' : '' }}>Consul</option>
                                    <option value="Brastemp" {{ old('marca') == 'Brastemp' ? 'selected' : '' }}>Brastemp</option>
                                    <option value="Fischer" {{ old('marca') == 'Fischer' ? 'selected' : '' }}>Fischer</option>
                                    <option value="Metalfrio" {{ old('marca') == 'Metalfrio' ? 'selected' : '' }}>Metalfrio</option>
                                    <option value="Esmaltec" {{ old('marca') == 'Esmaltec' ? 'selected' : '' }}>Esmaltec</option>
                                    <option value="Continental" {{ old('marca') == 'Continental' ? 'selected' : '' }}>Continental</option>
                                    <option value="Gelopar" {{ old('marca') == 'Gelopar' ? 'selected' : '' }}>Gelopar</option>
                                    <option value="Komeco" {{ old('marca') == 'Komeco' ? 'selected' : '' }}>Komeco</option>
                                    <option value="Skope" {{ old('marca') == 'Skope' ? 'selected' : '' }}>Skope</option>
                                </optgroup>
                                <optgroup label="Cadeiras">
                                    <option value="Plaxmetal" {{ old('marca') == 'Plaxmetal' ? 'selected' : '' }}>Plaxmetal</option>
                                    <option value="Favero" {{ old('marca') == 'Favero' ? 'selected' : '' }}>Favero</option>
                                    <option value="Kalu" {{ old('marca') == 'Kalu' ? 'selected' : '' }}>Kalu</option>
                                    <option value="Roma" {{ old('marca') == 'Roma' ? 'selected' : '' }}>Roma</option>
                                    <option value="PoliMove" {{ old('marca') == 'PoliMove' ? 'selected' : '' }}>PoliMove</option>
                                    <option value="FlexForm" {{ old('marca') == 'FlexForm' ? 'selected' : '' }}>FlexForm</option>
                                    <option value="Madesa" {{ old('marca') == 'Madesa' ? 'selected' : '' }}>Madesa</option>
                                    <option value="Rudnick" {{ old('marca') == 'Rudnick' ? 'selected' : '' }}>Rudnick</option>
                                    <option value="Probel" {{ old('marca') == 'Probel' ? 'selected' : '' }}>Probel</option>
                                    <option value="Veneza" {{ old('marca') == 'Veneza' ? 'selected' : '' }}>Veneza</option>
                                </optgroup>
                                <optgroup label="Mesas">
                                    <option value="Plaxmetal" {{ old('marca') == 'Plaxmetal' ? 'selected' : '' }}>Plaxmetal</option>
                                    <option value="Favero" {{ old('marca') == 'Favero' ? 'selected' : '' }}>Favero</option>
                                    <option value="Roma" {{ old('marca') == 'Roma' ? 'selected' : '' }}>Roma</option>
                                    <option value="Madesa" {{ old('marca') == 'Madesa' ? 'selected' : '' }}>Madesa</option>
                                    <option value="Rudnick" {{ old('marca') == 'Rudnick' ? 'selected' : '' }}>Rudnick</option>
                                    <option value="Probel" {{ old('marca') == 'Probel' ? 'selected' : '' }}>Probel</option>
                                </optgroup>
                                <optgroup label="Tendas e Estruturas">
                                    <option value="Lona Bella" {{ old('marca') == 'Lona Bella' ? 'selected' : '' }}>Lona Bella</option>
                                    <option value="Liderlonas" {{ old('marca') == 'Liderlonas' ? 'selected' : '' }}>Liderlonas</option>
                                    <option value="Mega Tendas" {{ old('marca') == 'Mega Tendas' ? 'selected' : '' }}>Mega Tendas</option>
                                    <option value="Tecnolonas" {{ old('marca') == 'Tecnolonas' ? 'selected' : '' }}>Tecnolonas</option>
                                    <option value="Pratiko" {{ old('marca') == 'Pratiko' ? 'selected' : '' }}>Pratiko</option>
                                </optgroup>
                                <optgroup label="Outros">
                                    <option value="Outra" {{ old('marca') == 'Outra' ? 'selected' : '' }}>Outra (especificar)</option>
                                </optgroup>
                            </select>
                            
                            <input type="text" name="marca_outra" id="marca_outra" 
                                placeholder="Digite a marca..."
                                style="display: none; margin-top: 8px;"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            
                            @error('marca') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Modelo</label>
                            <input type="text" name="modelo" value="{{ old('modelo') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('modelo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <!-- Terceira linha: Valor Aquisição + Data Aquisição -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Valor de Aquisição (R$)</label>
                            <input type="number" step="0.01" name="valor_aquisicao" value="{{ old('valor_aquisicao') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('valor_aquisicao') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Data de Aquisição</label>
                            <input type="date" name="data_aquisicao" value="{{ old('data_aquisicao') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('data_aquisicao') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <!-- Quarta linha: Diária, Semanal, Mensal -->
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <label class="block text-sm font-medium text-gray-700">Diária (R$) <span class="text-red-500">*</span></label>
                                <div class="group relative">
                                    <svg class="w-4 h-4 text-gray-400 hover:text-gray-600 cursor-help" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block bg-gray-800 text-white text-xs rounded py-1 px-2 whitespace-nowrap z-10">
                                        Preço sugerido, mas este valor pode ser alterado no pedido.
                                    </div>
                                </div>
                            </div>
                            <input type="number" step="0.01" name="preco_diaria" value="{{ old('preco_diaria') }}" required
                                placeholder="preço sugerido"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('preco_diaria') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <label class="block text-sm font-medium text-gray-700">Semanal (R$) <span class="text-red-500">*</span></label>
                                <div class="group relative">
                                    <svg class="w-4 h-4 text-gray-400 hover:text-gray-600 cursor-help" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block bg-gray-800 text-white text-xs rounded py-1 px-2 whitespace-nowrap z-10">
                                        Preço sugerido para 7 dias, mas este valor pode ser alterado no pedido.
                                    </div>
                                </div>
                            </div>
                            <input type="number" step="0.01" name="preco_semanal" value="{{ old('preco_semanal') }}" required
                                placeholder="preço sugerido"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('preco_semanal') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <label class="block text-sm font-medium text-gray-700">Mensal (R$) <span class="text-red-500">*</span></label>
                                <div class="group relative">
                                    <svg class="w-4 h-4 text-gray-400 hover:text-gray-600 cursor-help" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block bg-gray-800 text-white text-xs rounded py-1 px-2 whitespace-nowrap z-10">
                                        Preço sugerido para 30 dias, mas este valor pode ser alterado no pedido.
                                    </div>
                                </div>
                            </div>
                            <input type="number" step="0.01" name="preco_mensal" value="{{ old('preco_mensal') }}" required
                                placeholder="preço sugerido"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('preco_mensal') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Quinta linha: Caução (1 coluna) - será empilhada com Status abaixo -->
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <label class="block text-sm font-medium text-gray-700">Caução (R$) <span class="text-red-500">*</span></label>
                                <div class="group relative">
                                    <svg class="w-4 h-4 text-gray-400 hover:text-gray-600 cursor-help" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block bg-gray-800 text-white text-xs rounded py-1 px-2 whitespace-nowrap z-10">
                                        Valor de garantia contra danos ao equipamento.
                                    </div>
                                </div>
                            </div>
                            <input type="number" step="0.01" name="caucao" value="{{ old('caucao') }}" required
                                placeholder="valor de garantia"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('caucao') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            <br>
                            <!-- Status (1 coluna) - abaixo da Caução -->
                             <div>
                                 <div>
                                     <div class="flex items-center gap-2 mb-1">
                                         <label class="block text-sm font-medium text-gray-700">Status *</label>
                                         <div class="group relative">
                                             <svg class="w-4 h-4 text-gray-400 hover:text-gray-600 cursor-help" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                             </svg>
                                             <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block bg-gray-800 text-white text-xs rounded py-1 px-2 whitespace-nowrap z-10">
                                                 Situação atual do equipamento
                                             </div>
                                         </div>
                                     </div>
                                     <select name="status" required
                                         class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                         <option value="Disponível" {{ old('status') == 'Disponível' ? 'selected' : '' }}>
                                             ✅ Disponível
                                         </option>
                                         <option value="Alugado" {{ old('status') == 'Alugado' ? 'selected' : '' }}>
                                             🔄 Alugado
                                         </option>
                                         <option value="Manutenção" {{ old('status') == 'Manutenção' ? 'selected' : '' }}>
                                             🔧 Manutenção
                                         </option>
                                         <option value="Vendido" {{ old('status') == 'Vendido' ? 'selected' : '' }}>
                                             💰 Vendido
                                         </option>
                                     </select>
                                     @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                 </div>

                             </div>
                        </div>

                        

                        <!-- Sexta linha: Especificações Técnicas (2 colunas) + Observações (2 colunas) -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Especificações Técnicas</label>
                            <textarea name="especificacoes" rows="10"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 font-mono text-sm"
                                placeholder="As especificações serão preenchidas automaticamente ao selecionar a categoria...">{{ old('especificacoes') }}</textarea>
                            @error('especificacoes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Observações</label>
                            <textarea name="observacoes" rows="8"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('observacoes') }}</textarea>
                            @error('observacoes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                    </div> <!-- fim do grid -->
                    
                    <div class="flex justify-end gap-3 mt-6">
                        <a href="{{ route('equipamentos.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Cancelar
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Salvar Equipamento
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>            

  <script>
    // ============================================
    // 1. TEMPLATES DE ESPECIFICAÇÕES
    // ============================================
    const especificacoesTemplates = {
        'Refrigeração': `Capacidade Líquida Total: 534L
        Formato: Horizontal / Vertical
        Quantidade de Portas: 2
        Dimensões do Produto: 
        Largura: 147,3cm
        Altura: 96cm
        Profundidade: 78cm
        Voltagem: 220V`,

        'Cadeira': `Material: Madeira / Plástico / Metal
        Altura do Assento: 45cm
        Altura Total: 90cm
        Largura do Assento: 45cm
        Capacidade de Peso: 120kg
        Empilhável: Sim / Não
        Cor: Personalizável`,

        'Mesa': `Material: Madeira / Plástico / Metal
        Dimensões da Mesa: 
        Largura: 180cm
        Profundidade: 90cm
        Altura: 75cm
        Capacidade de Pessoas: 6-8
        Revestimento: Laminado / Pintura`,

        'Climatizador': `Tipo: Climatizador / Ventilador / Ar Condicionado
        Capacidade do Reservatório: 
        Vazão de Ar: 
        Velocidades: 
        Timer: 
        Controle:
        Voltagem:
        Dimensões: 
        Peso: 
        Ruído: 
        Incluso: `,


        'Tenda': `Dimensões: 10m x 10m x 5m (LxPxA)
        Estrutura: Alumínio / Aço
        Cobertura: Lona 800mm
        Laterais: Fechadas / Abertas
        Ferragens: 4 conjuntos
        Peso Total: 150kg
        Inclui: Laterais, Amarrios, Estacas`,

        'Outros': `Marca: 
        Modelo: 
        Número de Série: 
        Data de Fabricação: 
        Condição: Novo / Usado
        Observações: `
    };

    // ============================================
    // 2. MAPEAMENTO DE PALAVRAS PARA CATEGORIAS
    // ============================================
    const keywordToCategory = {
         'climatizador': 'Climatizador',
        'climatizadores': 'Climatizador',
        'ventilador': 'Climatizador',
        'ventiladores': 'Climatizador',
        'ar condicionado': 'Climatizador',
        'ar-condicionado': 'Climatizador',
        'condicionador de ar': 'Climatizador',
        'evaporador': 'Climatizador',
        'umidificador': 'Climatizador',
        'purificador': 'Climatizador',
        'circulador': 'Climatizador',
        'ventilação': 'Climatizador',
        'refrigeração': 'Refrigeração', 'Refrigeraçãos': 'Refrigeração',
         'freezer': 'Refrigeração',
        'geladeira': 'Refrigeração', 'geladeiras': 'Refrigeração',
        'refrigerador': 'Refrigeração', 'refrigeradores': 'Refrigeração',
        'frigorífico': 'Refrigeração', 'frigorifico': 'Refrigeração',
        'conservador': 'Refrigeração', 'conservadora': 'Refrigeração',
        'bebedouro': 'Refrigeração', 'bebedouros': 'Refrigeração',
        'cooler': 'Refrigeração', 'coolers': 'Refrigeração',
        'cadeira': 'Cadeira', 'cadeiras': 'Cadeira',
        'poltrona': 'Cadeira', 'poltronas': 'Cadeira',
        'mesa': 'Mesa', 'mesas': 'Mesa',
        'bancada': 'Mesa', 'bancadas': 'Mesa',
        'tenda': 'Tenda', 'tendas': 'Tenda',
        'pagode': 'Tenda', 'gaia': 'Tenda',
        'estrutura': 'Tenda', 'estruturas': 'Tenda',
        'lona': 'Tenda', 'lonas': 'Tenda',
        'outro': 'Outros', 'outros': 'Outros',
    };

    // ============================================
    // 3. FUNÇÕES PRINCIPAIS
    // ============================================
    
    // Detectar categoria pelo nome
    function detectarCategoria(nome) {
        if (!nome) return null;
        const nomeLower = nome.toLowerCase();
        for (const [keyword, category] of Object.entries(keywordToCategory)) {
            if (nomeLower.includes(keyword)) return category;
        }
        return null;
    }

    // Função para verificar se o usuário já modificou manualmente as especificações
    let especificacoesModificadas = false;
    let categoriaAnterior = '';

    // Função para pré-preencher especificações técnicas
    function preencherEspecificacoesTecnicas(categoria, forcar = false) {
        const especificacoesTextarea = document.querySelector('textarea[name="especificacoes"]');
        if (!especificacoesTextarea) return false;
        
        // Se o usuário já modificou manualmente e não é forçado, não substitui
        if (especificacoesModificadas && !forcar) {
            return false;
        }
        
        // Se a categoria mudou ou é forçado, atualiza
        if ((categoria !== categoriaAnterior || forcar) && especificacoesTemplates[categoria]) {
            especificacoesTextarea.value = especificacoesTemplates[categoria];
            especificacoesTextarea.classList.add('border-green-500', 'bg-green-50');
            setTimeout(() => {
                especificacoesTextarea.classList.remove('border-green-500', 'bg-green-50');
            }, 2000);
            categoriaAnterior = categoria;
            return true;
        }
        return false;
    }

    // Detectar e atualizar categoria e especificações
    function detectarEAtualizarCategoria() {
        const nomeInput = document.querySelector('input[name="nome"]');
        const categoriaSelect = document.getElementById('categoria');
        
        if (!nomeInput || !categoriaSelect) return;
        
        const nome = nomeInput.value;
        const categoriaDetectada = detectarCategoria(nome);
        
        if (categoriaDetectada) {
            // Selecionar a categoria no select
            for (let i = 0; i < categoriaSelect.options.length; i++) {
                if (categoriaSelect.options[i].value === categoriaDetectada) {
                    if (categoriaSelect.selectedIndex !== i) {
                        categoriaSelect.selectedIndex = i;
                        categoriaSelect.classList.add('border-green-500', 'bg-green-50');
                        setTimeout(() => {
                            categoriaSelect.classList.remove('border-green-500', 'bg-green-50');
                        }, 2000);
                    }
                    // Atualizar especificações (forçar)
                    preencherEspecificacoesTecnicas(categoriaDetectada, true);
                    break;
                }
            }
        }
    }

    // ============================================
    // 4. EVENT LISTENERS
    // ============================================
    
    // Monitorar mudanças manuais no campo de especificações
    const especificacoesTextarea = document.querySelector('textarea[name="especificacoes"]');
    if (especificacoesTextarea) {
        especificacoesTextarea.addEventListener('input', function() {
            especificacoesModificadas = true;
        });
    }
    
    // Monitorar o campo nome
    const nomeInput = document.querySelector('input[name="nome"]');
    if (nomeInput) {
        let timeoutId;
        
        nomeInput.addEventListener('input', function() {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => {
                detectarEAtualizarCategoria();
            }, 500);
        });
        
        nomeInput.addEventListener('blur', function() {
            detectarEAtualizarCategoria();
        });
    }
    
    // Monitorar mudanças manuais na categoria
    const categoriaSelect = document.getElementById('categoria');
    if (categoriaSelect) {
        categoriaSelect.addEventListener('change', function() {
            const categoriaSelecionada = this.value;
            if (categoriaSelecionada && especificacoesTemplates[categoriaSelecionada]) {
                // Resetar flag quando mudar categoria manualmente
                especificacoesModificadas = false;
                preencherEspecificacoesTecnicas(categoriaSelecionada, true);
            }
        });
        
        // Se já tiver um valor selecionado (edição), preencher especificações
        if (categoriaSelect.value && especificacoesTemplates[categoriaSelect.value]) {
            especificacoesModificadas = false;
            preencherEspecificacoesTecnicas(categoriaSelect.value, true);
        }
    }
    
    // Mostrar campo "Outra" quando selecionado
    const marcaSelect = document.getElementById('marca');
    if (marcaSelect) {
        marcaSelect.addEventListener('change', function() {
            const outraInput = document.getElementById('marca_outra');
            if (this.value === 'Outra') {
                outraInput.style.display = 'block';
                outraInput.required = true;
            } else {
                outraInput.style.display = 'none';
                outraInput.required = false;
                outraInput.value = '';
            }
        });
    }
    
    // Ao enviar o formulário, se "Outra" estiver selecionado, enviar o valor do campo texto
    // document.querySelector('form')?.addEventListener('submit', function(e) {
    //     const marcaSelect = document.getElementById('marca');
    //     const outraInput = document.getElementById('marca_outra');
        
    //     if (marcaSelect && marcaSelect.value === 'Outra' && outraInput && outraInput.value.trim() !== '') {
    //         const hiddenInput = document.createElement('input');
    //         hiddenInput.type = 'hidden';
    //         hiddenInput.name = 'marca';
    //         hiddenInput.value = outraInput.value.trim();
    //         marcaSelect.disabled = true;
    //         this.appendChild(hiddenInput);
    //     }
    // });
</script>

</x-app-layout>
