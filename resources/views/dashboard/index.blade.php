@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                @auth
                    <div class="mb-6">
                        <p class="text-gray-700">Bem-vindo, <span class="font-semibold">{{ Auth::user()->name }}</span>!</p>
                        <p class="text-gray-600">Email: {{ Auth::user()->email }}</p>
                        
                        @if(Auth::user()->isProdutor())
                            <div class="mt-4 p-4 bg-green-50 rounded-lg">
                                <h3 class="font-semibold text-green-800">Você é um Produtor</h3>
                                <p class="text-green-600">Documento: {{ Auth::user()->produtor->documento }}</p>
                                <div class="mt-3">
                                    <a href="{{ route('feiras.create') }}" class="btn-primary mr-3">
                                        <i class="fas fa-store mr-2"></i>Minhas Feiras
                                    </a>
                                    <a href="{{ route('produtos.create') }}" class="btn-secondary mr-3">
                                        <i class="fas fa-carrot mr-2"></i>Meus Produtos
                                    </a>
                                    <a href="{{ route('produtor.pedidos') }}" class="inline-block bg-white text-emerald-600 border border-emerald-200 hover:bg-emerald-50 px-4 py-2.5 rounded-xl font-medium transition-colors">
                                        <i class="fas fa-clipboard-list mr-2"></i>Pedidos Recebidos
                                    </a>
                                </div>
                            </div>
                        @endif
                        
                        @if(Auth::user()->isConsumidor())
                            <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                                <h3 class="font-semibold text-blue-800">Você é um Consumidor</h3>
                                <p class="text-blue-600">CPF: {{ Auth::user()->consumidor->cpf }}</p>
                                <div class="mt-3">
                                    <a href="{{ route('feiras.index') }}" class="btn-primary mr-3">
                                        <i class="fas fa-store mr-2"></i>Ver Feiras
                                    </a>
                                    <a href="{{ route('produtos.index') }}" class="btn-secondary">
                                        <i class="fas fa-shopping-basket mr-2"></i>Ver Produtos
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="mt-8 border-t border-slate-100 pt-6 flex flex-wrap items-center gap-4">
                        <a href="{{ route('profile.edit') }}" class="btn-secondary">
                            <i class="fas fa-user-edit mr-2"></i>Editar Perfil
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="px-6 py-2.5 bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 rounded-xl transition-colors font-medium flex items-center">
                                <i class="fas fa-sign-out-alt mr-2"></i>Sair
                            </button>
                        </form>
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-600 mb-6">Você não está logado. Faça login para acessar o dashboard.</p>
                        <a href="{{ route('login') }}" class="btn-primary">Fazer Login</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection