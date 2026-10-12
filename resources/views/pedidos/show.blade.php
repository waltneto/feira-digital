@extends('layouts.app')

@section('content')
<div class="py-12 flex-grow flex flex-col items-center">
    <div class="max-w-4xl w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-3xl font-bold text-slate-800">Detalhes do Pedido</h1>
            <a href="{{ route('pedidos.index') }}" class="btn-secondary flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Meus Pedidos
            </a>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
                <i class="fas fa-check-circle text-emerald-500 text-xl"></i>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="card-premium overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-600 to-emerald-500 px-8 py-6 text-white flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <p class="text-emerald-100 text-sm mb-1">Código do Pedido</p>
                    <h2 class="text-2xl font-bold">#{{ $pedido->codigo_pedido }}</h2>
                </div>
                <div class="text-left md:text-right">
                    <p class="text-emerald-100 text-sm mb-1">Status</p>
                    @if($pedido->status == 'pendente')
                        <span class="inline-flex items-center gap-1 bg-amber-400 text-amber-900 px-3 py-1 rounded-full text-sm font-bold shadow-sm">
                            <i class="fas fa-clock"></i> Aguardando Pagamento
                        </span>
                    @elseif($pedido->status == 'pago')
                        <span class="inline-flex items-center gap-1 bg-white text-emerald-600 px-3 py-1 rounded-full text-sm font-bold shadow-sm">
                            <i class="fas fa-check-circle"></i> Pagamento Confirmado
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-sm font-bold shadow-sm">
                            {{ ucfirst($pedido->status) }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 border-b border-slate-100 pb-8">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-info-circle text-emerald-500"></i> Informações da Feira
                        </h3>
                        <p class="text-slate-600"><span class="font-medium text-slate-800">Feira:</span> {{ $pedido->feira->nome ?? 'N/A' }}</p>
                        <p class="text-slate-600"><span class="font-medium text-slate-800">Localização:</span> {{ $pedido->feira->cidade ?? 'Não Informado' }}</p>
                        <p class="text-slate-600"><span class="font-medium text-slate-800">Data do Pedido:</span> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                        @if($pedido->horario_retirada)
                            <p class="text-slate-600"><span class="font-medium text-emerald-600">Horário Previsto p/ Retirada:</span> <span class="font-bold text-emerald-700">{{ \Carbon\Carbon::parse($pedido->horario_retirada)->format('H:i') }}</span></p>
                        @endif
                    </div>
                </div>

                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-shopping-basket text-emerald-500"></i> Itens do Pedido
                </h3>
                
                <div class="overflow-x-auto bg-white rounded-xl border border-slate-100 mb-8">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100 text-sm font-semibold text-slate-600">
                                <th class="p-4">Produto</th>
                                <th class="p-4 text-center">Qtd</th>
                                <th class="p-4 text-right">Preço Unit.</th>
                                <th class="p-4 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($pedido->items as $item)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="p-4 flex items-center gap-3">
                                        @if($item->produto->foto)
                                            <img src="{{ asset('storage/' . $item->produto->foto) }}" class="w-10 h-10 object-cover rounded-lg shadow-sm" alt="{{ $item->produto->nome }}">
                                        @else
                                            <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400">
                                                <i class="fas fa-leaf"></i>
                                            </div>
                                        @endif
                                        <span class="font-medium text-slate-800">{{ $item->produto->nome }}</span>
                                    </td>
                                    <td class="p-4 text-center text-slate-600">{{ $item->quantidade }}</td>
                                    <td class="p-4 text-right text-slate-600">R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}</td>
                                    <td class="p-4 text-right font-medium text-slate-800">R$ {{ number_format($item->quantidade * $item->preco_unitario, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-emerald-50/50">
                            <tr>
                                <td colspan="3" class="p-4 text-right font-bold text-slate-800 text-lg">Total Geral</td>
                                <td class="p-4 text-right font-bold text-emerald-600 text-xl">R$ {{ number_format($pedido->total, 2, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($pedido->status == 'pendente')
                    <div class="bg-amber-50 rounded-2xl p-8 border border-amber-200">
                        <div class="flex flex-col md:flex-row gap-8 items-center md:items-start p-4">
                            <div class="w-full md:w-1/3 flex flex-col items-center justify-center">
                                <div class="w-20 h-20 bg-amber-100 rounded-full flex items-center justify-center text-amber-500 mb-4 shadow-sm border border-amber-200">
                                    <i class="fas fa-store text-3xl"></i>
                                </div>
                                <h4 class="font-bold text-amber-800 text-center">Pagamento na Retirada</h4>
                            </div>
                            
                            <div class="w-full md:w-2/3">
                                <h4 class="font-bold text-amber-800 mb-2">Instruções para Retirada</h4>
                                <ul class="space-y-3 mb-6">
                                    <li class="flex gap-2 text-amber-700">
                                        <i class="fas fa-check-circle mt-1"></i>
                                        <span>Dirija-se até a <strong>{{ $pedido->feira->nome ?? 'Feira' }}</strong> no dia e horário informados.</span>
                                    </li>
                                    <li class="flex gap-2 text-amber-700">
                                        <i class="fas fa-check-circle mt-1"></i>
                                        <span>Apresente o <strong>Código do Pedido (#{{ $pedido->codigo_pedido }})</strong> ao produtor.</span>
                                    </li>
                                    <li class="flex gap-2 text-amber-700">
                                        <i class="fas fa-check-circle mt-1"></i>
                                        <span>Efetue o pagamento de <strong>R$ {{ number_format($pedido->total, 2, ',', '.') }}</strong> presencialmente (Dinheiro, PIX ou Cartão suportado pelo produtor).</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection