<?php

namespace App\Http\Controllers;

use App\Models\Carrinho;
use App\Models\ItemCarrinho;
use App\Models\Feira;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarrinhoController extends Controller
{
    public function index()
    {
        $carrinhos = Auth::user()->consumidor->carrinhos()->whereHas('items')->with(['feira', 'items.produto'])->get();
        return view('carrinho.index', compact('carrinhos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'feira_id' => 'required|exists:feiras,id',
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
        ]);

        $consumidorId = Auth::user()->consumidor->id;
        
        // Verificar se já existe carrinho para esta feira
        $carrinho = Carrinho::firstOrCreate([
            'consumidor_id' => $consumidorId,
            'feira_id' => $request->feira_id,
        ]);

        // Verificar se produto já está no carrinho
        $item = $carrinho->items()->where('produto_id', $request->produto_id)->first();
        
        if ($item) {
            $item->increment('quantidade', $request->quantidade);
        } else {
            $produto = Produto::find($request->produto_id);
            
            ItemCarrinho::create([
                'carrinho_id' => $carrinho->id,
                'produto_id' => $request->produto_id,
                'quantidade' => $request->quantidade,
                'preco_unitario' => $produto->preco,
            ]);
        }

        return redirect()->route('carrinho.index')
            ->with('success', 'Produto adicionado ao carrinho!');
    }

    public function update(Request $request, ItemCarrinho $item)
    {
        $this->authorize('update', $item);
        
        $request->validate([
            'quantidade' => 'required|integer|min:1',
        ]);

        $item->update(['quantidade' => $request->quantidade]);

        return redirect()->route('carrinho.index')
            ->with('success', 'Carrinho atualizado!');
    }

    public function destroy(ItemCarrinho $item)
    {
        $this->authorize('delete', $item);
        $item->delete();

        return redirect()->route('carrinho.index')
            ->with('success', 'Item removido do carrinho!');
    }

    public function limpar(Feira $feira)
    {
        $carrinho = Carrinho::where('consumidor_id', Auth::user()->consumidor->id)
                           ->where('feira_id', $feira->id)
                           ->first();
        
        if ($carrinho) {
            $carrinho->items()->delete();
        }

        return redirect()->route('carrinho.index')
            ->with('success', 'Carrinho limpo!');
    }
}