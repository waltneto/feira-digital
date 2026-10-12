@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-[80vh] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-3xl shadow-2xl shadow-emerald-900/10 border border-slate-100 relative overflow-hidden">
        
        <!-- Decorative blob -->
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-emerald-100 rounded-full mix-blend-multiply filter blur-2xl opacity-70"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-green-100 rounded-full mix-blend-multiply filter blur-2xl opacity-70"></div>
        
        <div class="relative z-10 text-center">
            <div class="flex justify-center mb-6">
                <div class="w-16 h-16 bg-gradient-to-br from-emerald-400 to-green-600 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/30 transform -rotate-3 hover:rotate-0 transition-transform duration-300">
                    <i class="fas fa-seedling text-white text-3xl"></i>
                </div>
            </div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">
                Boas vindas
            </h2>
            <p class="mt-3 text-sm text-slate-500">
                Acesse sua conta para continuar sua jornada sustentável
            </p>
        </div>

        <form class="mt-8 space-y-6 relative z-10" action="{{ route('login') }}" method="POST" id="loginForm">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-slate-400"></i>
                        </div>
                        <input id="email" name="email" type="email" autocomplete="email" required
                               class="form-input rounded-xl border-slate-200 pl-11 py-3 text-slate-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 w-full bg-slate-50 hover:bg-white transition-colors"
                               placeholder="exemplo@email.com"
                               value="{{ old('email') }}">
                    </div>
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Senha</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-slate-400"></i>
                        </div>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                               class="form-input rounded-xl border-slate-200 pl-11 py-3 pr-10 text-slate-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 w-full bg-slate-50 hover:bg-white transition-colors"
                               placeholder="Sua senha secreta">
                        <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-emerald-600" onclick="togglePassword()">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Validation Errors -->
            @if($errors->any() || session('error'))
                <div class="bg-red-50/80 backdrop-blur-sm border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm flex items-start gap-3">
                    <i class="fas fa-exclamation-circle mt-0.5"></i>
                    <div>
                        @if(session('error'))
                            <p>{{ session('error') }}</p>
                        @endif
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox"
                           class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-slate-300 rounded cursor-pointer">
                    <label for="remember" class="ml-2 block text-sm text-slate-600 cursor-pointer select-none">
                        Lembrar-me
                    </label>
                </div>
                <div class="text-sm">
                    <a href="#" class="font-medium text-emerald-600 hover:text-emerald-500 transition-colors">Esqueceu a senha?</a>
                </div>
            </div>

            <button type="submit" class="w-full btn-primary text-lg py-3 flex justify-center items-center gap-2">
                <span>Entrar</span>
                <i class="fas fa-sign-in-alt opacity-80"></i>
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-100 text-center relative z-10">
            <p class="text-sm text-slate-500 mb-4">Ainda não tem conta na Feira?</p>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('register.consumidor') }}" class="flex-1 btn-secondary text-sm py-2 px-0 text-center flex items-center justify-center gap-2">
                    <i class="fas fa-shopping-basket text-emerald-500"></i> Comprar
                </a>
                <a href="{{ route('register.produtor') }}" class="flex-1 btn-secondary text-sm py-2 px-0 text-center flex items-center justify-center gap-2">
                    <i class="fas fa-tractor text-emerald-500"></i> Vender
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection