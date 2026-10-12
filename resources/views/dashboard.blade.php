@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold mb-6">Dashboard</h2>
                
                <div class="mb-6">
                    <p class="text-gray-700">Bem-vindo, <span class="font-semibold">{{ Auth::user()->name }}</span>!</p>
                    <p class="text-gray-600">Email: {{ Auth::user()->email }}</p>
                </div>

                @if(Auth::user()->produtor)
                    <!-- Dashboard do Produtor -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold text-green-800 mb-4">Painel do Produtor</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="bg-white p-4 rounded-lg shadow">
                                <h4 class="font-semibold text-gray-800 mb-3">Minhas Feiras</h4>
                                <p class="text-gray-600 mb-4">Gerencie suas feiras e eventos</p>
                                <a href="{{ route('feiras.create') }}" class="btn-primary inline-block">
                                    <i class="fas fa-plus mr-2"></i>Nova Feira
                                </a>
                                <a href="{{ route('feiras.index') }}" class="btn-secondary inline-block ml-2">
                                    <i class="fas fa-store mr-2"></i>Ver Feiras
                                </a>
                            </div>
                            
                            <div class="bg-white p-4 rounded-lg shadow">
                                <h4 class="font-semibold text-gray-800 mb-3">Meus Produtos</h4>
                                <p class="text-gray-600 mb-4">Adicione e gerencie seus produtos</p>
                                <a href="{{ route('produtos.create') }}" class="btn-primary inline-block">
                                    <i class="fas fa-plus mr-2"></i>Novo Produto
                                </a>
                                <a href="{{ route('produtos.index') }}" class="btn-secondary inline-block ml-2">
                                    <i class="fas fa-carrot mr-2"></i>Ver Produtos
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                @if(Auth::user()->consumidor)
                    <!-- Dashboard do Consumidor -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold text-blue-800 mb-4">Painel do Consumidor</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div class="bg-white p-4 rounded-lg shadow">
                                <h4 class="font-semibold text-gray-800 mb-3">Feiras</h4>
                                <p class="text-gray-600 mb-4">Encontre feiras próximas</p>
                                <a href="{{ route('feiras.index') }}" class="btn-primary inline-block">
                                    <i class="fas fa-store mr-2"></i>Explorar Feiras
                                </a>
                            </div>
                            
                            <div class="bg-white p-4 rounded-lg shadow">
                                <h4 class="font-semibold text-gray-800 mb-3">Produtos</h4>
                                <p class="text-gray-600 mb-4">Descubra produtos frescos</p>
                                <a href="{{ route('produtos.index') }}" class="btn-primary inline-block">
                                    <i class="fas fa-carrot mr-2"></i>Explorar Produtos
                                </a>
                            </div>
                            
                            <div class="bg-white p-4 rounded-lg shadow">
                                <h4 class="font-semibold text-gray-800 mb-3">Carrinho</h4>
                                <p class="text-gray-600 mb-4">Gerencie suas compras</p>
                                <a href="{{ route('carrinho.index') }}" class="btn-primary inline-block">
                                    <i class="fas fa-shopping-cart mr-2"></i>Ver Carrinho
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Ações Gerais -->
                <div class="border-t pt-6">
                    <h4 class="font-semibold text-gray-800 mb-4">Ações</h4>
                    <div class="flex flex-wrap gap-3">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-200">
                                <i class="fas fa-sign-out-alt mr-2"></i>Sair
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection