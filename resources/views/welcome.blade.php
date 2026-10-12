@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-slate-50 pb-20 pt-16 lg:pt-32">
        <div class="absolute inset-x-0 top-0 h-96 bg-gradient-to-b from-emerald-50/50 to-transparent"></div>
        <div class="absolute right-0 top-1/4 -translate-y-1/2 translate-x-1/3">
            <div class="h-96 w-96 rounded-full bg-emerald-300/20 blur-3xl filter"></div>
        </div>
        <div class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-1/3">
            <div class="h-96 w-96 rounded-full bg-green-300/20 blur-3xl filter"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100/50 text-emerald-700 text-sm font-semibold mb-6 border border-emerald-200">
                        <span class="flex h-2 w-2 rounded-full bg-emerald-500"></span>
                    O caminho mais curto até a sua mesa
                    </div>
                    <h1 class="text-5xl lg:text-7xl font-extrabold tracking-tight text-slate-900 mb-8 leading-[1.1]">
                        Do campo para a sua casa <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-green-600">clique</span>
                    </h1>
                    <p class="text-xl text-slate-600 mb-10 leading-relaxed font-light">
                        A Feira Digital conecta produtores locais a você garantindo alimentos mais saudáveis, economia local forte e rastreabilidade total do que você consome.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('feiras.index') }}" class="btn-primary text-center text-lg px-8 py-4 px-8 rounded-2xl flex items-center justify-center gap-2">
                            <i class="fas fa-store"></i> Explorar Feiras
                        </a>
                        <a href="#how-it-works" class="btn-secondary text-center text-lg px-8 py-4 rounded-2xl flex items-center justify-center gap-2">
                            <i class="fas fa-play-circle text-emerald-500"></i> Como funciona
                        </a>
                    </div>
                    
                    <div class="mt-12 flex items-center gap-6 pt-8 border-t border-slate-200/60">
                        <div class="flex -space-x-4">
                            
                            <div class="w-12 h-12 rounded-full border-2 border-white bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-600"></div>
                        </div>
                        <div class="text-sm font-medium text-slate-600">
                            
                        </div>
                    </div>
                </div>
                
                <div class="relative lg:-mr-12 xl:-mr-24 hidden lg:block perspective-1000">
                    <div class="relative rounded-3xl bg-white shadow-2xl p-4 transform rotate-y-[-10deg] rotate-x-[5deg] hover:rotate-0 transition-all duration-700 ease-out z-20 border border-slate-100/50">
                        <img src="https://images.unsplash.com/photo-1488459716781-31db52582fe9?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Feira de vegetais" class="rounded-2xl w-full h-auto object-cover max-h-[600px] shadow-inner">

                    </div>
                    <!-- Elementos flutuantes de decoração -->
                    <div class="absolute -top-12 right-12 text-6xl opacity-20 filter blur-[2px] transform rotate-12">🍅</div>
                    <div class="absolute bottom-12 -right-8 text-6xl opacity-20 filter blur-[1px] transform -rotate-12">🥬</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <span class="text-emerald-600 font-bold uppercase tracking-wider text-sm">Vantagens</span>
                <h2 class="mt-3 text-4xl font-extrabold text-slate-900 tracking-tight">O que nos torna diferentes?</h2>
                <p class="mt-4 text-xl text-slate-500 font-light">A Feira Digital não é apenas um marketplace, é uma mudança de paradigma na forma de consumir alimentos.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Feature 1 -->
                <div class="card-premium p-10 group relative z-10 hover:-translate-y-2">
                    <div class="absolute inset-0 bg-gradient-to-b from-transparent to-green-50/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-400 to-green-600 rounded-2xl flex items-center justify-center mb-8 shadow-lg shadow-emerald-500/20 transform -rotate-6 group-hover:rotate-0 transition-transform duration-300">
                        <i class="fas fa-tractor text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-4 relative z-10">Apoio ao Agricultor</h3>
                    <p class="text-slate-600 mb-6 leading-relaxed relative z-10 font-light">Acompanhe as vendas, gerencie estoque e elimine intermediários. Ferramentas criadas para aumentar seus lucros em até 40%.</p>
                    <ul class="space-y-3 relative z-10 text-slate-600 text-sm font-medium">
                        <li class="flex items-center gap-3"><i class="fas fa-check-circle text-emerald-500"></i> Feiras Virtuais Ilimitadas</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check-circle text-emerald-500"></i> Painel Financeiro Simples</li>
                    </ul>
                </div>

                <!-- Feature 2 -->
                <div class="card-premium p-10 group relative z-10 md:translate-y-6 hover:translate-y-4">
                    <div class="absolute inset-0 bg-gradient-to-b from-transparent to-green-50/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-400 to-green-600 rounded-2xl flex items-center justify-center mb-8 shadow-lg shadow-emerald-500/20 transform rotate-3 group-hover:rotate-0 transition-transform duration-300">
                        <i class="fas fa-shopping-basket text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-4 relative z-10">Para o Consumidor</h3>
                    <p class="text-slate-600 mb-6 leading-relaxed relative z-10 font-light">Tenha acesso aos melhores e mais frescos ingredientes da sua região. Alimentos que fazem bem à saúde e fortalecem o comércio local.</p>
                    <ul class="space-y-3 relative z-10 text-slate-600 text-sm font-medium">
                        <li class="flex items-center gap-3"><i class="fas fa-check-circle text-emerald-500"></i> Produtos sem agrotóxicos</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check-circle text-emerald-500"></i> Retirada express via PIX</li>
                    </ul>
                </div>

                <!-- Feature 3 -->
                <div class="card-premium p-10 group relative z-10 hover:-translate-y-2">
                    <div class="absolute inset-0 bg-gradient-to-b from-transparent to-green-50/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-400 to-green-600 rounded-2xl flex items-center justify-center mb-8 shadow-lg shadow-emerald-500/20 transform -rotate-3 group-hover:rotate-0 transition-transform duration-300">
                        <i class="fas fa-qrcode text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-4 relative z-10">Tecnologia em Foco</h3>
                    <p class="text-slate-600 mb-6 leading-relaxed relative z-10 font-light">Utilizamos um modelo de vendas ágil. Faça a compra em casa através de nosso modelo de Pix QR Code super rápido e apenas retire.</p>
                    <ul class="space-y-3 relative z-10 text-slate-600 text-sm font-medium">
                        <li class="flex items-center gap-3"><i class="fas fa-check-circle text-emerald-500"></i> Pagamentos com PIX Instantâneo</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check-circle text-emerald-500"></i> Rastreabilidade Total</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- How it Works Interactive Section -->
    <section id="how-it-works" class="py-24 bg-slate-900 text-white relative overflow-hidden">
        <!-- Abstract Shapes -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-emerald-500/10 blur-3xl text-transparent"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 rounded-full bg-green-500/10 blur-3xl text-transparent"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-20">
                <h2 class="text-4xl font-extrabold tracking-tight mb-4 text-white">Como Funciona</h2>
                <p class="text-xl text-slate-400 font-light">Sua jornada sustentável em apenas 4 etapas.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Step 1 -->
                <div class="text-center relative">
                    <div class="hidden md:block absolute top-12 left-1/2 w-full border-t-2 border-dashed border-slate-700"></div>
                    <div class="w-24 h-24 mx-auto bg-slate-800 border-[6px] border-slate-900 rounded-full flex items-center justify-center text-emerald-400 text-3xl font-bold relative z-10 shadow-lg shadow-emerald-900/40 mb-6">
                        1
                    </div>
                    <h3 class="text-xl font-bold mb-3">Conecte-se</h3>
                    <p class="text-slate-400 font-light">Crie sua conta como Produtor ou Consumidor.</p>
                </div>

                <!-- Step 2 -->
                <div class="text-center relative">
                    <div class="hidden md:block absolute top-12 left-1/2 w-full border-t-2 border-dashed border-slate-700"></div>
                    <div class="w-24 h-24 mx-auto bg-slate-800 border-[6px] border-slate-900 rounded-full flex items-center justify-center text-emerald-400 text-3xl font-bold relative z-10 shadow-lg shadow-emerald-900/40 mb-6">
                        2
                    </div>
                    <h3 class="text-xl font-bold mb-3">Explore</h3>
                    <p class="text-slate-400 font-light">Encontre feiras abertas e veja os produtos disponíveis.</p>
                </div>

                <!-- Step 3 -->
                <div class="text-center relative">
                    <div class="hidden md:block absolute top-12 left-1/2 w-full border-t-2 border-dashed border-slate-700"></div>
                    <div class="w-24 h-24 mx-auto bg-slate-800 border-[6px] border-slate-900 rounded-full flex items-center justify-center text-emerald-400 text-3xl font-bold relative z-10 shadow-lg shadow-emerald-900/40 mb-6">
                        3
                    </div>
                    <h3 class="text-xl font-bold mb-3">Compre</h3>
                    <p class="text-slate-400 font-light">Gere seu pedido em casa e ganhe um QR Code do pagamento via PIX.</p>
                </div>

                <!-- Step 4 -->
                <div class="text-center relative">
                    <div class="w-24 h-24 mx-auto bg-slate-800 border-[6px] border-slate-900 rounded-full flex items-center justify-center text-emerald-400 text-3xl font-bold relative z-10 shadow-lg shadow-emerald-900/40 mb-6 transform scale-110 bg-gradient-to-br from-slate-800 to-emerald-900 border-emerald-500/30">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-emerald-400">Retire</h3>
                    <p class="text-slate-400 font-light">Apresente-se na feira, mostre o QR code e retire com facilidade.</p>
                </div>
            </div>
            
            <div class="mt-20 text-center">
                 <a href="{{ route('register.consumidor') }}" class="inline-block bg-emerald-500 text-slate-900 font-bold px-10 py-5 rounded-full hover:bg-emerald-400 transition-colors shadow-xl shadow-emerald-500/20 transform hover:-translate-y-1">
                     Experimentar Agora <i class="fas fa-arrow-right ml-2"></i>
                 </a>
            </div>
        </div>
    </section>
@endsection