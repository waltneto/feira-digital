@extends('layouts.app')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Editar Produto</h2>
                <p class="mt-2 text-sm text-slate-500">Atualize as informações do seu produto.</p>
            </div>
            <a href="{{ route('produtos.index') }}" class="btn-secondary flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <form action="{{ route('produtos.update', $produto->id) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
                @csrf
                @method('PUT')

                @if($errors->any())
                    <div class="bg-red-50 text-red-700 p-4 rounded-xl text-sm mb-6 border border-red-100">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="nome" class="block text-sm font-medium text-slate-700 mb-2">Nome do Produto <span class="text-red-500">*</span></label>
                        <input type="text" name="nome" id="nome" required value="{{ old('nome', $produto->nome) }}" 
                               class="form-input" placeholder="Ex: Alface Crespa Orgânica">
                    </div>

                    <div>
                        <label for="preco" class="block text-sm font-medium text-slate-700 mb-2">Preço (R$) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-slate-500">R$</span>
                            </div>
                            <input type="number" step="0.01" min="0" name="preco" id="preco" required value="{{ old('preco', $produto->preco) }}"
                                   class="form-input pl-11" placeholder="0.00">
                        </div>
                    </div>

                    <div>
                        <label for="unidade_medida" class="block text-sm font-medium text-slate-700 mb-2">Unidade de Medida <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select name="unidade_medida" id="unidade_medida" required class="form-input appearance-none cursor-pointer">
                                <option value="Unidade" {{ old('unidade_medida', $produto->unidade_medida) == 'Unidade' ? 'selected' : '' }}>Unidade (un)</option>
                                <option value="Maço" {{ old('unidade_medida', $produto->unidade_medida) == 'Maço' ? 'selected' : '' }}>Maço</option>
                                <option value="Bandeja" {{ old('unidade_medida', $produto->unidade_medida) == 'Bandeja' ? 'selected' : '' }}>Bandeja</option>
                                <option value="Kg" {{ old('unidade_medida', $produto->unidade_medida) == 'Kg' ? 'selected' : '' }}>Quilograma (Kg)</option>
                                <option value="Grama" {{ old('unidade_medida', $produto->unidade_medida) == 'Grama' ? 'selected' : '' }}>Gramas (g)</option>
                                <option value="Litro" {{ old('unidade_medida', $produto->unidade_medida) == 'Litro' ? 'selected' : '' }}>Litro (L)</option>
                                <option value="Dúzia" {{ old('unidade_medida', $produto->unidade_medida) == 'Dúzia' ? 'selected' : '' }}>Dúzia</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-500">
                                <i class="fas fa-chevron-down text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label for="descricao" class="block text-sm font-medium text-slate-700 mb-2">Descrição do Produto (opcional)</label>
                        <textarea name="descricao" id="descricao" rows="4" 
                                  class="form-input" placeholder="Descreva os detalhes do produto, como foi cultivado, etc.">{{ old('descricao', $produto->descricao) }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Foto do Produto (opcional)</label>
                        
                        @if($produto->foto)
                            <div class="mb-4">
                                <img src="{{ asset('storage/' . $produto->foto) }}" alt="Foto atual" class="h-32 rounded-xl object-cover border border-slate-200 shadow-sm">
                            </div>
                        @endif

                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-xl hover:border-emerald-500 transition-colors bg-slate-50">
                            <div class="space-y-1 text-center">
                                <i class="fas fa-image text-4xl text-slate-400 mb-3"></i>
                                <div class="flex text-sm text-slate-600 justify-center">
                                    <label for="foto" class="relative cursor-pointer bg-white rounded-md font-medium text-emerald-600 hover:text-emerald-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500 px-2 py-1">
                                        <span>Fazer upload de nova imagem</span>
                                        <input id="foto" name="foto" type="file" class="sr-only" accept="image/*">
                                    </label>
                                </div>
                                <p class="text-xs text-slate-500">PNG, JPG, GIF até 2MB</p>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-2 flex flex-col sm:flex-row gap-6 pt-4 border-t border-slate-100">
                        <div class="flex items-center">
                            <input id="organico" name="organico" type="checkbox" value="1" {{ old('organico', $produto->organico) ? 'checked' : '' }}
                                   class="h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-slate-300 rounded cursor-pointer">
                            <label for="organico" class="ml-3 block text-sm font-medium text-slate-700 cursor-pointer">
                                <i class="fas fa-leaf text-emerald-500 mr-1"></i> Produto 100% Orgânico
                            </label>
                        </div>
                        
                        <div class="flex items-center">
                            <input id="disponivel" name="disponivel" type="checkbox" value="1" {{ old('disponivel', $produto->disponivel) ? 'checked' : '' }}
                                   class="h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-slate-300 rounded cursor-pointer">
                            <label for="disponivel" class="ml-3 block text-sm font-medium text-slate-700 cursor-pointer">
                                Disponível para Venda
                            </label>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="btn-primary text-lg px-8 py-3 flex items-center gap-2">
                        <i class="fas fa-save"></i> Atualizar Produto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
