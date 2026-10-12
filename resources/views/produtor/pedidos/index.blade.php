@extends('layouts.app')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Pedidos Recebidos</h1>
                <p class="text-slate-500 mt-2">Gerencie as vendas realizadas nas suas feiras.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="btn-secondary flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Voltar ao Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 text-emerald-800 p-4 border border-emerald-200 rounded-xl mb-6 flex items-center gap-3">
                <i class="fas fa-check-circle text-emerald-500 text-xl"></i>
                <p>{{ session('success') }}</p>
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-rose-50 text-rose-800 p-4 border border-rose-200 rounded-xl mb-6 flex items-center gap-3">
                <i class="fas fa-exclamation-circle text-rose-500 text-xl"></i>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @if($pedidos->count() > 0)
            <div class="grid gap-6">
                @foreach($pedidos as $pedido)
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="bg-slate-50 px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between border-b border-slate-200 gap-4">
                            <div>
                                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 block">Pedido #{{ $pedido->codigo_pedido }}</span>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center text-slate-600 font-bold">
                                        {{ substr($pedido->consumidor->user->name ?? 'A', 0, 1) }}
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-800 text-lg">{{ $pedido->consumidor->user->name ?? 'Consumidor Anônimo' }}</h3>
                                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 mt-1">
                                            <p class="text-sm text-slate-500">
                                                <i class="far fa-calendar-alt w-4 text-center"></i> {{ $pedido->created_at->format('d/m/Y H:i') }}
                                            </p>
                                            @if($pedido->horario_retirada)
                                                <p class="text-sm text-emerald-700 font-bold bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100 inline-flex items-center gap-1 w-fit">
                                                    <i class="far fa-clock"></i> Retirada: {{ \Carbon\Carbon::parse($pedido->horario_retirada)->format('H:i') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-left sm:text-right">
                                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 block">Status</span>
                                @if($pedido->status == 'pendente')
                                    <span class="inline-flex items-center gap-1.5 bg-amber-100 text-amber-700 font-bold px-3 py-1 rounded-full text-sm">
                                        <i class="fas fa-clock text-xs"></i> Pendente
                                    </span>
                                @elseif($pedido->status == 'entregue')
                                    <span class="inline-flex items-center gap-1.5 bg-emerald-100 text-emerald-700 font-bold px-3 py-1 rounded-full text-sm">
                                        <i class="fas fa-check-circle text-xs"></i> Entregue (Pago)
                                    </span>
                                @elseif($pedido->status == 'cancelado')
                                    <span class="inline-flex items-center gap-1.5 bg-rose-100 text-rose-700 font-bold px-3 py-1 rounded-full text-sm">
                                        <i class="fas fa-times-circle text-xs"></i> Cancelado
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-700 font-bold px-3 py-1 rounded-full text-sm">
                                        {{ ucfirst($pedido->status) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <h4 class="font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100">Itens Solicitados (Feira: {{ $pedido->feira->nome }})</h4>
                            <div class="space-y-3 mb-6">
                                @foreach($pedido->items as $item)
                                    <div class="flex justify-between items-center text-sm md:text-base border-b border-slate-50 pb-3 last:border-0">
                                        <div class="flex items-center gap-3">
                                            @if($item->produto->foto)
                                                <img src="{{ asset('storage/' . $item->produto->foto) }}" class="w-10 h-10 object-cover rounded shadow-sm">
                                            @else
                                                <div class="w-10 h-10 bg-slate-100 rounded flex items-center justify-center text-slate-400">
                                                    <i class="fas fa-leaf"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <span class="font-bold text-slate-700 block">{{ $item->produto->nome }}</span>
                                                <span class="text-slate-500 text-sm">{{ $item->quantidade }} {{ $item->produto->unidade_medida }}(s) x R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}</span>
                                            </div>
                                        </div>
                                        <div class="font-bold text-slate-800">
                                            R$ {{ number_format($item->quantidade * $item->preco_unitario, 2, ',', '.') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="flex flex-col sm:flex-row justify-between items-center mt-6 pt-6 border-t border-slate-100 gap-4">
                                <div class="text-xl">
                                    <span class="text-slate-500 font-medium">Total:</span> 
                                    <span class="font-black text-emerald-600 text-2xl ml-2">R$ {{ number_format($pedido->total, 2, ',', '.') }}</span>
                                </div>
                                
                                @if($pedido->status == 'pendente')
                                    <div class="flex flex-col sm:flex-row gap-2">
                                        <form action="{{ route('produtor.pedidos.cancelar', $pedido->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-white border border-rose-200 hover:bg-rose-50 text-rose-600 font-bold py-3 px-6 rounded-xl transition-all flex items-center justify-center gap-2 w-full sm:w-auto" onclick="return confirm('Tem certeza que deseja cancelar este pedido? O cliente não veio buscar?');">
                                                <i class="fas fa-times"></i> Cancelar Pedido
                                            </button>
                                        </form>
                                        <form action="{{ route('produtor.pedidos.concluir', $pedido->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-emerald-600/20 transition-all flex items-center justify-center gap-2 w-full sm:w-auto" onclick="return confirm('Tem certeza que deseja confirmar recebimento e baixar do estoque?');">
                                                <i class="fas fa-check-double"></i> Concluir Venda
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-8">
                {{ $pedidos->links() }}
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-3xl border border-slate-100 shadow-sm mt-8">
                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
                    <i class="fas fa-clipboard-list text-4xl"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900">Nenhum pedido encontrado</h3>
                <p class="mt-2 text-slate-500 max-w-md mx-auto">
                    No momento não há nenhum pedido registrado para as suas feiras.
                </p>
            </div>
        @endif
    </div>
</div>
@endsection
