@extends('layouts.app')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="flex text-sm text-slate-500 mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('produtos.index') }}" class="hover:text-emerald-600 transition-colors flex items-center gap-1">
                        <i class="fas fa-store"></i> Produtos
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-xs mx-2"></i>
                        <span class="text-slate-900 font-medium">{{ $produto->nome }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
                
                <!-- Coluna Imagem -->
                <div class="bg-slate-100 relative min-h-[300px] md:min-h-full flex items-center justify-center">
                    @if($produto->foto)
                        <img src="{{ asset('storage/' . $produto->foto) }}" alt="{{ $produto->nome }}" 
                             class="absolute inset-0 w-full h-full object-cover">
                    @else
                        <i class="fas fa-leaf text-8xl text-emerald-200"></i>
                    @endif
                    
                    <div class="absolute top-4 left-4 flex flex-col gap-2">
                        @if($produto->organico)
                            <span class="bg-emerald-500 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg flex items-center gap-2 backdrop-blur-sm bg-opacity-95">
                                <i class="fas fa-check-circle"></i> Produto Orgânico
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Coluna Detalhes -->
                <div class="p-8 lg:p-12 flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">{{ $produto->nome }}</h1>
                        
                        @auth
                            @if(auth()->user()->isProdutor() && auth()->user()->produtor->id === $produto->produtor_id)
                                <a href="{{ route('produtos.edit', $produto->id) }}" class="bg-amber-100 text-amber-700 hover:bg-amber-200 w-10 h-10 rounded-full flex items-center justify-center transition-colors" title="Editar Produto">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endif
                        @endauth
                    </div>

                    <div class="flex items-center gap-4 mb-6 pb-6 border-b border-slate-100">
                        <div class="flex items-center gap-2 text-slate-600">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                                <i class="fas fa-tractor text-xs"></i>
                            </div>
                            <span class="font-medium">{{ $produto->produtor->user->name ?? 'Produtor' }}</span>
                        </div>
                        
                        <div class="w-px h-6 bg-slate-200"></div>

                        <div class="flex items-center gap-2 text-slate-600">
                            @if($produto->disponivel)
                                <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                <span class="font-medium text-emerald-600">Disponível</span>
                            @else
                                <div class="w-2 h-2 rounded-full bg-rose-500"></div>
                                <span class="font-medium text-rose-600">Indisponível</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-8 flex-grow">
                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-2">Descrição</h3>
                        <p class="text-slate-600 leading-relaxed">
                            {{ $produto->descricao ?? 'Nenhuma descrição detalhada fornecida pelo produtor.' }}
                        </p>
                    </div>

                    <div class="mt-auto bg-slate-50 p-6 rounded-2xl border border-slate-100">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                            <div>
                                <p class="text-sm text-slate-500 font-medium mb-1">Preço unitário</p>
                                <div class="flex items-end gap-1">
                                    <span class="text-xl font-bold text-slate-400">R$</span>
                                    <span class="text-4xl font-black text-slate-900 tracking-tight">{{ number_format($produto->preco, 2, ',', '.') }}</span>
                                    <span class="text-slate-500 font-medium mb-1">/{{ $produto->unidade_medida }}</span>
                                </div>
                            </div>
                            
                            @auth
                                @if(auth()->user()->isConsumidor())
                                    <form action="{{ route('carrinho.store') }}" method="POST" class="w-full sm:w-auto flex flex-col gap-3">
                                        @csrf
                                        <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                                        
                                        @php
                                            $feiras = $produto->feiras;
                                        @endphp
                                        
                                        <div class="relative w-full">
                                            <label class="block text-xs font-bold text-slate-500 mb-1 uppercase tracking-wider">Escolha a Feira para Retirada</label>
                                            <select name="feira_id" class="w-full text-sm py-3 pl-4 pr-10 border border-slate-200 rounded-xl bg-white focus:ring-emerald-500 focus:border-emerald-500 appearance-none shadow-sm font-medium text-slate-700" required>
                                                @if($feiras && $feiras->count() > 0)
                                                    <option value="" disabled selected hidden>Selecione uma feira...</option>
                                                    @foreach($feiras as $feira)
                                                        @if($feira->ativa ?? true)
                                                            @php
                                                                $isPast = $feira->data_fim < now();
                                                            @endphp
                                                            <option value="{{ $feira->id }}" {{ $isPast ? 'disabled' : '' }}>
                                                                {{ $feira->nome }} ({{ optional($feira->data_inicio)->format('d/m/Y') }}) {{ $isPast ? '- Indisponível' : '' }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <option value="">Nenhuma feira disponível</option>
                                                @endif
                                            </select>
                                            <div class="pointer-events-none absolute bottom-0 right-0 top-6 flex items-center px-4 text-slate-500">
                                                <i class="fas fa-chevron-down text-sm"></i>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3 w-full">
                                            @if($produto->disponivel)
                                                <div class="flex items-center border border-slate-200 rounded-xl bg-white overflow-hidden w-24 flex-shrink-0">
                                                    <button type="button" onclick="document.getElementById('qtd').stepDown()" class="px-3 py-3 text-slate-500 hover:bg-slate-50 hover:text-emerald-600 transition-colors">
                                                        <i class="fas fa-minus text-xs"></i>
                                                    </button>
                                                    <input type="number" name="quantidade" id="qtd" value="1" min="1" max="99" class="w-full text-center border-0 p-0 focus:ring-0 font-bold text-slate-700 bg-transparent" readonly>
                                                    <button type="button" onclick="document.getElementById('qtd').stepUp()" class="px-3 py-3 text-slate-500 hover:bg-slate-50 hover:text-emerald-600 transition-colors">
                                                        <i class="fas fa-plus text-xs"></i>
                                                    </button>
                                                </div>
                                                <button type="submit" class="btn-primary flex-1 py-3 px-6 flex items-center justify-center gap-2 whitespace-nowrap shadow-lg shadow-emerald-600/20">
                                                    <i class="fas fa-cart-plus"></i> Comprar
                                                </button>
                                            @else
                                                <button type="button" disabled class="bg-slate-200 text-slate-500 py-3 px-6 rounded-xl font-bold w-full cursor-not-allowed flex items-center justify-center gap-2">
                                                    Produto Indisponível
                                                </button>
                                            @endif
                                        </div>
                                    </form>
                                @endif
                                
                                @if(auth()->user()->isProdutor() && auth()->user()->produtor->id !== $produto->produtor_id)
                                    <p class="text-sm text-amber-600 bg-amber-50 px-4 py-2 rounded-lg font-medium">Logue-se como consumidor para comprar.</p>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn-secondary whitespace-nowrap px-8">
                                    Faça login para comprar
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection