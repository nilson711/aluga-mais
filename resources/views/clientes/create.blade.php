<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Novo Cliente') }}
        </h2>
    </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form action="{{ route('clientes.store') }}" method="POST">
                    @csrf
                    
                    <!-- Grid principal com 12 colunas -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                        <!-- Primeira linha: Nome (12 colunas) -->
                        <div class="md:col-span-12">
                            <label class="block text-sm font-medium text-gray-700">Nome *</label>
                            <input type="text" name="nome" value="{{ old('nome') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('nome') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <!-- Segunda linha: Email 3, Telefone Principal 3, Telefone Alternativo 3, CPF 3 -->
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-gray-700">E-mail</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <!-- Telefone 1 -->
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-gray-700">Telefone Principal *</label>
                            <input type="text" name="telefone1" id="telefone1" value="{{ old('telefone1', $cliente->telefone1 ?? '') }}" required
                                placeholder="(11) 99999-9999"
                                maxlength="15"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('telefone1') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Telefone 2 -->
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-gray-700">Telefone Alternativo</label>
                            <input type="text" name="telefone2" id="telefone2" value="{{ old('telefone2', $cliente->telefone2 ?? '') }}"
                                placeholder="(11) 88888-8888"
                                maxlength="15"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('telefone2') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- CPF -->
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-gray-700">CPF *</label>
                            <input type="text" name="cpf" id="cpf" value="{{ old('cpf', $cliente->cpf ?? '') }}" required
                                placeholder="111.111.111-11"
                                maxlength="14"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('cpf') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <!-- Terceira linha: CEP (12 colunas) -->
                        <div class="md:col-span-3">
                            <div class="flex items-center justify-between mb-1">
                                <label class="block text-sm font-medium text-gray-700">CEP *</label>
                                <a href="https://buscacepinter.correios.com.br/app/endereco/index.php" 
                                target="_blank" 
                                rel="noopener noreferrer"
                                class="text-xs text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                    Não sei o CEP
                                </a>
                            </div>
                            <input type="text" name="cep" id="cep" value="{{ old('cep') }}" required
                                placeholder="12345-678"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('cep') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <!-- Logradouro (12 colunas) -->
                        <div class="md:col-span-12">
                            <label class="block text-sm font-medium text-gray-700">Logradouro *</label>
                            <input type="text" name="logradouro" id="logradouro" value="{{ old('logradouro') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('logradouro') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <!-- Quarta linha: Número 1, Complemento 2, Bairro 2, Cidade 2, UF 1 -->
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Número *</label>
                            <input type="text" name="numero" value="{{ old('numero') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('numero') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-gray-700">Complemento</label>
                            <input type="text" name="complemento" value="{{ old('complemento') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('complemento') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-gray-700">Bairro *</label>
                            <input type="text" name="bairro" id="bairro" value="{{ old('bairro') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('bairro') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-gray-700">Cidade *</label>
                            <input type="text" name="cidade" id="cidade" value="{{ old('cidade') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('cidade') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">UF *</label>
                            <select name="uf" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Selecione...</option>
                                <option value="AC" {{ old('uf') == 'AC' ? 'selected' : '' }}>AC</option>
                                <option value="AL" {{ old('uf') == 'AL' ? 'selected' : '' }}>AL</option>
                                <option value="AP" {{ old('uf') == 'AP' ? 'selected' : '' }}>AP</option>
                                <option value="AM" {{ old('uf') == 'AM' ? 'selected' : '' }}>AM</option>
                                <option value="BA" {{ old('uf') == 'BA' ? 'selected' : '' }}>BA</option>
                                <option value="CE" {{ old('uf') == 'CE' ? 'selected' : '' }}>CE</option>
                                <option value="DF" {{ old('uf') == 'DF' ? 'selected' : '' }}>DF</option>
                                <option value="ES" {{ old('uf') == 'ES' ? 'selected' : '' }}>ES</option>
                                <option value="GO" {{ old('uf') == 'GO' ? 'selected' : '' }}>GO</option>
                                <option value="MA" {{ old('uf') == 'MA' ? 'selected' : '' }}>MA</option>
                                <option value="MT" {{ old('uf') == 'MT' ? 'selected' : '' }}>MT</option>
                                <option value="MS" {{ old('uf') == 'MS' ? 'selected' : '' }}>MS</option>
                                <option value="MG" {{ old('uf') == 'MG' ? 'selected' : '' }}>MG</option>
                                <option value="PA" {{ old('uf') == 'PA' ? 'selected' : '' }}>PA</option>
                                <option value="PB" {{ old('uf') == 'PB' ? 'selected' : '' }}>PB</option>
                                <option value="PR" {{ old('uf') == 'PR' ? 'selected' : '' }}>PR</option>
                                <option value="PE" {{ old('uf') == 'PE' ? 'selected' : '' }}>PE</option>
                                <option value="PI" {{ old('uf') == 'PI' ? 'selected' : '' }}>PI</option>
                                <option value="RJ" {{ old('uf') == 'RJ' ? 'selected' : '' }}>RJ</option>
                                <option value="RN" {{ old('uf') == 'RN' ? 'selected' : '' }}>RN</option>
                                <option value="RS" {{ old('uf') == 'RS' ? 'selected' : '' }}>RS</option>
                                <option value="RO" {{ old('uf') == 'RO' ? 'selected' : '' }}>RO</option>
                                <option value="RR" {{ old('uf') == 'RR' ? 'selected' : '' }}>RR</option>
                                <option value="SC" {{ old('uf') == 'SC' ? 'selected' : '' }}>SC</option>
                                <option value="SP" {{ old('uf') == 'SP' ? 'selected' : '' }}>SP</option>
                                <option value="SE" {{ old('uf') == 'SE' ? 'selected' : '' }}>SE</option>
                                <option value="TO" {{ old('uf') == 'TO' ? 'selected' : '' }}>TO</option>
                            </select>
                            @error('uf') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <!-- Quinta linha: Observações (12 colunas) -->
                        <div class="md:col-span-12">
                            <label class="block text-sm font-medium text-gray-700">Observações</label>
                            <textarea name="observacoes" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('observacoes') }}</textarea>
                            @error('observacoes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <!-- Ativo -->
                        <div class="md:col-span-12">
                            <label class="flex items-center">
                                <input type="checkbox" name="ativo" value="1" {{ old('ativo', true) ? 'checked' : '' }}
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
                            Salvar Cliente
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

    // Máscara para telefone (permitir apenas 15 caracteres)
document.getElementById('telefone1')?.addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 11) {
        value = value.slice(0, 11); // Limita a 11 dígitos
    }
    if (value.length <= 10) {
        value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
    } else {
        value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
    }
    e.target.value = value;
});

// Máscara para CPF (permitir apenas 11 dígitos)
document.getElementById('cpf')?.addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 11) {
        value = value.slice(0, 11); // Limita a 11 dígitos
    }
    value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
    e.target.value = value;
});

</script>