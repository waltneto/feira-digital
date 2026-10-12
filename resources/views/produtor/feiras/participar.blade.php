@extends('layouts.app')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Meus Produtos na Feira</h2>
                <p class="mt-2 text-sm text-slate-500">{{ $feira->nome }} - {{ \Carbon\Carbon::parse($feira->data_inicio)->format('d/m/Y') }}</p>
            </div>
            <a href="{{ route('produtor.feiras.participacao') }}" class="btn-secondary flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <form action="{{ route('produtor.feiras.update', $feira->id) }}" method="POST" class="p-8">
                @csrf
                @method('PUT')

                <div class="flex items-center justify-between mb-6">
                    <h4 class="text-lg font-bold text-slate-800">Selecione os produtos que irá oferecer</h4>
                    <span class="text-xs bg-emerald-100 text-emerald-800 py-1 px-3 rounded-lg font-medium">{{ count($produtos) }} produtos no seu catálogo</span>
                </div>
                
                @if(count($produtos) > 0)
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 overflow-y-auto" style="max-height: 500px;">
                        <div class="space-y-3">
                            @php
                                $produtosFeiraIds = $feira->produtos()->where('produtor_id', Auth::user()->produtor->id)->pluck('produtos.id')->toArray();
                            @endphp
                            @foreach($produtos as $produto)
                                <label class="flex items-center justify-between p-4 rounded-xl bg-white border border-slate-200 hover:border-emerald-300 hover:shadow-sm cursor-pointer transition-all">
                                    <div class="flex items-center gap-4">
                                        <input type="checkbox" name="produtos[]" value="{{ $produto->id }}" 
                                                {{ in_array($produto->id, old('produtos', $produtosFeiraIds)) ? 'checked' : '' }}
                                                class="w-6 h-6 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                                        
                                        @if($produto->foto)
                                            <div class="w-12 h-12 rounded-lg bg-slate-100 overflow-hidden flex-shrink-0">
                                                <img src="{{ Storage::url($produto->foto) }}" alt="{{ $produto->nome }}" class="w-full h-full object-cover">
                                            </div>
                                        @else
                                            <div class="w-12 h-12 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-image text-slate-300 text-xl"></i>
                                            </div>
                                        @endif

                                        <div>
                                            <span class="block text-base font-bold text-slate-900">{{ $produto->nome }}</span>
                                            @if($produto->organico)
                                                <span class="inline-flex items-center gap-1 text-xs font-medium text-emerald-600 mt-1">
                                                    <i class="fas fa-leaf"></i> Orgânico
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-6">
                                        <div class="flex flex-col items-end" onclick="event.stopPropagation();">
                                            <label for="qtde_{{ $produto->id }}" class="text-xs text-slate-500 font-medium mb-1">Quantidade Disp.:</label>
                                            <input type="number" name="quantidades[{{ $produto->id }}]" id="qtde_{{ $produto->id }}" 
                                                    value="{{ old('quantidades.'.$produto->id, in_array($produto->id, $produtosFeiraIds) ? $feira->produtos->find($produto->id)->pivot->quantidade_disponivel : 0) }}" 
                                                    min="0" class="form-input w-24 py-1.5 px-3 text-center rounded-lg border-slate-300 shadow-sm">
                                        </div>
                                        <div class="text-right w-24">
                                            <span class="text-sm font-bold text-slate-700 block">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
                                            <span class="text-xs font-normal text-slate-500">/{{ $produto->unidade_medida }}</span>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="text-center py-10 bg-slate-50 rounded-xl border border-slate-200 border-dashed">
                        <i class="fas fa-box-open text-4xl text-slate-400 mb-3"></i>
                        <p class="text-slate-600 font-medium">Você ainda não possui produtos cadastrados.</p>
                        <a href="{{ route('produtos.create') }}" class="btn-primary inline-flex items-center gap-2 mt-4">
                            <i class="fas fa-plus"></i> Cadastrar Produto
                        </a>
                    </div>
                @endif

                <div class="pt-8 mt-6 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="btn-primary text-lg px-8 py-3 flex items-center gap-2" {{ count($produtos) == 0 ? 'disabled' : '' }}>
                        <i class="fas fa-save"></i> Salvar Participação
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
