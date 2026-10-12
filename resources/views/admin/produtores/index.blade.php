@extends('layouts.app')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Gerenciar Produtores</h2>
                <p class="mt-2 text-sm text-slate-500">Visualize e remova os produtores cadastrados no sistema.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn-secondary flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
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
                            <th class="py-4 px-6 text-xs uppercase text-slate-500 font-bold tracking-wider">Documento</th>
                            <th class="py-4 px-6 text-xs uppercase text-slate-500 font-bold tracking-wider">Email</th>
                            <th class="py-4 px-6 text-xs uppercase text-slate-500 font-bold tracking-wider">Telefone</th>
                            <th class="py-4 px-6 text-xs uppercase text-slate-500 font-bold tracking-wider text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($produtores as $produtor)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-4 px-6 font-semibold text-slate-800">
                                {{ $produtor->usuario->name }}
                            </td>
                            <td class="py-4 px-6 text-sm text-slate-600">
                                <span class="uppercase text-xs font-bold">{{ $produtor->tipo_documento }}</span>: {{ $produtor->documento }}
                            </td>
                            <td class="py-4 px-6 text-sm text-slate-600">
                                {{ $produtor->usuario->email }}
                            </td>
                            <td class="py-4 px-6 text-sm text-slate-600">
                                {{ $produtor->telefone }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                <form action="{{ route('admin.produtores.destroy', $produtor->id) }}" method="POST" class="inline" onsubmit="return confirm('ATENÇÃO: A exclusão do produtor irá deletar TODOS os seus produtos, pedidos e participações em feiras. Esta ação é irreversível. Deseja continuar?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors text-sm font-medium">
                                        <i class="fas fa-trash-alt mr-1"></i> Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-500">
                                Nenhum produtor cadastrado.
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
