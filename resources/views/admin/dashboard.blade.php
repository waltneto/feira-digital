@extends('layouts.app')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Painel de Administração</h2>
            <p class="mt-2 text-sm text-slate-500">Gerencie as feiras do sistema e os produtores cadastrados.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Gerenciar Feiras -->
            <a href="{{ route('admin.feiras.index') }}" class="card-premium p-6 group cursor-pointer border-t-4 border-t-purple-500">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center text-purple-600 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-calendar-alt text-xl"></i>
                    </div>
                    <i class="fas fa-arrow-right text-slate-300 group-hover:text-purple-500 transition-colors"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Gerenciar Feiras</h3>
                <p class="text-sm text-slate-500">Crie, edite ou exclua os eventos de feiras do sistema.</p>
            </a>

            <!-- Gerenciar Produtores -->
            <a href="{{ route('admin.produtores') }}" class="card-premium p-6 group cursor-pointer border-t-4 border-t-emerald-500">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <i class="fas fa-arrow-right text-slate-300 group-hover:text-emerald-500 transition-colors"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Produtores</h3>
                <p class="text-sm text-slate-500">Visualize os produtores cadastrados e gerencie seus acessos.</p>
            </a>
        </div>
    </div>
</div>
@endsection
