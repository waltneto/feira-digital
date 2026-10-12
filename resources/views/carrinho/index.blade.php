@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-3xl font-bold text-slate-800">Meu Carrinho</h1>
            <a href="{{ url()->previous() }}" class="btn-secondary flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>

        @if($carrinhos->isEmpty())
            <div class="bg-white p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shopping-cart text-3xl text-slate-300"></i>
                </div>
                <h2 class="text-xl font-semibold text-slate-700 mb-2">Seu carrinho está vazio</h2>
                <p class="text-slate-500 mb-6">Que tal explorar nossos produtos frescos?</p>
                <a href="{{ route('produtos.index') }}" class="btn-primary inline-flex items-center gap-2">
                    <i class="fas fa-search"></i> Buscar Produtos
                </a>
            </div>
        @else
            @foreach ($carrinhos as $carrinho)
                <div class="card-premium mb-8">
                    <div class="bg-emerald-50/50 px-6 py-4 border-b border-emerald-100/50 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex flex-shrink-0 items-center justify-center">
                                <i class="fas fa-store text-emerald-600 text-lg"></i>
                            </div>
                            <h2 class="text-xl font-bold text-emerald-800">Feira: {{ $carrinho->feira->nome }}</h2>
                        </div>
                    </div>
                    
                    <div class="p-6 bg-white">
                        <div class="space-y-4">
                            @foreach ($carrinho->items as $item)
                                <div class="flex flex-col sm:flex-row items-center gap-6 p-4 rounded-2xl border border-slate-100 hover:border-emerald-200 transition-all duration-300 bg-white shadow-sm hover:shadow-md group">
                                    <div class="w-full sm:w-24 h-24 flex-shrink-0">
                                        @if($item->produto->foto)
                                            <img src="{{ asset('storage/' . $item->produto->foto) }}" alt="{{ $item->produto->nome }}" class="w-full h-full object-cover rounded-xl shadow-sm group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-full bg-slate-50 rounded-xl flex items-center justify-center shadow-sm border border-slate-100 group-hover:scale-105 transition-transform duration-300">
                                                <i class="fas fa-carrot text-2xl text-slate-300"></i>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="flex-grow text-center sm:text-left">
                                        <h5 class="text-lg font-bold text-slate-800 mb-1">{{ $item->produto->nome }}</h5>
                                        <div class="space-y-1">
                                            <p class="text-slate-500 text-sm">R$ {{ number_format($item->preco_unitario, 2, ',', '.') }} / un</p>
                                            <p class="text-emerald-600 font-bold text-xl">R$ {{ number_format($item->subtotal, 2, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex flex-wrap items-center justify-center sm:justify-end gap-3 w-full sm:w-auto mt-4 sm:mt-0">
                                        <form action="{{ route('carrinho.update', $item) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            @method('PUT')
                                            <div class="flex items-center bg-slate-50 rounded-xl border border-slate-200 overflow-hidden shadow-sm">
                                                <input type="number" name="quantidade" value="{{ $item->quantidade }}" min="1" class="w-16 px-2 py-2 text-center bg-transparent border-none focus:ring-emerald-500 text-slate-700 font-medium h-full focus:outline-none" onchange="this.form.submit()">
                                            </div>
                                        </form>
                                        
                                        <form action="{{ route('carrinho.destroy', $item) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-4 py-2 text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 rounded-xl transition-colors font-medium flex items-center justify-center gap-2 h-full">
                                                <i class="fas fa-trash-alt"></i> Remover
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="bg-slate-50/80 px-6 py-5 border-t border-slate-100 flex justify-between items-center flex-wrap gap-4">
                        <div class="flex items-center gap-6 flex-wrap">
                            <div class="text-slate-600 font-medium flex items-center gap-2">
                                <i class="fas fa-boxes text-slate-400"></i>
                                Total de itens: <span class="text-slate-900 font-bold bg-white px-3 py-1 rounded-lg shadow-sm border border-slate-200">{{ $carrinho->items->sum('quantidade') }}</span>
                            </div>
                            <div class="text-slate-700 font-medium text-lg flex items-center gap-2">
                                Total do Carrinho: <span class="text-emerald-700 font-black text-2xl">R$ {{ number_format($carrinho->total, 2, ',', '.') }}</span>
                            </div>
                        </div>
                        <form action="{{ route('pedidos.store') }}" method="POST" class="flex flex-col sm:flex-row items-center gap-4">
                            @csrf
                            <input type="hidden" name="feira_id" value="{{ $carrinho->feira_id }}">
                            <div class="flex items-center gap-3 w-full sm:w-auto">
                                <label for="horario_{{ $carrinho->feira_id }}" class="text-sm font-bold text-slate-700 flex-shrink-0">Horário de Retirada:</label>
                                <input type="time" name="horario_retirada" id="horario_{{ $carrinho->feira_id }}" required class="form-input rounded-xl border-slate-200 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition-all text-slate-700 w-32 py-2 px-3">
                            </div>
                            <button type="submit" class="btn-primary flex items-center justify-center gap-2 shadow-emerald-500/30 w-full sm:w-auto mt-2 sm:mt-0">
                                <i class="fas fa-check-circle"></i> Finalizar Pedido
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection