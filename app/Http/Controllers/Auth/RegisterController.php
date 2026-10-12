<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Produtor;
use App\Models\Consumidor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showProdutorRegistrationForm()
    {
        return view('auth.register-produtor');
    }

    public function showConsumidorRegistrationForm()
    {
        return view('auth.register-consumidor');
    }

    public function registerProdutor(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'tipo_documento' => 'required|in:cpf,cnpj',
            'documento' => 'required|string|unique:produtores,documento',
            'telefone' => 'required|string|max:20',
            'endereco' => 'required|string|max:255',
            'cidade' => 'required|string|max:100',
            'estado' => 'required|string|size:2',
            'cep' => 'required|string|max:10',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Criar usuário
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Criar produtor
        $produtor = Produtor::create([
            'usuario_id' => $user->id,
            'tipo_documento' => $validated['tipo_documento'],
            'documento' => $validated['documento'],
            'telefone' => $validated['telefone'],
            'endereco' => $validated['endereco'],
            'cidade' => $validated['cidade'],
            'estado' => $validated['estado'],
            'cep' => $validated['cep'],
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Cadastro realizado com sucesso!');
    }

    public function registerConsumidor(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'cpf' => 'required|string|unique:consumidores,cpf',
            'telefone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Criar usuário
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Criar consumidor
        $consumidor = Consumidor::create([
            'usuario_id' => $user->id,
            'cpf' => $validated['cpf'],
            'telefone' => $validated['telefone'],
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Cadastro realizado com sucesso!');
    }
}