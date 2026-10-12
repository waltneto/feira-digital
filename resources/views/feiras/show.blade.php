@extends('layouts.app')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Feira Header -->
        <div class="bg-white rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 mb-12 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 transform translate-x-1/2 -translate-y-1/2"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600">
                            <i class="fas fa-store text-2xl"></i>
                        </div>
                        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $feira->nome }}</h1>
                    </div>
                    <p class="text-slate-600 max-w-2xl mt-4 text-lg">{{ $feira->descricao }}</p>
                    
                    <div class="flex flex-wrap gap-4 mt-6">
                        <div class="flex items-center gap-2 text-slate-600 bg-slate-50 px-4 py-2 rounded-xl border border-slate-100">
                            <i class="far fa-calendar-alt text-emerald-500"></i>
                            <span class="font-medium">{{ $feira->data_inicio->format('d/m/Y H:i') }} - {{ $feira->data_fim->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-slate-600 bg-slate-50 px-4 py-2 rounded-xl border border-slate-100">
                            <i class="fas fa-map-marker-alt text-emerald-500"></i>
                            <span class="font-medium">{{ $feira->endereco }}, {{ $feira->cidade }}/{{ $feira->estado }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3 shrink-0 w-full md:w-auto mt-6 md:mt-0">
                    @can('update', $feira)
                        <a href="{{ route('feiras.edit', $feira->id) }}" class="btn-primary flex items-center justify-center gap-2 shadow-md">
                            <i class="fas fa-edit"></i> Gerenciar Feira
                        </a>
                    @endcan
                    <a href="{{ route('feiras.index') }}" class="btn-secondary flex items-center justify-center gap-2">
                        <i class="fas fa-arrow-left"></i> Voltar às Feiras
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center md:text-left mb-8">
            <h2 class="text-2xl font-bold text-slate-800">Produtos Disponíveis nesta Feira</h2>
            <p class="text-slate-500 mt-1">Navegue pelos produtos oferecidos pelos produtores locais.</p>
        </div>

        <!-- Produtos Grid -->
        @if($feira->produtos->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($feira->produtos as $produto)
                    <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden hover:shadow-xl hover:shadow-emerald-900/5 transition-all duration-300 group flex flex-col">
                        <!-- Imagem -->
                        <div class="h-48 bg-slate-100 relative overflow-hidden">
                            @if($produto->foto)
                                <img src="{{ asset('storage/' . $produto->foto) }}" alt="{{ $produto->nome }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 {{ !($produto->pivot->quantidade_disponivel > 0 ?? true) ? 'grayscale' : '' }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-emerald-50 text-emerald-200 group-hover:bg-emerald-100 transition-colors duration-500">
                                    <i class="fas fa-leaf text-5xl"></i>
                                </div>
                            @endif
                            
                            @if($produto->organico)
                                <div class="absolute top-3 left-3 flex flex-col gap-2">
                                    <span class="bg-emerald-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-sm flex items-center gap-1 backdrop-blur-sm bg-opacity-90">
                                        <i class="fas fa-check-circle"></i> Orgânico
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Card Body -->
                        <div class="p-5 flex flex-col flex-grow text-left">
                            <div class="mb-2">
                                <h3 class="text-lg font-bold text-slate-900 line-clamp-1 group-hover:text-emerald-700 transition-colors" title="{{ $produto->nome }}">
                                    {{ $produto->nome }}
                                </h3>
                                <p class="text-xs text-slate-500 mt-1 flex items-center gap-1 line-clamp-1">
                                    <i class="fas fa-store text-emerald-500"></i> {{ $produto->produtor->user->name ?? 'Produtor' }}
                                </p>
                            </div>
                            
                            <p class="text-slate-600 text-sm mb-4 line-clamp-2 min-h-[40px]">
                                {{ $produto->descricao ?? 'Sem descrição adicional.' }}
                            </p>
                            
                            <div class="mt-auto flex items-end justify-between pt-4 border-t border-slate-50">
                                <div>
                                    <span class="text-2xl font-black text-slate-900 tracking-tight">
                                        <span class="text-sm font-bold text-slate-500 mr-0.5">R$</span>{{ number_format($produto->preco, 2, ',', '.') }}
                                    </span>
                                    <span class="text-sm text-slate-500 font-medium">/{{ $produto->unidade_medida }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Ações (Footer do Card) -->
                        <div class="p-2 bg-slate-50 border-t border-slate-100 flex flex-col gap-2">
                            <div class="px-2 pt-2 text-sm text-slate-500 text-center font-medium">
                                Quantidade: <span class="text-emerald-600">{{ $produto->pivot->quantidade_disponivel ?? 'Indisponível' }} {{ $produto->unidade_medida }}s</span>
                            </div>
                            @can('update', $feira)
                                <form action="{{ route('feiras.estoque.update', ['feira' => $feira->id, 'produto' => $produto->id]) }}" method="POST" class="flex items-center gap-2 px-2 pb-2 mt-1">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantidade_disponivel" class="form-input rounded-xl border-slate-200 w-20 py-2.5 text-center shadow-sm" value="{{ $produto->pivot->quantidade_disponivel ?? 0 }}" min="0" title="Quantidade">
                                    <button type="submit" class="flex-1 bg-amber-500 hover:bg-amber-600 text-white py-2.5 rounded-xl transition-colors shadow-sm font-medium flex items-center justify-center gap-2" title="Atualizar Quantidade">
                                        <i class="fas fa-sync-alt"></i> <span class="hidden sm:inline">Atualizar</span>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('carrinho.store') }}" method="POST" class="flex items-center gap-2 px-2 pb-2 mt-1">
                                    @csrf
                                    <input type="hidden" name="feira_id" value="{{ $feira->id }}">
                                    <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                                    
                                    <input type="number" name="quantidade" id="quantidade" class="form-input rounded-xl border-slate-200 w-20 py-2.5 text-center shadow-sm" value="1" min="1" max="{{ $produto->pivot->quantidade_disponivel ?? 10 }}">
                                    
                                    <button type="submit" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white py-2.5 rounded-xl transition-colors shadow-sm font-medium flex items-center justify-center gap-2" title="Adicionar">
                                        <i class="fas fa-plus"></i> <span class="hidden sm:inline">Adicionar</span>
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Sem Produtos -->
            <div class="text-center py-16 bg-white rounded-3xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] mt-4">
                <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-4 text-emerald-300">
                    <i class="fas fa-box-open text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800">Nenhum produto cadastrado</h3>
                <p class="text-slate-500 mt-2">Esta feira ainda não possui produtos disponíveis para venda.</p>
            </div>
        @endif
    </div>
</div>
@endsection