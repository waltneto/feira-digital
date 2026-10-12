@extends('layouts.app')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Participação em Feiras</h2>
            <p class="mt-2 text-sm text-slate-500">Selecione uma feira para oferecer seus produtos e gerenciar seu estoque.</p>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($feiras as $feira)
                <div class="card-premium flex flex-col h-full border-t-4 {{ $feira->status == 'em_andamento' ? 'border-emerald-500' : 'border-blue-500' }}">
                    <div class="p-6 flex-grow">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-bold text-slate-800 line-clamp-2">{{ $feira->nome }}</h3>
                            <span class="px-3 py-1 rounded-full text-xs font-medium whitespace-nowrap {{ $feira->status == 'em_andamento' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $feira->status == 'em_andamento' ? 'Em andamento' : 'Agendada' }}
                            </span>
                        </div>
                        
                        <div class="space-y-3 mb-6">
                            <p class="text-sm text-slate-600 flex items-start gap-2">
                                <i class="far fa-calendar-alt mt-1 w-4 text-emerald-500"></i>
                                <span>
                                    <strong>Início:</strong> {{ \Carbon\Carbon::parse($feira->data_inicio)->format('d/m/Y H:i') }}<br>
                                    <strong>Fim:</strong> {{ \Carbon\Carbon::parse($feira->data_fim)->format('d/m/Y H:i') }}
                                </span>
                            </p>
                            <p class="text-sm text-slate-600 flex items-start gap-2">
                                <i class="fas fa-map-marker-alt mt-1 w-4 text-emerald-500"></i>
                                <span>{{ $feira->endereco }}<br>{{ $feira->cidade }} - {{ $feira->estado }}</span>
                            </p>
                        </div>
                    </div>
                    
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 mt-auto flex gap-3">
                        <a href="{{ route('produtor.feiras.participar', $feira->id) }}" class="btn-primary w-full text-center flex justify-center items-center gap-2">
                            <i class="fas fa-box-open"></i> Meus Produtos nesta Feira
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="text-center py-12 bg-white rounded-3xl border border-slate-200 border-dashed">
                        <i class="fas fa-calendar-times text-4xl text-slate-300 mb-3"></i>
                        <h3 class="text-lg font-medium text-slate-900">Nenhuma feira disponível</h3>
                        <p class="mt-1 text-slate-500">No momento não há feiras agendadas ou em andamento no sistema.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
