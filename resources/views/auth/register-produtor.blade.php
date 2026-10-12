@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full space-y-8 bg-white p-10 rounded-3xl shadow-2xl shadow-emerald-900/10 border border-slate-100 relative overflow-hidden">
        
        <div class="relative z-10 text-center">
            <div class="flex justify-center mb-6">
                <div class="w-16 h-16 bg-gradient-to-br from-emerald-400 to-green-600 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/30 transform rotate-3">
                    <i class="fas fa-tractor text-white text-3xl"></i>
                </div>
            </div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">
                Seja um Produtor Parceiro
            </h2>
            <p class="mt-3 text-sm text-slate-500">
                Aumente sua margem de lucro vendendo direto para sua comunidade.
            </p>
        </div>

        <form class="mt-8 space-y-6 relative z-10" action="{{ route('register.produtor') }}" method="POST">
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
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nome Completo / Razão Social</label>
                    <input id="name" name="name" type="text" required value="{{ old('name') }}"
                           class="form-input rounded-xl border-slate-200 py-3 text-slate-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 w-full">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input id="email" name="email" type="email" required value="{{ old('email') }}"
                           class="form-input rounded-xl border-slate-200 py-3 text-slate-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 w-full">
                </div>

                <div>
                    <label for="telefone" class="block text-sm font-medium text-slate-700 mb-1">Telefone (WhatsApp)</label>
                    <input id="telefone" name="telefone" type="text" required value="{{ old('telefone') }}" data-mask="telefone"
                           class="form-input rounded-xl border-slate-200 py-3 text-slate-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 w-full"
                           placeholder="(00) 00000-0000">
                </div>

                <div>
                    <label for="tipo_documento" class="block text-sm font-medium text-slate-700 mb-1">Tipo de Documento</label>
                    <div class="relative">
                        <select id="tipo_documento" name="tipo_documento" required
                                class="form-input appearance-none rounded-xl border-slate-200 py-3 text-slate-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 w-full cursor-pointer">
                            <option value="cpf" {{ old('tipo_documento') == 'cpf' ? 'selected' : '' }}>Pessoa Física (CPF)</option>
                            <option value="cnpj" {{ old('tipo_documento') == 'cnpj' ? 'selected' : '' }}>Pessoa Jurídica (CNPJ)</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                            <i class="fas fa-chevron-down text-sm"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="documento" class="block text-sm font-medium text-slate-700 mb-1">Documento (CPF ou CNPJ)</label>
                    <input id="documento" name="documento" type="text" required value="{{ old('documento') }}"
                           class="form-input rounded-xl border-slate-200 py-3 text-slate-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 w-full">
                </div>

                <div class="md:col-span-2 mt-2 pt-4 border-t border-slate-100">
                    <h4 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4">Endereço da Propriedade</h4>
                </div>

                <div class="md:col-span-2">
                    <label for="endereco" class="block text-sm font-medium text-slate-700 mb-1">Endereço (Rua, Sítio, Fazenda)</label>
                    <input id="endereco" name="endereco" type="text" required value="{{ old('endereco') }}"
                           class="form-input rounded-xl border-slate-200 py-3 text-slate-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 w-full">
                </div>

                <div>
                    <label for="cep" class="block text-sm font-medium text-slate-700 mb-1">CEP</label>
                    <input id="cep" name="cep" type="text" required value="{{ old('cep') }}" data-mask="cep"
                           class="form-input rounded-xl border-slate-200 py-3 text-slate-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 w-full"
                           placeholder="00000-000">
                </div>
                
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label for="cidade" class="block text-sm font-medium text-slate-700 mb-1">Cidade</label>
                        <input id="cidade" name="cidade" type="text" required value="{{ old('cidade') }}"
                               class="form-input rounded-xl border-slate-200 py-3 text-slate-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 w-full">
                    </div>
                    <div class="w-1/3">
                        <label for="estado" class="block text-sm font-medium text-slate-700 mb-1">UF</label>
                        <input id="estado" name="estado" type="text" required maxlength="2" value="{{ old('estado') }}"
                               class="form-input rounded-xl border-slate-200 py-3 text-slate-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 w-full uppercase text-center"
                               placeholder="SP">
                    </div>
                </div>

                <div class="md:col-span-2 mt-2 pt-4 border-t border-slate-100">
                    <h4 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4">Segurança</h4>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Senha</label>
                    <input id="password" name="password" type="password" required
                           class="form-input rounded-xl border-slate-200 py-3 text-slate-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 w-full">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Confirmar Senha</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                           class="form-input rounded-xl border-slate-200 py-3 text-slate-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 w-full">
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full btn-primary text-lg py-4 flex justify-center items-center gap-2">
                    <span>Criar Minha Loja Virtual</span>
                    <i class="fas fa-store opacity-80"></i>
                </button>
            </div>

            <div class="text-center mt-6">
                <p class="text-sm text-slate-600 mt-2">
                    Já possui conta? <a href="{{ route('login') }}" class="font-medium text-emerald-600 hover:text-emerald-500 transition-colors">Entrar no painel</a>
                </p>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('tipo_documento').addEventListener('change', function(e) {
        const input = document.getElementById('documento');
        if(e.target.value === 'cpf') {
            input.setAttribute('data-mask', 'cpf');
            input.placeholder = '000.000.000-00';
            input.value = '';
        } else {
            input.setAttribute('data-mask', 'cnpj');
            input.placeholder = '00.000.000/0000-00';
            input.value = '';
        }
    });
</script>
@endsection