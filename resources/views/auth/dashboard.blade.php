@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                @if(auth()->user()->isProdutor())
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Dashboard do Produtor</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-green-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-green-800 mb-2">Minhas Feiras</h3>
                            <p class="text-3xl font-bold text-green-600">{{ auth()->user()->produtor->produtos()->whereHas('feiras')->count() }}</p>
                            <a href="{{ route('feiras.create') }}" class="text-green-600 hover:text-green-500 text-sm font-medium">Criar nova feira</a>
                        </div>
                        
                        <div class="bg-blue-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-blue-800 mb-2">Meus Produtos</h3>
                            <p class="text-3xl font-bold text-blue-600">{{ auth()->user()->produtor->produtos->count() }}</p>
                            <a href="#" class="text-blue-600 hover:text-blue-500 text-sm font-medium">Gerenciar produtos</a>
                        </div>
                        
                        <div class="bg-yellow-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-yellow-800 mb-2">Pedidos Hoje</h3>
                            <p class="text-3xl font-bold text-yellow-600">0</p>
                            <a href="#" class="text-yellow-600 hover:text-yellow-500 text-sm font-medium">Ver todos os pedidos</a>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Ações Rápidas</h3>
                        <div class="flex space-x-4">
                            <a href="{{ route('feiras.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                                <i class="fas fa-plus mr-2"></i>Criar Feira
                            </a>
                            <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                                <i class="fas fa-boxes mr-2"></i>Cadastrar Produto
                            </a>
                            <a href="#" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition duration-200">
                                <i class="fas fa-chart-bar mr-2"></i>Relatórios
                            </a>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Minhas Feiras Recentes</h3>
                        @if(auth()->user()->produtor->produtos()->whereHas('feiras')->count() > 0)
                            <div class="space-y-4">
                                @foreach(auth()->user()->produtor->produtos()->with('feiras')->get()->pluck('feiras')->flatten()->unique('id')->take(3) as $feira)
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <h4 class="font-semibold text-gray-900">{{ $feira->nome }}</h4>
                                        <p class="text-gray-600 text-sm">{{ $feira->data_inicio->format('d/m/Y H:i') }} - {{ $feira->data_fim->format('d/m/Y H:i') }}</p>
                                        <p class="text-gray-600 text-sm">{{ $feira->endereco }}, {{ $feira->cidade }}/{{ $feira->estado }}</p>
                                        <span class="inline-block mt-2 px-2 py-1 text-xs rounded-full 
                                            @if($feira->status == 'em_andamento') bg-green-100 text-green-800
                                            @elseif($feira->status == 'agendada') bg-blue-100 text-blue-800
                                            @elseif($feira->status == 'concluida') bg-gray-100 text-gray-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($feira->status) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-600">Você ainda não criou nenhuma feira.</p>
                            <a href="{{ route('feiras.create') }}" class="text-green-600 hover:text-green-500 font-medium">Crie sua primeira feira</a>
                        @endif
                    </div>

                @elseif(auth()->user()->isConsumidor())
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Dashboard do Consumidor</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-green-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-green-800 mb-2">Pedidos Realizados</h3>
                            <p class="text-3xl font-bold text-green-600">{{ auth()->user()->consumidor->pedidos->count() }}</p>
                            <a href="{{ route('pedidos.index') }}" class="text-green-600 hover:text-green-500 text-sm font-medium">Ver meus pedidos</a>
                        </div>
                        
                        <div class="bg-blue-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-blue-800 mb-2">Feiras Próximas</h3>
                            <p class="text-3xl font-bold text-blue-600">0</p>
                            <a href="{{ route('feiras.index') }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium">Explorar feiras</a>
                        </div>
                        
                        <div class="bg-yellow-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-yellow-800 mb-2">Carrinho</h3>
                            <p class="text-3xl font-bold text-yellow-600">0</p>
                            <a href="{{ route('carrinho.index') }}" class="text-yellow-600 hover:text-yellow-500 text-sm font-medium">Ver carrinho</a>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Ações Rápidas</h3>
                        <div class="flex space-x-4">
                            <a href="{{ route('feiras.index') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                                <i class="fas fa-store mr-2"></i>Explorar Feiras
                            </a>
                            <a href="{{ route('produtos.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                                <i class="fas fa-shopping-basket mr-2"></i>Ver Produtos
                            </a>
                            <a href="{{ route('carrinho.index') }}" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition duration-200">
                                <i class="fas fa-shopping-cart mr-2"></i>Meu Carrinho
                            </a>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Meus Pedidos Recentes</h3>
                        @if(auth()->user()->consumidor->pedidos->count() > 0)
                            <div class="space-y-4">
                                @foreach(auth()->user()->consumidor->pedidos->take(3) as $pedido)
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <h4 class="font-semibold text-gray-900">Pedido #{{ $pedido->codigo_pedido }}</h4>
                                        <p class="text-gray-600 text-sm">Feira: {{ $pedido->feira->nome }}</p>
                                        <p class="text-gray-600 text-sm">Realizado em: {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                                        <p class="text-gray-600 text-sm">Total: R$ {{ number_format($pedido->total, 2, ',', '.') }}</p>
                                        <span class="inline-block mt-2 px-2 py-1 text-xs rounded-full 
                                            @if($pedido->status == 'pendente') bg-yellow-100 text-yellow-800
                                            @elseif($pedido->status == 'confirmado') bg-blue-100 text-blue-800
                                            @elseif($pedido->status == 'preparando') bg-orange-100 text-orange-800
                                            @elseif($pedido->status == 'pronto') bg-green-100 text-green-800
                                            @elseif($pedido->status == 'entregue') bg-gray-100 text-gray-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($pedido->status) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-600">Você ainda não realizou nenhum pedido.</p>
                            <a href="{{ route('feiras.index') }}" class="text-green-600 hover:text-green-500 font-medium">Faça seu primeiro pedido</a>
                        @endif
                    </div>
                @else
                    <h2 class="text-2xl font-bold text-gray-900">Bem-vindo!</h2>
                    <p class="text-gray-600">Complete seu cadastro para acessar as funcionalidades.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection