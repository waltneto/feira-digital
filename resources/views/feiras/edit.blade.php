@extends('layouts.app')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Editar Feira</h2>
                <p class="mt-2 text-sm text-slate-500">Altere datas, local e produtos oferecidos nesta feira.</p>
            </div>
            <a href="{{ route('feiras.index') }}" class="btn-secondary flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <form action="{{ route('feiras.update', $feira->id) }}" method="POST" class="p-8 space-y-8">
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
                        <label for="nome" class="block text-sm font-medium text-slate-700 mb-2">Nome da Feira <span class="text-red-500">*</span></label>
                        <input type="text" name="nome" id="nome" required value="{{ old('nome', $feira->nome) }}" 
                               class="form-input" placeholder="Ex: Feira de Domingo na Praça">
                    </div>

                    <div class="md:col-span-2">
                        <label for="descricao" class="block text-sm font-medium text-slate-700 mb-2">Descrição (opcional)</label>
                        <textarea name="descricao" id="descricao" rows="3" 
                                  class="form-input">{{ old('descricao', $feira->descricao) }}</textarea>
                    </div>
                    
                    <div>
                        <label for="status" class="block text-sm font-medium text-slate-700 mb-2">Status da Feira</label>
                        <div class="relative">
                            <select name="status" id="status" required class="form-input appearance-none cursor-pointer">
                                <option value="agendada" {{ old('status', $feira->status) == 'agendada' ? 'selected' : '' }}>Agendada</option>
                                <option value="em_andamento" {{ old('status', $feira->status) == 'em_andamento' ? 'selected' : '' }}>Em andamento</option>
                                <option value="concluida" {{ old('status', $feira->status) == 'concluida' ? 'selected' : '' }}>Concluída</option>
                                <option value="cancelada" {{ old('status', $feira->status) == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-500">
                                <i class="fas fa-chevron-down text-sm"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="hidden md:block"></div> <!-- Spacer -->

                    <div>
                        <label for="data_inicio" class="block text-sm font-medium text-slate-700 mb-2">Data e Hora de Início <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="data_inicio" id="data_inicio" required 
                               value="{{ old('data_inicio', \Carbon\Carbon::parse($feira->data_inicio)->format('Y-m-d\TH:i')) }}" 
                               class="form-input">
                    </div>

                    <div>
                        <label for="data_fim" class="block text-sm font-medium text-slate-700 mb-2">Data e Hora de Término <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="data_fim" id="data_fim" required 
                               value="{{ old('data_fim', \Carbon\Carbon::parse($feira->data_fim)->format('Y-m-d\TH:i')) }}" 
                               class="form-input">
                    </div>

                    <div class="md:col-span-2 mt-2 pt-4 border-t border-slate-100">
                        <h4 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4">Localização da Feira</h4>
                    </div>

                    <div class="md:col-span-2">
                        <label for="endereco" class="block text-sm font-medium text-slate-700 mb-2">Endereço <span class="text-red-500">*</span></label>
                        <input type="text" name="endereco" id="endereco" required value="{{ old('endereco', $feira->endereco) }}" 
                               class="form-input" placeholder="Rua, Avenida, Praça...">
                    </div>

                    <div>
                        <label for="cep" class="block text-sm font-medium text-slate-700 mb-2">CEP <span class="text-red-500">*</span></label>
                        <input type="text" name="cep" id="cep" required value="{{ old('cep', $feira->cep) }}" data-mask="cep" 
                               class="form-input" placeholder="00000-000">
                    </div>
                    
                    <div class="flex gap-4">
                        <div class="flex-1">
                            <label for="cidade" class="block text-sm font-medium text-slate-700 mb-2">Cidade <span class="text-red-500">*</span></label>
                            <input type="text" name="cidade" id="cidade" required value="{{ old('cidade', $feira->cidade) }}" 
                                   class="form-input">
                        </div>
                        <div class="w-1/3">
                            <label for="estado" class="block text-sm font-medium text-slate-700 mb-2">UF <span class="text-red-500">*</span></label>
                            <input type="text" name="estado" id="estado" required maxlength="2" value="{{ old('estado', $feira->estado) }}" 
                                   class="form-input uppercase text-center" placeholder="SP">
                        </div>
                    </div>

                    <div class="md:col-span-2 mt-2 pt-4 border-t border-slate-100">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-sm font-bold text-slate-500 uppercase tracking-wider">Produtos Oferecidos nesta Feira</h4>
                            <span class="text-xs bg-emerald-100 text-emerald-800 py-1 px-2 rounded-lg font-medium">{{ count($produtos) }} produtos no seu catálogo</span>
                        </div>
                        
                        @if(count($produtos) > 0)
                            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 max-h-64 overflow-y-auto">
                                <div class="space-y-3">
                                    @php
                                        $produtosFeiraIds = $feira->produtos->pluck('id')->toArray();
                                    @endphp
                                    @foreach($produtos as $produto)
                                        <label class="flex items-center justify-between p-3 rounded-lg hover:bg-white border border-transparent hover:border-slate-200 cursor-pointer transition-colors">
                                            <div class="flex items-center">
                                                <input type="checkbox" name="produtos[]" value="{{ $produto->id }}" 
                                                       {{ in_array($produto->id, old('produtos', $produtosFeiraIds)) ? 'checked' : '' }}
                                                       class="w-5 h-5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                                                <div class="ml-3">
                                                    <span class="block text-sm font-medium text-slate-900">{{ $produto->nome }}</span>
                                                    @if($produto->organico)
                                                        <span class="inline-flex items-center gap-1 text-xs font-medium text-emerald-600">
                                                            <i class="fas fa-leaf"></i> Orgânico
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-4">
                                                <div class="flex items-center gap-2" onclick="event.stopPropagation();">
                                                    <label for="qtde_{{ $produto->id }}" class="text-xs text-slate-500 font-medium">Estoque:</label>
                                                    <input type="number" name="quantidades[{{ $produto->id }}]" id="qtde_{{ $produto->id }}" value="{{ old('quantidades.'.$produto->id, in_array($produto->id, $produtosFeiraIds) ? $feira->produtos->find($produto->id)->pivot->quantidade_disponivel : 0) }}" min="0" class="form-input w-20 py-1 px-2 text-sm text-center rounded-lg border-slate-300 shadow-sm" placeholder="0">
                                                </div>
                                                <span class="text-sm font-bold text-slate-700">R$ {{ number_format($produto->preco, 2, ',', '.') }}<span class="text-xs font-normal text-slate-500">/{{ $produto->unidade_medida }}</span></span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="text-center py-6 bg-slate-50 rounded-xl border border-slate-200 border-dashed">
                                <i class="fas fa-box-open text-3xl text-slate-400 mb-2"></i>
                                <p class="text-slate-600">Você ainda não possui produtos cadastrados.</p>
                                <a href="{{ route('produtos.create') }}" class="text-emerald-600 font-medium hover:text-emerald-700 inline-block mt-2">Cadastre seu primeiro produto</a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="btn-primary text-lg px-8 py-3 flex items-center gap-2">
                        <i class="fas fa-save"></i> Atualizar Feira
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
