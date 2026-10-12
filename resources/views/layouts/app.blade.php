<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Feira Digital') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Outfit:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        .glass-nav {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255,255,255, 0.4);
        }
        .btn-primary {
            @apply bg-gradient-to-r from-emerald-500 to-green-600 text-white px-6 py-2.5 rounded-xl hover:shadow-lg hover:shadow-emerald-500/30 transition-all duration-300 font-medium transform hover:-translate-y-0.5;
        }
        .btn-secondary {
            @apply bg-white text-slate-700 border border-slate-200 px-6 py-2.5 rounded-xl hover:bg-slate-50 hover:shadow-md transition-all duration-300 font-medium transform hover:-translate-y-0.5;
        }
        .form-input {
            @apply mt-1 block w-full rounded-xl border-slate-200 px-4 py-3 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 transition-all duration-200 bg-slate-50 hover:bg-white;
        }
        .card-premium {
            @apply bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-shadow duration-300;
        }
    </style>
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800 selection:bg-emerald-200 selection:text-emerald-900 flex flex-col min-h-screen">
    
    <!-- Navigation -->
    <nav class="glass-nav sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <div class="bg-white border border-[#808000]/30 w-10 h-10 rounded-xl flex items-center justify-center shadow-lg shadow-[#808000]/20 group-hover:scale-105 transition-transform duration-300">
                            <i class="fas fa-home text-[#808000] text-xl"></i>
                        </div>
                        <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-slate-800 to-slate-600">Feira Digital</span>
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-6">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-purple-600 hover:text-purple-700 bg-purple-50 px-4 py-2 rounded-lg transition-colors border border-purple-200">
                                <i class="fas fa-shield-alt mr-1"></i> Administração
                            </a>
                        @endif

                        @if(auth()->user()->isProdutor())
                            <a href="{{ route('produtor.feiras.participacao') }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700 bg-emerald-50 px-4 py-2 rounded-lg transition-colors border border-emerald-200">
                                <i class="fas fa-store mr-1"></i> Minhas Feiras
                            </a>
                        @endif
                        <a href="{{ route('feiras.index') }}" class="text-slate-600 hover:text-emerald-600 font-medium transition-colors">Explorar Feiras</a>
                        <a href="{{ route('produtos.index') }}" class="text-slate-600 hover:text-emerald-600 font-medium transition-colors">Produtos</a>
                        
                        @if(auth()->user()->isConsumidor())
                            <a href="{{ route('carrinho.index') }}" class="text-slate-600 hover:text-emerald-600 font-medium transition-colors relative flex items-center justify-center w-10 h-10 rounded-full hover:bg-slate-100">
                                <i class="fas fa-shopping-cart text-lg"></i>
                            </a>
                        @endif

                        <div class="h-6 w-px bg-slate-200 mx-2"></div>

                        <!-- Drodown Conta -->
                        <div class="relative group">
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 hover:bg-slate-50 py-2 px-3 rounded-xl transition-colors cursor-pointer">
                                <span class="hidden lg:block font-medium text-slate-700">{{ explode(' ', auth()->user()->name)[0] }}</span>
                                <div class="w-9 h-9 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold shadow-inner">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            </a>
                        </div>
                        
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="w-10 h-10 rounded-full hover:bg-red-50 text-slate-400 hover:text-red-500 transition-colors flex items-center justify-center" title="Sair">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-600 hover:text-emerald-600 font-medium transition-colors">Entrar</a>
                        <div class="relative group">
                            <button class="btn-primary">
                                Cadastre-se <i class="fas fa-chevron-down ml-1 text-xs opacity-70"></i>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] py-2 invisible opacity-0 scale-95 origin-top-right group-hover:visible group-hover:opacity-100 group-hover:scale-100 transition-all duration-300 delay-300 group-hover:delay-0 border border-slate-100 z-50">
                                <a href="{{ route('register.consumidor') }}" class="block px-4 py-2.5 text-slate-600 hover:bg-emerald-50 hover:text-emerald-600 transition-colors font-medium text-sm">
                                    <i class="fas fa-shopping-basket mr-2 w-5 text-center"></i>Sou Consumidor
                                </a>
                                <a href="{{ route('register.produtor') }}" class="block px-4 py-2.5 text-slate-600 hover:bg-emerald-50 hover:text-emerald-600 transition-colors font-medium text-sm">
                                    <i class="fas fa-tractor mr-2 w-5 text-center"></i>Sou Produtor
                                </a>
                            </div>
                        </div>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button class="text-slate-600 hover:text-emerald-600 focus:outline-none p-2">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white border-b border-slate-100 shadow-sm shadow-slate-100/50">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="font-bold text-2xl text-slate-800 tracking-tight">
                    {{ $header }}
                </h2>
            </div>
        </header>
    @endif

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-100 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 mb-4">
                        <i class="fas fa-seedling text-emerald-500 text-2xl"></i>
                        <span class="text-xl font-bold text-slate-800">Feira Digital</span>
                    </a>
                    <p class="text-slate-500 max-w-sm">Conectando produtos locais, frescos e saudáveis diretamente da terra para a sua mesa, com tecnologia e transparência.</p>
                </div>
                <div>
                    <h4 class="font-semibold text-slate-800 mb-4">Plataforma</h4>
                    <ul class="space-y-2 text-sm text-slate-500">
                        <li><a href="{{ route('feiras.index') }}" class="hover:text-emerald-600 transition-colors">Explorar Feiras</a></li>
                        <li><a href="{{ route('produtos.index') }}" class="hover:text-emerald-600 transition-colors">Ver Produtos</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-emerald-600 transition-colors">Fazer Login</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-slate-800 mb-4">Contato</h4>
                    <ul class="space-y-2 text-sm text-slate-500">
                        <li class="flex items-center gap-2"><i class="fas fa-envelope text-emerald-500"></i> ola@feiradigital.com</li>
                        <li class="flex items-center gap-2"><i class="fas fa-phone text-emerald-500"></i> (11) 98765-4321</li>
                        <li class="flex gap-4 mt-4 text-lg">
                            <a href="#" class="text-slate-400 hover:text-emerald-600 transition-colors"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-slate-400 hover:text-emerald-600 transition-colors"><i class="fab fa-facebook"></i></a>
                            <a href="#" class="text-slate-400 hover:text-emerald-600 transition-colors"><i class="fab fa-whatsapp"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-100 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-slate-400">
                <p>&copy; {{ date('Y') }} Feira Digital. Todos os direitos reservados.</p>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-slate-600 transition-colors">Termos de Uso</a>
                    <a href="#" class="hover:text-slate-600 transition-colors">Privacidade</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });
        });
    </script>
</body>
</html>