@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-3xl font-bold text-slate-800">Editar Perfil</h1>
            <a href="{{ route('dashboard') }}" class="btn-secondary flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 alert-dismissible">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card-premium mb-8">
            <div class="p-8">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-16 h-16 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 text-2xl font-bold shadow-inner">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-800">Informações Pessoais</h2>
                        <p class="text-slate-500">Atualize seus dados de cadastro</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nome Completo</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="form-input" required>
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-input" required>
                        </div>

                        @if($user->isConsumidor() && $user->consumidor)
                            <div>
                                <label for="cpf" class="block text-sm font-medium text-slate-700 mb-1">CPF</label>
                                <input type="text" name="cpf" id="cpf" value="{{ old('cpf', $user->consumidor->cpf) }}" class="form-input" required placeholder="000.000.000-00">
                            </div>
                        @elseif($user->isProdutor() && $user->produtor)
                            <div>
                                <label for="documento" class="block text-sm font-medium text-slate-700 mb-1">Documento (CPF/CNPJ)</label>
                                <input type="text" name="documento" id="documento" value="{{ old('documento', $user->produtor->documento) }}" class="form-input" required>
                            </div>
                        @endif
                    </div>

                    <div class="border-t border-slate-100 pt-6 mb-6">
                        <h3 class="text-lg font-bold text-slate-800 mb-4">Alterar Senha</h3>
                        <p class="text-sm text-slate-500 mb-6">Deixe em branco se não quiser alterar sua senha.</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Nova Senha</label>
                                <input type="password" name="password" id="password" class="form-input">
                            </div>
                            
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Confirmar Nova Senha</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-input">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-6 border-t border-slate-100">
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save mr-2"></i> Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-premium border-red-100">
            <div class="p-8 bg-red-50/30">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                        <i class="fas fa-exclamation-triangle text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-red-800">Zona de Perigo</h2>
                        <p class="text-red-600/80">Ações destrutivas para sua conta</p>
                    </div>
                </div>
                
                <p class="text-slate-600 mb-6">Uma vez que você excluir sua conta, não haverá como recuperar seus dados. Por favor, tenha certeza.</p>
                
                <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Tem certeza absoluta que deseja excluir sua conta? Esta ação é irreversível.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl transition-colors font-medium shadow-sm hover:shadow-red-500/30 flex items-center gap-2">
                        <i class="fas fa-trash-alt"></i> Excluir Minha Conta
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cpfInput = document.getElementById('cpf');
        if (cpfInput) {
            cpfInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 11) value = value.slice(0, 11);
                
                if(value.length > 0) {
                    value = value.replace(/(\d{3})(\d)/, '$1.$2');
                    value = value.replace(/(\d{3})(\d)/, '$1.$2');
                    value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                }
                
                e.target.value = value;
            });
        }
    });
</script>
@endsection
