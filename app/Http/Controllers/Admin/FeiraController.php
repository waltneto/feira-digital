<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Feira;

class FeiraController extends Controller
{
    public function index()
    {
        $feiras = Feira::orderBy('data_inicio', 'desc')->get();
        return view('admin.feiras.index', compact('feiras'));
    }

    public function create()
    {
        return view('admin.feiras.create');
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

        Feira::create([
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

        return redirect()->route('admin.feiras.index')
            ->with('success', 'Feira criada com sucesso!');
    }

    public function edit(Feira $feira)
    {
        return view('admin.feiras.edit', compact('feira'));
    }

    public function update(Request $request, Feira $feira)
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
            'status' => 'required|in:agendada,em_andamento,concluida,cancelada',
        ]);

        $feira->update($request->all());

        return redirect()->route('admin.feiras.index')
            ->with('success', 'Feira atualizada com sucesso!');
    }

    public function destroy(Feira $feira)
    {
        $feira->update(['ativa' => false]);
        return redirect()->route('admin.feiras.index')
            ->with('success', 'Feira desativada com sucesso!');
    }
}
