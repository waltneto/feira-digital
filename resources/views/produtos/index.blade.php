@extends('layouts.app')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Produtos Disponíveis</h1>
                <p class="text-slate-500 mt-2">Encontre produtos frescos e saudáveis das nossas feiras locais.</p>
            </div>
            
            <div class="flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto">
                <!-- Select de Ordenação -->
                <div class="relative w-full sm:w-auto">
                    <select id="ordenacao" class="form-input appearance-none bg-white pr-10 cursor-pointer min-w-[200px]">
                        <option value="nome">Ordenar por nome (A-Z)</option>
                        <option value="preco_asc">Preço: menor para maior</option>
                        <option value="preco_desc">Preço: maior para menor</option>
                        <option value="recentes">Mais recentes</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                        <i class="fas fa-chevron-down text-sm"></i>
                    </div>
                </div>
                
                @auth
                    @if(auth()->user()->isProdutor())
                        <a href="{{ route('produtos.create') }}" class="btn-primary w-full sm:w-auto flex justify-center items-center gap-2 whitespace-nowrap">
                            <i class="fas fa-plus"></i> Novo Produto
                        </a>
                    @endif
                @endauth
            </div>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 text-emerald-800 p-4 rounded-xl mb-6 border border-emerald-100 flex items-center gap-3">
                <i class="fas fa-check-circle text-emerald-500 text-xl"></i>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Barra de Busca -->
        <div class="mb-8">
            <form action="{{ route('produtos.search') }}" method="GET" class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fas fa-search text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                </div>
                <input type="text" name="q" value="{{ request('q') }}"
                       placeholder="Buscar produtos orgânicos, frutas, verduras..." 
                       class="form-input w-full pl-12 py-4 text-lg bg-white shadow-sm border-slate-200">
                <button type="submit" class="absolute right-2 top-2 bottom-2 bg-emerald-600 hover:bg-emerald-700 text-white px-6 rounded-xl font-medium transition-colors">
                    Buscar
                </button>
            </form>
        </div>

        <!-- Lista de Produtos -->
        @if($produtos->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($produtos as $produto)
                    <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden hover:shadow-xl hover:shadow-emerald-900/5 transition-all duration-300 group flex flex-col">
                        <!-- Imagem -->
                        <div class="h-48 bg-slate-100 relative overflow-hidden">
                            @if($produto->foto)
                                <img src="{{ asset('storage/' . $produto->foto) }}" alt="{{ $produto->nome }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 {{ !$produto->disponivel ? 'grayscale' : '' }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-emerald-50 text-emerald-200 group-hover:bg-emerald-100 transition-colors duration-500">
                                    <i class="fas fa-leaf text-5xl"></i>
                                </div>
                            @endif
                            
                            <!-- Badges Topo -->
                            <div class="absolute top-3 left-3 flex flex-col gap-2">
                                @if($produto->organico)
                                    <span class="bg-emerald-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-sm flex items-center gap-1 backdrop-blur-sm bg-opacity-90">
                                        <i class="fas fa-check-circle"></i> Orgânico
                                    </span>
                                @endif
                            </div>
                            
                            <div class="absolute top-3 right-3">
                                @unless($produto->disponivel)
                                    <span class="bg-rose-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-sm backdrop-blur-sm bg-opacity-90">
                                        Indisponível
                                    </span>
                                @endunless
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-5 flex flex-col flex-grow">
                            <div class="mb-2">
                                <h3 class="text-lg font-bold text-slate-900 line-clamp-1 group-hover:text-emerald-700 transition-colors" title="{{ $produto->nome }}">
                                    {{ $produto->nome }}
                                </h3>
                                <p class="text-xs text-slate-500 mt-1 flex items-center gap-1 line-clamp-1">
                                    <i class="fas fa-store text-emerald-500"></i> {{ $produto->produtor->user->name ?? 'Produtor Local' }}
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
                        <div class="p-3 bg-slate-50 border-t border-slate-100 flex flex-col gap-2">
                            @auth
                                @if(auth()->user()->isProdutor() && auth()->user()->produtor->id === $produto->produtor_id)
                                    <div class="flex gap-2">
                                        <a href="{{ route('produtos.show', $produto->id) }}" class="flex-1 bg-white hover:bg-emerald-50 border border-slate-200 text-emerald-700 text-center py-2.5 rounded-xl text-sm font-bold transition-colors">
                                            Detalhes
                                        </a>
                                        <a href="{{ route('produtos.edit', $produto->id) }}" class="bg-white hover:bg-amber-50 border border-slate-200 text-amber-600 px-4 py-2.5 rounded-xl hover:border-amber-200 transition-colors" title="Editar Produto">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('produtos.destroy', $produto->id) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir/desativar este produto?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-white hover:bg-rose-50 border border-slate-200 text-rose-600 px-4 py-2.5 rounded-xl hover:border-rose-200 transition-colors" title="Excluir Produto">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                @elseif(auth()->user()->isConsumidor() && $produto->disponivel)
                                    <form action="{{ route('carrinho.store') }}" method="POST" class="flex flex-col gap-2 w-full">
                                        @csrf
                                        <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                                        <input type="hidden" name="quantidade" value="1">
                                        
                                        @php
                                            $feiras = $produto->feiras;
                                        @endphp
                                        
                                        <div class="relative">
                                            <select name="feira_id" class="w-full text-xs py-2 pl-2 pr-8 border border-slate-200 rounded-xl bg-white focus:ring-emerald-500 focus:border-emerald-500 appearance-none shadow-sm" required>
                                                @if($feiras && $feiras->count() > 0)
                                                    <option value="" disabled selected hidden>Escolha a feira...</option>
                                                    @foreach($feiras as $feira)
                                                        @if($feira->ativa ?? true)
                                                            @php
                                                                $isPast = $feira->data_fim < now();
                                                            @endphp
                                                            <option value="{{ $feira->id }}" {{ $isPast ? 'disabled' : '' }}>
                                                                Retirar em: {{ $feira->nome }} ({{ optional($feira->data_inicio)->format('d/m') }}) {{ $isPast ? '- Indisponível' : '' }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <option value="">Nenhuma feira disponível</option>
                                                @endif
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                                                <i class="fas fa-chevron-down text-[10px]"></i>
                                            </div>
                                        </div>
                                        
                                        <div class="flex gap-2">
                                            <a href="{{ route('produtos.show', $produto->id) }}" class="flex-1 bg-white hover:bg-emerald-50 border border-slate-200 text-emerald-700 text-center py-2.5 rounded-xl text-sm font-bold transition-colors">
                                                Detalhes
                                            </a>
                                            <button type="submit" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white py-2.5 rounded-xl transition-colors shadow-sm text-sm font-bold" title="Adicionar ao Carrinho">
                                                <i class="fas fa-cart-plus"></i> Comprar
                                            </button>
                                        </div>
                                    </form>
                                @else
                                    <div class="flex gap-2">
                                        <a href="{{ route('produtos.show', $produto->id) }}" class="flex-1 bg-white hover:bg-emerald-50 border border-slate-200 text-emerald-700 text-center py-2.5 rounded-xl text-sm font-bold transition-colors">
                                            Detalhes
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="flex gap-2">
                                    <a href="{{ route('produtos.show', $produto->id) }}" class="flex-1 bg-white hover:bg-emerald-50 border border-slate-200 text-emerald-700 text-center py-2.5 rounded-xl text-sm font-bold transition-colors">
                                        Detalhes
                                    </a>
                                </div>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-10 mb-6">
                {{ $produtos->links() }}
            </div>
            
        @else
            <!-- Sem Resultados -->
            <div class="text-center py-16 bg-white rounded-3xl border border-slate-100 shadow-sm mt-8">
                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
                    <i class="fas fa-shopping-basket text-4xl"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900">Nenhum produto encontrado</h3>
                <p class="mt-2 text-slate-500 max-w-md mx-auto">
                    @if(request('q'))
                        Não encontramos nenhum produto que corresponda à busca "{{ request('q') }}". Tente usar outros termos.
                    @else
                        Ainda não há produtos cadastrados na plataforma. Volte em breve!
                    @endif
                </p>
                @if(request('q'))
                    <div class="mt-6">
                        <a href="{{ route('produtos.index') }}" class="btn-secondary inline-flex items-center gap-2">
                            <i class="fas fa-times"></i> Limpar Busca
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectOrdenacao = document.getElementById('ordenacao');
        
        // Seta o valor do select de acordo com a URL
        const urlParams = new URLSearchParams(window.location.search);
        if(urlParams.has('ordenar')) {
            selectOrdenacao.value = urlParams.get('ordenar');
        }
        
        selectOrdenacao.addEventListener('change', function() {
            const url = new URL(window.location.href);
            url.searchParams.set('ordenar', this.value);
            // Reseta a página para 1 quando muda a ordenação
            url.searchParams.delete('page');
            window.location.href = url.toString();
        });
    });
</script>
@endsection