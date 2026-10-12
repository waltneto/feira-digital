<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\ItemPedido;
use App\Models\Carrinho;
use App\Models\ItemCarrinho;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Auth::user()->consumidor->pedidos()
            ->with('feira')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('pedidos.index', compact('pedidos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'feira_id' => 'required|exists:feiras,id',
            'horario_retirada' => 'required|date_format:H:i',
        ]);

        $consumidor = Auth::user()->consumidor;
        
        // Encontrar carrinho para esta feira
        $carrinho = Carrinho::where('consumidor_id', $consumidor->id)
                           ->where('feira_id', $request->feira_id)
                           ->first();

        if (!$carrinho || $carrinho->items->isEmpty()) {
            return redirect()->route('carrinho.index')
                ->with('error', 'Carrinho vazio!');
        }

        // Calcular total
        $total = $carrinho->items->sum(function ($item) {
            return $item->quantidade * $item->preco_unitario;
        });

        // Criar pedido
        $pedido = Pedido::create([
            'consumidor_id' => $consumidor->id,
            'feira_id' => $request->feira_id,
            'codigo_pedido' => 'PED' . time() . rand(1000, 9999),
            'status' => 'pendente',
            'total' => $total,
            'horario_retirada' => $request->horario_retirada,
        ]);

        // Transferir itens do carrinho para o pedido
        foreach ($carrinho->items as $itemCarrinho) {
            ItemPedido::create([
                'pedido_id' => $pedido->id,
                'produto_id' => $itemCarrinho->produto_id,
                'quantidade' => $itemCarrinho->quantidade,
                'preco_unitario' => $itemCarrinho->preco_unitario,
            ]);
        }

        // Limpar carrinho
        $carrinho->items()->delete();

        return redirect()->route('pedidos.show', $pedido)
            ->with('success', 'Pedido finalizado! Dirija-se até a feira e efetue o pagamento ao produtor.');
    }

    public function show(Pedido $pedido)
    {
        $this->authorize('view', $pedido);
        return view('pedidos.show', compact('pedido'));
    }

    public function pedidosProdutor()
    {
        $produtor = Auth::user()->produtor;
        
        // Buscar todos os pedidos que contenham pelo menos um produto deste produtor
        $pedidos = Pedido::whereHas('items.produto', function($query) use ($produtor) {
            $query->where('produtor_id', $produtor->id);
        })
            ->with(['consumidor.user', 'feira', 'items' => function($query) use ($produtor) {
                // Carregar apenas os itens que pertencem a este produtor
                $query->whereHas('produto', function($q) use ($produtor) {
                    $q->where('produtor_id', $produtor->id);
                })->with('produto');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('produtor.pedidos.index', compact('pedidos'));
    }

    public function concluirPedido(Pedido $pedido)
    {
        $produtor = Auth::user()->produtor;

        // Verificar se esse pedido possui itens deste produtor
        $temProdutoDoProdutor = $pedido->items()->whereHas('produto', function($q) use ($produtor) {
            $q->where('produtor_id', $produtor->id);
        })->exists();

        if (!$temProdutoDoProdutor) {
            abort(403, 'Ação não autorizada.');
        }

        // Evitar concluir mais de uma vez
        if ($pedido->status === 'entregue') {
            return back()->with('error', 'Pedido já foi concluído/entregue.');
        }

        // Baixa no estoque da feira para cada item
        foreach ($pedido->items as $item) {
            $produto = $item->produto;
            
            // Verifica registro do produto na feira
            $feiraProduto = $pedido->feira->produtos()->where('produto_id', $produto->id)->first();
            
            if ($feiraProduto) {
                $quantidadeAtual = $feiraProduto->pivot->quantidade_disponivel ?? 0;
                $novaQuantidade = max(0, $quantidadeAtual - $item->quantidade);

                $pedido->feira->produtos()->updateExistingPivot($produto->id, [
                    'quantidade_disponivel' => $novaQuantidade
                ]);
            }
        }

        $pedido->update(['status' => 'entregue']);

        return back()->with('success', 'Pagamento confirmado e estoque baixado!');
    }

    public function cancelarPedido(Pedido $pedido)
    {
        $produtor = Auth::user()->produtor;

        // Verificar se esse pedido possui itens deste produtor
        $temProdutoDoProdutor = $pedido->items()->whereHas('produto', function($q) use ($produtor) {
            $q->where('produtor_id', $produtor->id);
        })->exists();

        if (!$temProdutoDoProdutor) {
            abort(403, 'Ação não autorizada.');
        }

        // Evitar cancelar pedido que não esteja pendente
        if ($pedido->status !== 'pendente') {
            return back()->with('error', 'Apenas pedidos pendentes podem ser cancelados.');
        }

        $pedido->update(['status' => 'cancelado']);

        return back()->with('success', 'Pedido cancelado.');
    }
}