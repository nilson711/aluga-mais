<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Cliente') }}: {{ $cliente->nome }}
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
                    <form action="{{ route('clientes.update', $cliente) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Grid principal com 12 colunas -->
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                            <!-- Primeira linha: Nome (12 colunas) -->
                            <div class="md:col-span-12">
                                <label class="block text-sm font-medium text-gray-700">Nome *</label>
                                <input type="text" name="nome" value="{{ old('nome', $cliente->nome) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('nome') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <!-- Segunda linha: Email 3, Telefone Principal 3, Telefone Alternativo 3, CPF 3 -->
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">E-mail</label>
                                <input type="email" name="email" value="{{ old('email', $cliente->email) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Telefone Principal *</label>
                                <input type="text" name="telefone1" id="telefone1" value="{{ old('telefone1', $cliente->telefone1) }}" required
                                    placeholder="(11) 99999-9999"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('telefone1') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Telefone Alternativo</label>
                                <input type="text" name="telefone2" id="telefone2" value="{{ old('telefone2', $cliente->telefone2) }}"
                                    placeholder="(11) 88888-8888"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('telefone2') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">CPF *</label>
                                <input type="text" name="cpf" id="cpf" value="{{ old('cpf', $cliente->cpf) }}" required
                                    placeholder="111.111.111-11"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('cpf') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <!-- Terceira linha: CEP (3 colunas) -->
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">CEP *</label>
                                <input type="text" name="cep" id="cep" value="{{ old('cep', $cliente->cep) }}" required
                                    placeholder="12345-678"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('cep') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <!-- Logradouro (12 colunas) -->
                            <div class="md:col-span-12">
                                <label class="block text-sm font-medium text-gray-700">Logradouro *</label>
                                <input type="text" name="logradouro" id="logradouro" value="{{ old('logradouro', $cliente->logradouro) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('logradouro') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <!-- Quarta linha: Número 1, Complemento 3, Bairro 3, Cidade 3, UF 2 -->
                            <div class="md:col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Número *</label>
                                <input type="text" name="numero" value="{{ old('numero', $cliente->numero) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('numero') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Complemento</label>
                                <input type="text" name="complemento" value="{{ old('complemento', $cliente->complemento) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('complemento') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Bairro *</label>
                                <input type="text" name="bairro" id="bairro" value="{{ old('bairro', $cliente->bairro) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('bairro') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Cidade *</label>
                                <input type="text" name="cidade" id="cidade" value="{{ old('cidade', $cliente->cidade) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('cidade') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">UF *</label>
                                <select name="uf" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Selecione...</option>
                                    <option value="AC" {{ old('uf', $cliente->uf) == 'AC' ? 'selected' : '' }}>AC</option>
                                    <option value="AL" {{ old('uf', $cliente->uf) == 'AL' ? 'selected' : '' }}>AL</option>
                                    <option value="AP" {{ old('uf', $cliente->uf) == 'AP' ? 'selected' : '' }}>AP</option>
                                    <option value="AM" {{ old('uf', $cliente->uf) == 'AM' ? 'selected' : '' }}>AM</option>
                                    <option value="BA" {{ old('uf', $cliente->uf) == 'BA' ? 'selected' : '' }}>BA</option>
                                    <option value="CE" {{ old('uf', $cliente->uf) == 'CE' ? 'selected' : '' }}>CE</option>
                                    <option value="DF" {{ old('uf', $cliente->uf) == 'DF' ? 'selected' : '' }}>DF</option>
                                    <option value="ES" {{ old('uf', $cliente->uf) == 'ES' ? 'selected' : '' }}>ES</option>
                                    <option value="GO" {{ old('uf', $cliente->uf) == 'GO' ? 'selected' : '' }}>GO</option>
                                    <option value="MA" {{ old('uf', $cliente->uf) == 'MA' ? 'selected' : '' }}>MA</option>
                                    <option value="MT" {{ old('uf', $cliente->uf) == 'MT' ? 'selected' : '' }}>MT</option>
                                    <option value="MS" {{ old('uf', $cliente->uf) == 'MS' ? 'selected' : '' }}>MS</option>
                                    <option value="MG" {{ old('uf', $cliente->uf) == 'MG' ? 'selected' : '' }}>MG</option>
                                    <option value="PA" {{ old('uf', $cliente->uf) == 'PA' ? 'selected' : '' }}>PA</option>
                                    <option value="PB" {{ old('uf', $cliente->uf) == 'PB' ? 'selected' : '' }}>PB</option>
                                    <option value="PR" {{ old('uf', $cliente->uf) == 'PR' ? 'selected' : '' }}>PR</option>
                                    <option value="PE" {{ old('uf', $cliente->uf) == 'PE' ? 'selected' : '' }}>PE</option>
                                    <option value="PI" {{ old('uf', $cliente->uf) == 'PI' ? 'selected' : '' }}>PI</option>
                                    <option value="RJ" {{ old('uf', $cliente->uf) == 'RJ' ? 'selected' : '' }}>RJ</option>
                                    <option value="RN" {{ old('uf', $cliente->uf) == 'RN' ? 'selected' : '' }}>RN</option>
                                    <option value="RS" {{ old('uf', $cliente->uf) == 'RS' ? 'selected' : '' }}>RS</option>
                                    <option value="RO" {{ old('uf', $cliente->uf) == 'RO' ? 'selected' : '' }}>RO</option>
                                    <option value="RR" {{ old('uf', $cliente->uf) == 'RR' ? 'selected' : '' }}>RR</option>
                                    <option value="SC" {{ old('uf', $cliente->uf) == 'SC' ? 'selected' : '' }}>SC</option>
                                    <option value="SP" {{ old('uf', $cliente->uf) == 'SP' ? 'selected' : '' }}>SP</option>
                                    <option value="SE" {{ old('uf', $cliente->uf) == 'SE' ? 'selected' : '' }}>SE</option>
                                    <option value="TO" {{ old('uf', $cliente->uf) == 'TO' ? 'selected' : '' }}>TO</option>
                                </select>
                                @error('uf') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <!-- Quinta linha: Observações (12 colunas) -->
                            <div class="md:col-span-12">
                                <label class="block text-sm font-medium text-gray-700">Observações</label>
                                <textarea name="observacoes" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('observacoes', $cliente->observacoes) }}</textarea>
                                @error('observacoes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <!-- Ativo -->
                            <div class="md:col-span-12">
                                <label class="flex items-center">
                                    <input type="checkbox" name="ativo" value="1" {{ old('ativo', $cliente->ativo) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-600">Cliente ativo</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="flex justify-end gap-3 mt-6">
                            <a href="{{ route('clientes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancelar
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Atualizar Cliente
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    // Máscara para telefone
    document.getElementById('telefone1').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length <= 10) {
            value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
        } else {
            value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
        }
        e.target.value = value;
    });
    
    document.getElementById('telefone2').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length <= 10) {
            value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
        } else {
            value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
        }
        e.target.value = value;
    });
    
    // Máscara para CPF
    document.getElementById('cpf').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length <= 11) {
            value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
        }
        e.target.value = value;
    });
    
    // Buscar endereço por CEP (ViaCEP)
    document.getElementById('cep').addEventListener('blur', function() {
        let cep = this.value.replace(/\D/g, '');
        if (cep.length === 8) {
            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => response.json())
                .then(data => {
                    if (!data.erro) {
                        document.getElementById('logradouro').value = data.logradouro;
                        document.getElementById('bairro').value = data.bairro;
                        document.getElementById('cidade').value = data.localidade;
                        document.querySelector('select[name="uf"]').value = data.uf;
                    }
                });
        }
    });
</script>