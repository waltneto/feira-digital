@extends('layouts.app')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Nova Feira</h2>
                <p class="mt-2 text-sm text-slate-500">Crie um novo evento de feira no sistema.</p>
            </div>
            <a href="{{ route('admin.feiras.index') }}" class="btn-secondary flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <form action="{{ route('admin.feiras.store') }}" method="POST" class="p-8 space-y-8">
                @csrf

                @if($errors->any())
                    <div class="bg-red-50 text-red-700 p-4 rounded-xl text-sm mb-6 border border-red-100">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="nome" class="block text-sm font-medium text-slate-700 mb-2">Nome da Feira <span class="text-red-500">*</span></label>
                        <input type="text" name="nome" id="nome" required value="{{ old('nome') }}" 
                               class="form-input" placeholder="Ex: Feira de Domingo na Praça">
                    </div>

                    <div class="md:col-span-2">
                        <label for="descricao" class="block text-sm font-medium text-slate-700 mb-2">Descrição (opcional)</label>
                        <textarea name="descricao" id="descricao" rows="3" 
                                  class="form-input">{{ old('descricao') }}</textarea>
                    </div>

                    <div>
                        <label for="data_inicio" class="block text-sm font-medium text-slate-700 mb-2">Data e Hora de Início <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="data_inicio" id="data_inicio" required value="{{ old('data_inicio') }}" 
                               class="form-input">
                    </div>

                    <div>
                        <label for="data_fim" class="block text-sm font-medium text-slate-700 mb-2">Data e Hora de Término <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="data_fim" id="data_fim" required value="{{ old('data_fim') }}" 
                               class="form-input">
                    </div>

                    <div class="md:col-span-2 mt-2 pt-4 border-t border-slate-100">
                        <h4 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4">Localização da Feira</h4>
                    </div>

                    <div class="md:col-span-2">
                        <label for="endereco" class="block text-sm font-medium text-slate-700 mb-2">Endereço <span class="text-red-500">*</span></label>
                        <input type="text" name="endereco" id="endereco" required value="{{ old('endereco') }}" 
                               class="form-input" placeholder="Rua, Avenida, Praça...">
                    </div>

                    <div>
                        <label for="cep" class="block text-sm font-medium text-slate-700 mb-2">CEP <span class="text-red-500">*</span></label>
                        <input type="text" name="cep" id="cep" required value="{{ old('cep') }}" data-mask="cep" 
                               class="form-input" placeholder="00000-000">
                    </div>
                    
                    <div class="flex gap-4">
                        <div class="flex-1">
                            <label for="cidade" class="block text-sm font-medium text-slate-700 mb-2">Cidade <span class="text-red-500">*</span></label>
                            <input type="text" name="cidade" id="cidade" required value="{{ old('cidade') }}" 
                                   class="form-input">
                        </div>
                        <div class="w-1/3">
                            <label for="estado" class="block text-sm font-medium text-slate-700 mb-2">UF <span class="text-red-500">*</span></label>
                            <input type="text" name="estado" id="estado" required maxlength="2" value="{{ old('estado') }}" 
                                   class="form-input uppercase text-center" placeholder="SP">
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="btn-primary text-lg px-8 py-3 flex items-center gap-2">
                        <i class="fas fa-save"></i> Criar Feira
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
