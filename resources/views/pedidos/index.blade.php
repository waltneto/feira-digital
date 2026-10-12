@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-3xl font-bold text-slate-800">Meus Pedidos</h1>
            <a href="{{ route('dashboard') }}" class="btn-secondary flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Voltar ao Dashboard
            </a>
        </div>

        @if($pedidos->isEmpty())
            <div class="bg-white p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-box-open text-3xl text-slate-300"></i>
                </div>
                <h2 class="text-xl font-semibold text-slate-700 mb-2">Você ainda não tem pedidos</h2>
                <p class="text-slate-500 mb-6">Explore nossas feiras e adicione produtos ao seu carrinho.</p>
                <a href="{{ route('feiras.index') }}" class="btn-primary inline-flex items-center gap-2">
                    <i class="fas fa-store"></i> Ver Feiras
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 gap-6">
                @foreach ($pedidos as $pedido)
                    <div class="card-premium">
                        <div class="p-6 flex flex-col md:flex-row md:items-center justify-between gap-6 border-b border-slate-100">
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <h2 class="text-xl font-bold text-slate-800">Pedido #{{ $pedido->codigo_pedido }}</h2>
                                    @if($pedido->status == 'pendente')
                                        <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-sm font-semibold border border-amber-200">
                                            <i class="fas fa-clock mr-1"></i> Pendente
                                        </span>
                                    @elseif($pedido->status == 'pago')
                                        <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-sm font-semibold border border-emerald-200">
                                            <i class="fas fa-check-circle mr-1"></i> Pago
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-sm font-semibold border border-slate-200">
                                            {{ ucfirst($pedido->status) }}
                                        </span>
                                    @endif
                                </div>
                                <div class="flex flex-col sm:flex-row gap-2 sm:gap-4 mt-2 mb-1">
                                    <p class="text-slate-500 text-sm">
                                        <i class="fas fa-calendar-alt mr-1"></i> Realizado em {{ $pedido->created_at->format('d/m/Y H:i') }}
                                    </p>
                                    @if($pedido->horario_retirada)
                                        <p class="text-emerald-700 text-sm font-semibold bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100 inline-flex items-center gap-1 w-fit">
                                            <i class="fas fa-clock"></i> Retirada: {{ \Carbon\Carbon::parse($pedido->horario_retirada)->format('H:i') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="flex flex-col md:items-end gap-1">
                                <p class="text-slate-500 text-sm">Feira:</p>
                                <p class="font-semibold text-slate-800">
                                    <i class="fas fa-store text-emerald-500 mr-1"></i> {{ $pedido->feira->nome ?? 'Feira Indisponível' }}
                                </p>
                            </div>
                        </div>

                        <div class="bg-slate-50/50 p-6 flex items-center justify-between flex-wrap gap-4">
                            <div>
                                <p class="text-slate-500 text-sm mb-1">Total do Pedido</p>
                                <p class="text-2xl font-bold text-emerald-600">
                                    R$ {{ number_format($pedido->total, 2, ',', '.') }}
                                </p>
                            </div>
                            
                            <a href="{{ route('pedidos.show', $pedido) }}" class="btn-primary">
                                <i class="fas fa-eye mr-2"></i> Ver Detalhes
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $pedidos->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
