<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->isProdutor()) {
            $produtos = Produto::where('produtor_id', Auth::user()->produtor->id)
                              ->orderBy('created_at', 'desc')
                              ->paginate(12);
        } else {
            $produtos = Produto::where('disponivel', true)
                              ->orderBy('created_at', 'desc')
                              ->paginate(12);
        }
        
        return view('produtos.index', compact('produtos'));
    }

    public function create()
    {
        return view('produtos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'unidade_medida' => 'required|string|max:20',
            'foto' => 'nullable|image|max:2048',
            'organico' => 'boolean',
            'disponivel' => 'boolean',
        ]);

        $data = $request->except('foto');
        $data['produtor_id'] = Auth::user()->produtor->id;
        $data['organico'] = $request->has('organico');
        $data['disponivel'] = $request->has('disponivel');

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('produtos', 'public');
            $data['foto'] = $path;
        }

        Produto::create($data);

        return redirect()->route('produtos.index')
            ->with('success', 'Produto criado com sucesso!');
    }

    public function show(Produto $produto)
    {
        return view('produtos.show', compact('produto'));
    }

    public function edit(Produto $produto)
    {
        $this->authorize('update', $produto);
        return view('produtos.edit', compact('produto'));
    }

    public function update(Request $request, Produto $produto)
    {
        $this->authorize('update', $produto);
        
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'unidade_medida' => 'required|string|max:20',
            'foto' => 'nullable|image|max:2048',
            'organico' => 'boolean',
            'disponivel' => 'boolean',
        ]);

        $data = $request->except('foto');
        $data['organico'] = $request->has('organico');
        $data['disponivel'] = $request->has('disponivel');

        if ($request->hasFile('foto')) {
            // Remove foto antiga se existir
            if ($produto->foto) {
                Storage::disk('public')->delete($produto->foto);
            }
            
            $path = $request->file('foto')->store('produtos', 'public');
            $data['foto'] = $path;
        }

        $produto->update($data);

        return redirect()->route('produtos.index')
            ->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Produto $produto)
    {
        $this->authorize('delete', $produto);

        if ($produto->foto) {
            Storage::disk('public')->delete($produto->foto);
        }

        $produto->delete();
        
        return redirect()->route('produtos.index')
            ->with('success', 'Produto excluído com sucesso!');
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        
        $produtosQuery = Produto::query();

        if (Auth::check() && Auth::user()->isProdutor()) {
            $produtosQuery->where('produtor_id', Auth::user()->produtor->id);
        } else {
            $produtosQuery->where('disponivel', true);
        }

        $produtos = $produtosQuery->where(function($q) use ($query) {
                              $q->where('nome', 'LIKE', "%{$query}%")
                                ->orWhere('descricao', 'LIKE', "%{$query}%");
                          })
                          ->orderBy('created_at', 'desc')
                          ->paginate(12);
        
        return view('produtos.index', compact('produtos'));
    }
}