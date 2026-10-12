<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Produtor;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function produtores()
    {
        $produtores = Produtor::with('usuario')->get();
        return view('admin.produtores.index', compact('produtores'));
    }

    public function destroyProdutor(Produtor $produtor)
    {
        // Ao excluir o usuário, o Produtor será excluído via cascade
        $produtor->usuario->delete();

        return redirect()->route('admin.produtores')
            ->with('success', 'Produtor excluído com sucesso!');
    }
}
