@extends('layouts.app')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Gerenciar Feiras</h2>
                <p class="mt-2 text-sm text-slate-500">Administração centralizada dos eventos (feiras) do sistema.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.dashboard') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Voltar
                </a>
                <a href="{{ route('admin.feiras.create') }}" class="btn-primary">
                    <i class="fas fa-plus mr-2"></i> Nova Feira
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="py-4 px-6 text-xs uppercase text-slate-500 font-bold tracking-wider">Nome</th>
                            <th class="py-4 px-6 text-xs uppercase text-slate-500 font-bold tracking-wider">Data</th>
                            <th class="py-4 px-6 text-xs uppercase text-slate-500 font-bold tracking-wider">Local</th>
                            <th class="py-4 px-6 text-xs uppercase text-slate-500 font-bold tracking-wider">Status</th>
                            <th class="py-4 px-6 text-xs uppercase text-slate-500 font-bold tracking-wider text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($feiras as $feira)
                        <tr class="hover:bg-slate-50 transition-colors {{ !$feira->ativa ? 'opacity-50' : '' }}">
                            <td class="py-4 px-6">
                                <span class="font-semibold text-slate-800 block">{{ $feira->nome }}</span>
                                @if(!$feira->ativa)
                                    <span class="text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded-md mt-1 inline-block">Desativada</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-sm text-slate-600">
                                    <i class="far fa-calendar-alt w-4 text-slate-400"></i> {{ \Carbon\Carbon::parse($feira->data_inicio)->format('d/m/Y H:i') }}
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-sm text-slate-600">
                                    {{ $feira->cidade }} - {{ $feira->estado }}
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                @php
                                    $statusColors = [
                                        'agendada' => 'bg-blue-100 text-blue-800',
                                        'em_andamento' => 'bg-emerald-100 text-emerald-800',
                                        'concluida' => 'bg-slate-100 text-slate-800',
                                        'cancelada' => 'bg-red-100 text-red-800',
                                    ];
                                    $statusLabels = [
                                        'agendada' => 'Agendada',
                                        'em_andamento' => 'Em andamento',
                                        'concluida' => 'Concluída',
                                        'cancelada' => 'Cancelada',
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$feira->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $statusLabels[$feira->status] ?? ucfirst($feira->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('feiras.show', $feira->id) }}" target="_blank" class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center hover:bg-slate-200 hover:text-slate-900 transition-colors" title="Ver Página Pública">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                    <a href="{{ route('admin.feiras.edit', $feira->id) }}" class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center hover:bg-emerald-100 hover:text-emerald-700 transition-colors" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($feira->ativa)
                                        <form action="{{ route('admin.feiras.destroy', $feira->id) }}" method="POST" class="inline" onsubmit="return confirm('Deseja realmente desativar esta feira?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-100 hover:text-red-700 transition-colors" title="Desativar">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-500">
                                Nenhuma feira encontrada.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
