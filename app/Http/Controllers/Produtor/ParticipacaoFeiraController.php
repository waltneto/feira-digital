<?php

namespace App\Http\Controllers\Produtor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Feira;
use Illuminate\Support\Facades\Auth;

class ParticipacaoFeiraController extends Controller
{
    public function index()
    {
        // Lista feiras agendadas ou em andamento
        $feiras = Feira::whereIn('status', ['agendada', 'em_andamento'])
                       ->where('ativa', true)
                       ->orderBy('data_inicio', 'asc')
                       ->get();
        
        return view('produtor.feiras.index', compact('feiras'));
    }

    public function edit(Feira $feira)
    {
        $produtos = Auth::user()->produtor->produtos;
        return view('produtor.feiras.participar', compact('feira', 'produtos'));
    }

    public function update(Request $request, Feira $feira)
    {
        // Sincronizar os produtos selecionados e as quantidades do produtor
        $produtosSync = [];
        if ($request->has('produtos')) {
            foreach ($request->produtos as $produtoId) {
                $qtde = $request->quantidades[$produtoId] ?? 0;
                $produtosSync[$produtoId] = ['quantidade_disponivel' => $qtde];
            }
        }
        
        // O método syncWithoutDetaching para não remover os produtos de outros produtores
        // Primeiro precisamos pegar os produtos DESSE produtor que já estavam na feira para removê-los se não estiverem no request
        $produtosDoProdutor = Auth::user()->produtor->produtos()->pluck('id')->toArray();
        
        // Remove apenas os produtos deste produtor que estavam na feira
        $feira->produtos()->detach($produtosDoProdutor);
        
        // Adiciona os selecionados
        $feira->produtos()->attach($produtosSync);

        return redirect()->route('produtor.feiras.participacao')
            ->with('success', 'Participação atualizada com sucesso!');
    }
}
