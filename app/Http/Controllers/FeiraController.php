<?php

namespace App\Http\Controllers;

use App\Models\Feira;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeiraController extends Controller
{
    public function index()
    {
        $feiras = Feira::where('ativa', true)
                      ->where('status', '!=', 'cancelada')
                      ->orderBy('data_inicio', 'asc')
                      ->get();
        
        return view('feiras.index', compact('feiras'));
    }

    public function create()
    {
        $produtos = Auth::user()->produtor->produtos ?? collect();
        return view('feiras.create', compact('produtos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after:data_inicio',
            'endereco' => 'required|string|max:255',
            'cidade' => 'required|string|max:100',
            'estado' => 'required|string|size:2',
            'cep' => 'required|string|max:10',
        ]);

        $feira = Feira::create([
            'produtor_id' => Auth::user()->produtor->id,
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'endereco' => $request->endereco,
            'cidade' => $request->cidade,
            'estado' => strtoupper($request->estado),
            'cep' => $request->cep,
            'status' => 'agendada',
            'ativa' => true,
        ]);

        // Vincular produtos selecionados e quantidades
        if ($request->has('produtos')) {
            $produtosSync = [];
            foreach ($request->produtos as $produtoId) {
                $qtde = $request->quantidades[$produtoId] ?? 0;
                $produtosSync[$produtoId] = ['quantidade_disponivel' => $qtde];
            }
            $feira->produtos()->sync($produtosSync);
        }

        return redirect()->route('feiras.index')
            ->with('success', 'Feira criada com sucesso!');
    }

    public function show(Feira $feira)
    {
        return view('feiras.show', compact('feira'));
    }

    public function edit(Feira $feira)
    {
        $this->authorize('update', $feira);
        $produtos = Auth::user()->produtor->produtos;
        return view('feiras.edit', compact('feira', 'produtos'));
    }

    public function update(Request $request, Feira $feira)
    {
        $this->authorize('update', $feira);
        
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after:data_inicio',
            'endereco' => 'required|string|max:255',
            'cidade' => 'required|string|max:100',
            'estado' => 'required|string|size:2',
            'cep' => 'required|string|max:10',
            'status' => 'required|in:agendada,em_andamento,concluida,cancelada',
        ]);

        $feira->update($request->all());

        // Atualizar produtos e quantidades
        $produtosSync = [];
        if ($request->has('produtos')) {
            foreach ($request->produtos as $produtoId) {
                $qtde = $request->quantidades[$produtoId] ?? 0;
                $produtosSync[$produtoId] = ['quantidade_disponivel' => $qtde];
            }
        }
        $feira->produtos()->sync($produtosSync);

        return redirect()->route('feiras.index')
            ->with('success', 'Feira atualizada com sucesso!');
    }

    public function destroy(Feira $feira)
    {
        $this->authorize('delete', $feira);
        $feira->update(['ativa' => false]);
        
        return redirect()->route('feiras.index')
            ->with('success', 'Feira desativada com sucesso!');
    }

    public function updateEstoque(Request $request, Feira $feira, Produto $produto)
    {
        $this->authorize('update', $feira);
        
        $request->validate([
            'quantidade_disponivel' => 'required|integer|min:0',
        ]);

        $feira->produtos()->updateExistingPivot($produto->id, [
            'quantidade_disponivel' => $request->quantidade_disponivel
        ]);

        return redirect()->route('feiras.show', $feira)
            ->with('success', 'Estoque do produto atualizado com sucesso!');
    }
}