@extends('layouts.app')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Feiras Disponíveis</h1>
                <p class="mt-2 text-sm text-slate-500">Encontre as melhores feiras de produtores locais próximos a você.</p>
            </div>
            
            @auth
                @if(auth()->user()->isProdutor())
                    <a href="{{ route('feiras.create') }}" class="btn-primary flex items-center gap-2 whitespace-nowrap">
                        <i class="fas fa-plus"></i> Nova Feira
                    </a>
                @endif
            @endauth
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 text-emerald-800 p-4 rounded-xl mb-6 border border-emerald-100 flex items-center gap-3">
                <i class="fas fa-check-circle text-emerald-500 text-xl"></i>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if($feiras->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($feiras as $feira)
                    <div class="bg-white border border-slate-100 rounded-3xl p-6 hover:shadow-xl hover:shadow-emerald-900/5 transition-all duration-300 relative group flex flex-col">
                        
                        <div class="absolute top-4 right-4 bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full border border-emerald-200">
                            {{ ucfirst($feira->status) }}
                        </div>
                        
                        <div class="mb-4 pr-16 pb-4 border-b border-slate-100">
                            <h2 class="text-xl font-bold text-slate-900 mb-1 group-hover:text-emerald-700 transition-colors">{{ $feira->nome }}</h2>
                            <p class="text-sm font-medium text-emerald-600 truncate flex items-center gap-1">
                                <i class="fas fa-users opacity-70"></i> Múltiplos Produtores Locais
                            </p>
                        </div>
                        
                        <p class="text-slate-600 text-sm mb-6 line-clamp-2 min-h-[40px]">
                            {{ $feira->descricao ?? 'Esta feira não possui descrição adicional.' }}
                        </p>

                        <div class="space-y-3 mb-6 mt-auto">
                            <div class="flex items-start text-slate-600">
                                <i class="far fa-calendar-alt text-slate-400 mt-1 mr-3 w-4 text-center"></i>
                                <div>
                                    <p class="text-sm font-medium text-slate-900">
                                        {{ \Carbon\Carbon::parse($feira->data_inicio)->format('d/m/Y') }}
                                        <span class="text-xs font-normal text-slate-500 block">Das {{ \Carbon\Carbon::parse($feira->data_inicio)->format('H:i') }} às {{ \Carbon\Carbon::parse($feira->data_fim)->format('H:i') }}</span>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex items-start text-slate-600">
                                <i class="fas fa-map-marker-alt text-slate-400 mt-1 mr-3 w-4 text-center"></i>
                                <div>
                                    <p class="text-sm font-medium text-slate-900">
                                        {{ $feira->cidade }}, {{ $feira->estado }}
                                        <span class="text-xs font-normal text-slate-500 block truncate" title="{{ $feira->endereco }}">{{ $feira->endereco }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100 mt-auto flex items-center justify-between">
                            <div class="flex items-center -space-x-2">
                                <span class="text-xs font-medium text-slate-500 bg-slate-100 py-1 px-3 rounded-full ml-auto">
                                    {{ $feira->produtos->count() }} produtos
                                </span>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                @can('update', $feira)
                                    <a href="{{ route('feiras.edit', $feira->id) }}" class="text-sm font-bold text-amber-500 hover:text-amber-600" title="Editar Feira">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('feiras.destroy', $feira->id) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja cancelar/desativar esta feira?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-bold text-red-500 hover:text-red-600" title="Excluir Feira">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @endcan

                                <a href="{{ route('feiras.show', $feira->id) }}" class="text-sm font-bold text-emerald-600 hover:text-emerald-700 group-hover:underline underline-offset-4 decoration-emerald-300">
                                    Ver Detalhes <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-3xl border border-slate-100 shadow-sm">
                <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                    <i class="far fa-calendar-times text-4xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900">Nenhuma feira agendada</h3>
                <p class="mt-2 text-slate-500">Volte mais tarde para ver os próximos eventos dos produtores.</p>
                
                @auth
                    @if(auth()->user()->isProdutor())
                        <div class="mt-6">
                            <a href="{{ route('feiras.create') }}" class="btn-primary inline-flex items-center gap-2">
                                <i class="fas fa-plus"></i> Agendar Primeira Feira
                            </a>
                        </div>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</div>
@endsection