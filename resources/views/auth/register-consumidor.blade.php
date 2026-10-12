@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-[80vh] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full space-y-8 bg-white p-10 rounded-3xl shadow-2xl shadow-emerald-900/10 border border-slate-100 relative overflow-hidden">
        
        <!-- Decorative blob -->
        <div class="absolute -top-10 -right-10 w-48 h-48 bg-emerald-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70"></div>
        <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-green-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70"></div>
        
        <div class="relative z-10 text-center">
            <div class="flex justify-center mb-6">
                <div class="w-16 h-16 bg-gradient-to-br from-emerald-400 to-green-600 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/30 transform -rotate-3">
                    <i class="fas fa-shopping-basket text-white text-3xl"></i>
                </div>
            </div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">
                Cadastro de Consumidor
            </h2>
            <p class="mt-3 text-sm text-slate-500">
                Junte-se a milhares de pessoas que apoiam a agricultura local.
            </p>
        </div>

        <form class="mt-8 space-y-6 relative z-10" action="{{ route('register.consumidor') }}" method="POST">
            @csrf
            
            @if($errors->any())
                <div class="bg-red-50/80 backdrop-blur-sm border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm mb-6">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nome Completo</label>
                    <input id="name" name="name" type="text" required value="{{ old('name') }}"
                           class="form-input rounded-xl border-slate-200 py-3 text-slate-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 w-full"
                           placeholder="João da Silva">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input id="email" name="email" type="email" required value="{{ old('email') }}"
                           class="form-input rounded-xl border-slate-200 py-3 text-slate-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 w-full"
                           placeholder="joao@exemplo.com">
                </div>

                <div>
                    <label for="cpf" class="block text-sm font-medium text-slate-700 mb-1">CPF</label>
                    <input id="cpf" name="cpf" type="text" required value="{{ old('cpf') }}" data-mask="cpf"
                           class="form-input rounded-xl border-slate-200 py-3 text-slate-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 w-full"
                           placeholder="000.000.000-00">
                </div>

                <div class="md:col-span-2">
                    <label for="telefone" class="block text-sm font-medium text-slate-700 mb-1">Telefone / WhatsApp</label>
                    <input id="telefone" name="telefone" type="text" required value="{{ old('telefone') }}" data-mask="telefone"
                           class="form-input rounded-xl border-slate-200 py-3 text-slate-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 w-full"
                           placeholder="(00) 00000-0000">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Senha</label>
                    <input id="password" name="password" type="password" required
                           class="form-input rounded-xl border-slate-200 py-3 text-slate-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 w-full"
                           placeholder="Mínimo 8 caracteres">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Confirmar Senha</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                           class="form-input rounded-xl border-slate-200 py-3 text-slate-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 w-full"
                           placeholder="Repita a senha">
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full btn-primary text-lg py-3 flex justify-center items-center gap-2">
                    <span>Finalizar Cadastro</span>
                    <i class="fas fa-check-circle opacity-80"></i>
                </button>
            </div>

            <div class="text-center mt-6">
                <p class="text-sm text-slate-600">
                    <a href="{{ route('register.produtor') }}" class="font-medium text-emerald-600 hover:text-emerald-500 transition-colors">
                        Você é um produtor? Clique aqui para vender.
                    </a>
                </p>
                <p class="text-sm text-slate-600 mt-2">
                    Já possui conta? <a href="{{ route('login') }}" class="font-medium text-emerald-600 hover:text-emerald-500 transition-colors">Entrar</a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection