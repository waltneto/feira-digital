@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Criar uma conta
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Escolha o tipo de conta que deseja criar
            </p>
        </div>
        
        <div class="grid grid-cols-1 gap-4">
            <!-- Card Produtor -->
            <div class="bg-white border border-gray-300 rounded-lg p-6 hover:shadow-md transition-shadow">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                        <i class="fas fa-store text-green-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Produtor</h3>
                    <p class="text-gray-600 text-sm mb-4">
                        Para agricultores e produtores que desejam vender seus produtos em feiras.
                    </p>
                    <a href="{{ route('register.produtor') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                        Cadastrar como Produtor
                    </a>
                </div>
            </div>
            
            <!-- Card Consumidor -->
            <div class="bg-white border border-gray-300 rounded-lg p-6 hover:shadow-md transition-shadow">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 mb-4">
                        <i class="fas fa-shopping-basket text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Consumidor</h3>
                    <p class="text-gray-600 text-sm mb-4">
                        Para quem deseja comprar produtos frescos diretamente das feiras.
                    </p>
                    <a href="{{ route('register.consumidor') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Cadastrar como Consumidor
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center">
            <p class="text-sm text-gray-600">
                Já tem uma conta?
                <a href="{{ route('login') }}" class="font-medium text-green-600 hover:text-green-500">
                    Faça login
                </a>
            </p>
        </div>
    </div>
</div>
@endsection